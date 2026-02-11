<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Dokter;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Cari profil dokter berdasarkan user yang sedang login
        // (Asumsi: di tabel dokters ada kolom user_id yang terhubung ke tabel users)
        $dokter = Dokter::where('user_id', Auth::id())->first();

        if (!$dokter) {
            // Jika akun ini belum di-link ke profil dokter, tampilkan error
            abort(403, 'Profil Dokter tidak ditemukan untuk akun ini. Hubungi Admin.');
        }

        $hariIni = Carbon::today()->toDateString();

        // 2. Ambil daftar antrean HARI INI khusus untuk dokter ini
        // Hanya tampilkan yang berstatus 'menunggu' atau 'diperiksa'
        $antreans = Kunjungan::with('pasien')
                    ->where('dokter_id', $dokter->id)
                    ->where('tanggal_kunjungan', $hariIni)
                    ->whereIn('status', ['menunggu', 'diperiksa'])
                    ->orderBy('no_antrian', 'asc')
                    ->get();

        // 3. Hitung statistik untuk Card di Dashboard
        $totalAntrean = Kunjungan::where('dokter_id', $dokter->id)
                                 ->where('tanggal_kunjungan', $hariIni)
                                 ->count();
                                 
        $sisaAntrean = $antreans->count();
        
        $selesaiPeriksa = Kunjungan::where('dokter_id', $dokter->id)
                                   ->where('tanggal_kunjungan', $hariIni)
                                   ->whereIn('status', ['menunggu_obat', 'selesai'])
                                   ->count();

        // 4. Kirim data ke View
        return view('dokter.dashboard', compact('dokter', 'antreans', 'totalAntrean', 'sisaAntrean', 'selesaiPeriksa'));
    }
}