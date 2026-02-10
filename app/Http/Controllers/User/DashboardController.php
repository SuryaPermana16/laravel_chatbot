<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalDokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Dokter; // <--- Jangan lupa import model Dokter
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Config Locale
        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');
        $hariIni = \Carbon\Carbon::now()->isoFormat('dddd');

        // 2. Data Statistik & List untuk Modal (UPDATE DISINI)
        $totalDokter = Dokter::count();
        $totalSpesialis = Dokter::distinct('spesialis')->count('spesialis');
        
        // Ambil data detail untuk modal
        $daftarSpesialis = Dokter::distinct('spesialis')->pluck('spesialis'); // List nama spesialis unik
        $daftarDokter = Dokter::all(); // List semua dokter

        // 3. Ambil Jadwal Dokter Hari Ini
        $jadwals = JadwalDokter::with('dokter')
                    ->where('hari', $hariIni)
                    ->get();

        // 4. Riwayat Kunjungan Pasien
        $pasien = Pasien::where('user_id', Auth::id())->first();
        $riwayat = [];
        if ($pasien) {
            $riwayat = Kunjungan::with('dokter')
                        ->where('pasien_id', $pasien->id)
                        ->latest()
                        ->get();
        }
        
        // 5. Kirim semua data ke View
        return view('user.dashboard', compact(
            'jadwals', 
            'riwayat', 
            'hariIni',
            'totalDokter',
            'totalSpesialis',
            'daftarSpesialis', // <--- Kirim variable baru ini
            'daftarDokter'     // <--- Kirim variable baru ini
        ));
    }
}