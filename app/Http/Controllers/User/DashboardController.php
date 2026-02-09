<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalDokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Set locale Carbon ke Indonesia agar menghasilkan nama hari "Senin", "Selasa", dsb.
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        
        // 2. Ambil nama hari ini (Contoh: "Senin")
        $hariIni = Carbon::now()->isoFormat('dddd');

        // 3. Ambil jadwal dokter yang HANYA praktek hari ini saja
        $jadwals = JadwalDokter::with('dokter')
                    ->where('hari', $hariIni)
                    ->get();

        // 4. Ambil riwayat kunjungan khusus untuk pasien yang sedang login
        $pasien = Pasien::where('user_id', Auth::id())->first();

        $riwayat = [];
        if ($pasien) {
            $riwayat = Kunjungan::with('dokter')
                        ->where('pasien_id', $pasien->id)
                        ->latest() // Urutkan dari pendaftaran terbaru
                        ->get();
        }
        
        // 5. Kirim variabel $hariIni ke view agar bisa ditampilkan di judul
        return view('user.dashboard', compact('jadwals', 'riwayat', 'hariIni'));
    }
}