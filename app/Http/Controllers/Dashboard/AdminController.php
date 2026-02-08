<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Obat;
// use App\Models\Kunjungan; // Aktifkan jika sudah ada model Kunjungan

class AdminController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Statistik
        $total_pasien = User::where('role', 'pasien')->count();
        $total_dokter = User::where('role', 'dokter')->count();
        $total_obat = Obat::count();
        $kunjungan_hari_ini = 0; // Placeholder

        // 2. Kirim ke View (PATH SUDAH DIPERBAIKI)
        return view('admin.dashboard', compact(
            'total_pasien', 
            'total_dokter', 
            'total_obat',
            'kunjungan_hari_ini'
        ));
    }
}