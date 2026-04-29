<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\ResepObat;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriksaController extends Controller
{
    public function periksa($id)
    {
        $kunjungan = Kunjungan::with('pasien')->findOrFail($id);
        $obats = Obat::where('stok', '>', 0)->get();

        return view('dokter.periksa', compact('kunjungan', 'obats'));
    }

    public function simpanPeriksa(Request $request, $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        $request->validate([
            'diagnosa'       => 'required|string',
            'obat_id'        => 'nullable|array',
            'obat_id.*'      => 'exists:obats,id',
            'jumlah'         => 'nullable|array',
            'jumlah.*'       => 'numeric|min:1',
            'aturan_minum'   => 'nullable|array',
            'aturan_minum.*' => 'string',
        ]);

        DB::beginTransaction();

        try {
            $kunjungan->update([
                'diagnosa' => $request->diagnosa,
                'status'   => 'selesai',
            ]);

            $rekamMedis = RekamMedis::create([
                'kunjungan_id'        => $kunjungan->id,
                'tgl_periksa'         => now()->format('Y-m-d'),
                'keluhan'             => $kunjungan->keluhan,
                'pemeriksaan_fisik'   => '-',
                'diagnosa'            => $request->diagnosa,
                'tindakan'            => '-',
                'keterangan_tambahan' => '-'
            ]);

            if ($request->has('obat_id') && count($request->obat_id) > 0) {
                foreach ($request->obat_id as $index => $id_obat) {
                    $qty = $request->jumlah[$index];
                    $aturan = $request->aturan_minum[$index];

                    ResepObat::create([
                        'rekam_medis_id' => $rekamMedis->id,
                        'obat_id'        => $id_obat,
                        'jumlah'         => $qty,
                        'dosis'          => $aturan
                    ]);

                    $obat = Obat::find($id_obat);

                    if ($obat) {
                        $obat->decrement('stok', $qty);
                    }
                }
            }

            DB::commit();

            return redirect()->route('dokter.dashboard')
                ->with('success', 'Pemeriksaan selesai! Rekam medis berhasil dibuat dan resep otomatis memotong stok.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat menyimpan data: ' . $e->getMessage());
        }
    }
}