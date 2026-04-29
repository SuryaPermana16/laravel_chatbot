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
        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');

        $hariIni = \Carbon\Carbon::now()->isoFormat('dddd');

        $totalDokter = Dokter::count();
        $totalSpesialis = Dokter::distinct('spesialis')->count('spesialis');
        $daftarSpesialis = Dokter::distinct('spesialis')->pluck('spesialis');
        $daftarDokter = Dokter::all();

        $jadwals = JadwalDokter::with('dokter')
            ->get()
            ->unique('dokter_id')
            ->values();

        $pasien = Pasien::where('user_id', Auth::id())->first();
        $riwayat = [];

        if ($pasien) {
            $riwayat = Kunjungan::with('dokter')
                ->where('pasien_id', $pasien->id)
                ->latest()
                ->get();
        }

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