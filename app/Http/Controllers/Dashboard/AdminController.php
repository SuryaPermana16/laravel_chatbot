<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\JadwalDokter;

class AdminController extends Controller
{
    public function index()
    {
        // Hitung data untuk statistik dashboard
        $total_pasien = Pasien::count();
        $total_dokter = Dokter::count();
        $total_obat = Obat::count();
        $total_jadwal = JadwalDokter::count();
        
        // Contoh data dummy untuk kunjungan (nanti bisa diganti real dari tabel Kunjungan)
        $kunjungan_hari_ini = 0; 

        return view('admin.dashboard', compact(
            'total_pasien', 
            'total_dokter', 
            'total_obat', 
            'total_jadwal',
            'kunjungan_hari_ini'
        ));
    }
}