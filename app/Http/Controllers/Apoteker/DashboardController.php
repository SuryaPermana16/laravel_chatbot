<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil pasien yang statusnya 'selesai' dari dokter & punya resep
        $antreanObat = Kunjungan::with('pasien')
                        ->where('status', 'selesai')
                        ->whereNotNull('resep_obat')
                        ->latest()
                        ->get();

        return view('apoteker.dashboard', compact('antreanObat'));
    }

    public function selesai($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        
        // Update status agar pasien dianggap sudah selesai di apotek
        $kunjungan->update([
            'status' => 'diambil'
        ]);

        return redirect()->route('apoteker.dashboard')->with('success', 'Obat telah diserahkan ke pasien!');
    }
}