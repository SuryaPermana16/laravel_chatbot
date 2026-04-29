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
        $obats = Obat::where('stok', '>', 0)->latest()->get();

        $antreanObat = Kunjungan::with(['pasien', 'dokter'])
            ->where('status', 'selesai')
            ->latest()
            ->get();

        $riwayatTransaksi = Kunjungan::with(['pasien', 'dokter'])
            ->where('status', 'diambil')
            ->latest()
            ->take(5)
            ->get();

        return view('apoteker.dashboard', compact('antreanObat', 'obats', 'riwayatTransaksi'));
    }

    public function selesai(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:Umum,BPJS',
        ]);

        $kunjungan = Kunjungan::with('dokter')->findOrFail($id);

        DB::beginTransaction();

        try {
            $totalBiayaObat = 0;

            $rekamMedis = \App\Models\RekamMedis::where('kunjungan_id', $kunjungan->id)->first();

            if ($rekamMedis) {
                $reseps = \App\Models\ResepObat::where('rekam_medis_id', $rekamMedis->id)->get();

                foreach ($reseps as $resep) {
                    $obat = Obat::find($resep->obat_id);

                    if ($obat) {
                        $totalBiayaObat += ($obat->harga * $resep->jumlah);
                    }
                }
            }

            $biayaJasa = $kunjungan->dokter->harga_jasa ?? 0;
            $metode = $request->metode_pembayaran;

            if ($metode == 'BPJS') {
                $totalBayar = 0;
                $statusBayar = 'Klaim BPJS';
            } else {
                $totalBayar = $biayaJasa + $totalBiayaObat;
                $statusBayar = 'Lunas';
            }

            $kunjungan->update([
                'biaya_jasa_dokter' => $biayaJasa,
                'biaya_obat'        => $totalBiayaObat,
                'total_bayar'       => $totalBayar,
                'status_pembayaran' => $statusBayar,
                'status'            => 'diambil'
            ]);

            DB::commit();

            return redirect()->route('apoteker.dashboard')
                ->with('success', 'Pembayaran ' . $metode . ' Berhasil! Silakan serahkan obat ke pasien.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}