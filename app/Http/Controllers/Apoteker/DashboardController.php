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

        // --- [UPDATE BARU DISINI] ---
        // 3. Ambil Riwayat Transaksi (Status 'diambil', Sudah Bayar)
        $riwayatTransaksi = Kunjungan::with(['pasien', 'dokter'])
                        ->where('status', 'diambil') // Filter status lunas
                        ->latest()                   // Urutkan dari yang terbaru
                        ->take(5)                    // Ambil 5 data saja biar ringan
                        ->get();

        // Jangan lupa tambahkan 'riwayatTransaksi' ke dalam compact
        return view('apoteker.dashboard', compact('antreanObat', 'obats', 'riwayatTransaksi'));
    }

    public function selesai(Request $request, $id)
    {
        // Validasi: Harus pilih obat dan jumlah
        $request->validate([
            'obat_id' => 'required|array',
            'obat_id.*' => 'exists:obats,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ]);

        $kunjungan = Kunjungan::with('dokter')->findOrFail($id);
        
        // Gunakan Transaction agar data aman (kalau gagal satu, batal semua)
        DB::beginTransaction();

        try {
            $totalBiayaObat = 0;

            // Loop setiap obat yang dipilih di keranjang
            foreach ($request->obat_id as $key => $obatId) {
                $qty = $request->jumlah[$key];
                $obat = Obat::findOrFail($obatId);

                // 1. Cek Stok Lagi (Penting!)
                if ($obat->stok < $qty) {
                    return back()->with('error', 'Stok obat ' . $obat->nama_obat . ' tidak cukup! Sisa: ' . $obat->stok);
                }

                // 2. Kurangi Stok
                $obat->decrement('stok', $qty);

                // 3. Hitung Subtotal
                $subtotal = $obat->harga * $qty;
                $totalBiayaObat += $subtotal;

                // 4. Simpan ke Tabel Pivot (Detail Transaksi)
                $kunjungan->obat()->attach($obatId, [
                    'jumlah' => $qty,
                    'harga_satuan' => $obat->harga,
                    'subtotal' => $subtotal
                ]);
            }

            // 5. Update Data Utama Kunjungan
            $biayaJasa = $kunjungan->dokter->harga_jasa;
            $totalBayar = $biayaJasa + $totalBiayaObat;

            $kunjungan->update([
                'biaya_jasa_dokter' => $biayaJasa,
                'biaya_obat' => $totalBiayaObat,
                'total_bayar' => $totalBayar,
                'status' => 'diambil' // Status berubah jadi 'diambil' (Lunas)
            ]);

            DB::commit(); // Simpan permanen

            return redirect()->route('apoteker.dashboard')
                ->with('success', 'Transaksi Berhasil! Stok berkurang. Total: Rp ' . number_format($totalBayar, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika ada error
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}