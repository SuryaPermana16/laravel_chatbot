<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Dokter;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $dokter = Dokter::where('user_id', Auth::id())->first();

        if (!$dokter) {
            abort(403, 'Profil Dokter tidak ditemukan untuk akun ini. Hubungi Admin.');
        }

        $hariIni = Carbon::today()->toDateString();

        // 1. Antrean Berjalan (Status: menunggu atau diperiksa)
        $antreans = Kunjungan::with('pasien')
                    ->where('dokter_id', $dokter->id)
                    ->where('tanggal_kunjungan', $hariIni)
                    ->whereIn('status', ['menunggu', 'diperiksa'])
                    ->orderBy('no_antrian', 'asc')
                    ->get();

        // 2. Riwayat Pasien (Semua status KECUALI yang masih mengantre/diperiksa)
        // Ini memastikan pasien tetap muncul meskipun sudah membayar di apotek
        $riwayat = Kunjungan::with(['pasien', 'rekamMedis']) 
                    ->where('dokter_id', $dokter->id)
                    ->where('tanggal_kunjungan', $hariIni)
                    ->whereNotIn('status', ['menunggu', 'diperiksa']) 
                    ->latest('updated_at') 
                    ->take(5)
                    ->get();

        // 3. Statistik Card
        $totalAntrean = Kunjungan::where('dokter_id', $dokter->id)
                                 ->where('tanggal_kunjungan', $hariIni)
                                 ->count();
                                 
        $sisaAntrean = $antreans->count();
        
        $selesaiPeriksa = Kunjungan::where('dokter_id', $dokter->id)
                                   ->where('tanggal_kunjungan', $hariIni)
                                   ->whereNotIn('status', ['menunggu', 'diperiksa'])
                                   ->count();

        return view('dokter.dashboard', compact(
            'dokter', 
            'antreans', 
            'riwayat', 
            'totalAntrean', 
            'sisaAntrean', 
            'selesaiPeriksa'
        ));
    }
}