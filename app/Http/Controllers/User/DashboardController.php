<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalDokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Dokter;
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

        // 2. Data Statistik & List untuk Modal
        $totalDokter = Dokter::count();
        $totalSpesialis = Dokter::distinct('spesialis')->count('spesialis');
        $daftarSpesialis = Dokter::distinct('spesialis')->pluck('spesialis'); 
        $daftarDokter = Dokter::all(); 

        // 3. Ambil SEMUA Jadwal Dokter (Fitur Advance Booking)
        $jadwals = JadwalDokter::with('dokter')
                    ->get()
                    ->unique('dokter_id')
                    ->values();

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
            'daftarSpesialis', 
            'daftarDokter'    
        ));
    }
}