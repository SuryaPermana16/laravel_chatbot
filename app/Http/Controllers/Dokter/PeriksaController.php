<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class PeriksaController extends Controller
{
    // Menampilkan halaman periksa
    public function periksa($id)
    {
        $kunjungan = Kunjungan::with('pasien')->findOrFail($id);
        return view('dokter.periksa', compact('kunjungan'));
    }

    // Menyimpan hasil periksa & resep
    public function simpanPeriksa(Request $request, $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        $request->validate([
            'diagnosa'   => 'required|string',
            'resep_obat' => 'required|string',
        ]);

        $kunjungan->update([
            'diagnosa'   => $request->diagnosa,
            'resep_obat' => $request->resep_obat,
            'status'     => 'selesai', // Otomatis pindah ke Dashboard Apoteker
        ]);

        return redirect()->route('dokter.dashboard')->with('success', 'Pasien berhasil diperiksa dan resep dikirim!');
    }
}