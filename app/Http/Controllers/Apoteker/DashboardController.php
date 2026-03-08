<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Obat (Stok > 0) agar yang habis tidak muncul di pilihan
        $obats = Obat::where('stok', '>', 0)->latest()->get();

        // 2. Ambil Data Antrean (Status 'selesai' dari Dokter, Belum Bayar)
        $antreanObat = Kunjungan::with(['pasien', 'dokter'])
                        ->where('status', 'selesai')
                        ->whereNotNull('resep_obat')
                        ->latest()
                        ->get();

        // 3. Ambil Riwayat Transaksi (Status 'diambil', Sudah Bayar)
        $riwayatTransaksi = Kunjungan::with(['pasien', 'dokter'])
                        ->where('status', 'diambil') // Filter status lunas
                        ->latest()                   // Urutkan dari yang terbaru
                        ->take(5)                    // Ambil 5 data saja biar ringan
                        ->get();

        return view('apoteker.dashboard', compact('antreanObat', 'obats', 'riwayatTransaksi'));
    }

    public function selesai(Request $request, $id)
    {
        // Validasi: Tambahkan validasi metode_pembayaran
        $request->validate([
            'obat_id' => 'required|array',
            'obat_id.*' => 'exists:obats,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'metode_pembayaran' => 'required|in:Umum,BPJS', // Validasi BPJS / Umum
        ]);

        $kunjungan = Kunjungan::with('dokter')->findOrFail($id);
        
        // Gunakan Transaction agar data aman
        DB::beginTransaction();

        try {
            $totalBiayaObat = 0;

            // Loop setiap obat yang dipilih di keranjang
            foreach ($request->obat_id as $key => $obatId) {
                $qty = $request->jumlah[$key];
                $obat = Obat::findOrFail($obatId);

                // 1. Cek Stok Lagi
                if ($obat->stok < $qty) {
                    return back()->with('error', 'Stok obat ' . $obat->nama_obat . ' tidak cukup! Sisa: ' . $obat->stok);
                }

                // 2. KURANGI STOK (Tetap berjalan walau pasien BPJS)
                $obat->decrement('stok', $qty);

                // 3. Hitung Subtotal Harga Asli
                $subtotal = $obat->harga * $qty;
                $totalBiayaObat += $subtotal;

                // 4. Simpan ke Tabel Pivot
                $kunjungan->obat()->attach($obatId, [
                    'jumlah' => $qty,
                    'harga_satuan' => $obat->harga,
                    'subtotal' => $subtotal
                ]);
            }

            // 5. LOGIKA PERHITUNGAN UMUM vs BPJS
            $biayaJasa = $kunjungan->dokter->harga_jasa;
            $metode = $request->metode_pembayaran;
            
            if ($metode == 'BPJS') {
                // Jika BPJS, total yang ditagihkan ke pasien adalah NOL
                $totalBayar = 0;
                $statusBayar = 'Klaim BPJS';
            } else {
                // Jika UMUM, bayar penuh (Jasa + Obat)
                $totalBayar = $biayaJasa + $totalBiayaObat;
                $statusBayar = 'Lunas';
            }

            // 6. Update Data Utama Kunjungan
            $kunjungan->update([
                'biaya_jasa_dokter' => $biayaJasa,
                'biaya_obat' => $totalBiayaObat,
                'total_bayar' => $totalBayar, 
                'status_pembayaran' => $statusBayar, 
                'status' => 'diambil' 
            ]);

            DB::commit(); // Simpan permanen

            return redirect()->route('apoteker.dashboard')
                ->with('success', 'Transaksi ' . $metode . ' Berhasil! Stok obat otomatis terpotong.');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika ada error
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}