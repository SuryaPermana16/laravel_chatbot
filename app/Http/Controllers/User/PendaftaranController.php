<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalDokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    // 1. TAMPILKAN FORMULIR PENDAFTARAN
    public function showForm($id_jadwal)
    {
        // Ambil data jadwal yang dipilih beserta informasi dokternya
        $jadwal = JadwalDokter::with('dokter')->findOrFail($id_jadwal);
        
        return view('user.pendaftaran', compact('jadwal'));
    }

    // 2. PROSES SIMPAN DATA (BOOKING DENGAN PILIHAN JAM)
    public function store(Request $request, $id_jadwal)
    {
        // Validasi input: keluhan wajib diisi, jam_pilihan wajib dipilih
        $request->validate([
            'keluhan' => 'required|string|max:255',
            'jam_pilihan' => 'required', 
        ]);

        $jadwal = JadwalDokter::findOrFail($id_jadwal);
        
        // Cari data Pasien berdasarkan User yang sedang login
        $pasien = Pasien::where('user_id', Auth::id())->first();

        // Cek apakah user ini terdaftar di tabel pasiens
        if (!$pasien) {
            return back()->with('error', 'Data pasien tidak ditemukan. Silakan hubungi admin klinik.');
        }

        // LOGIKA TANGGAL: Mencari tanggal praktek terdekat sesuai Hari di Jadwal
        $hari_indonesia = [
            'Senin' => Carbon::MONDAY,
            'Selasa' => Carbon::TUESDAY,
            'Rabu' => Carbon::WEDNESDAY,
            'Kamis' => Carbon::THURSDAY,
            'Jumat' => Carbon::FRIDAY,
            'Sabtu' => Carbon::SATURDAY,
            'Minggu' => Carbon::SUNDAY,
        ];

        $target_hari = $hari_indonesia[$jadwal->hari];
        $tanggal_kunjungan = Carbon::now();

        // Geser tanggal sampai bertemu hari yang sesuai dengan jadwal praktek
        while ($tanggal_kunjungan->dayOfWeekIso != $target_hari) {
            $tanggal_kunjungan->addDay();
        }

        // LOGIKA ANTRIAN: Menghitung jumlah pendaftar pada hari tersebut untuk menentukan nomor urut
        $jumlah_antrian = Kunjungan::where('dokter_id', $jadwal->dokter_id)
            ->whereDate('tanggal_kunjungan', $tanggal_kunjungan)
            ->count();
        
        $no_antrian_baru = $jumlah_antrian + 1;

        // SIMPAN KE DATABASE
        Kunjungan::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $jadwal->dokter_id,
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'no_antrian' => $no_antrian_baru,
            'jam_pilihan' => $request->jam_pilihan, // Menyimpan jam kedatangan yang dipilih pasien
            'keluhan' => $request->keluhan,
            'status' => 'menunggu'
        ]);

        // LOGIKA PENGINGAT: Hitung estimasi waktu kehadiran (15 menit sebelum jam terpilih)
        $wajib_hadir = date('H:i', strtotime($request->jam_pilihan . ' -15 minutes'));

        // Redirect kembali ke dashboard dengan pesan sukses berisi instruksi waktu hadir
        return redirect()->route('user.dashboard')->with('success', 
            "Berhasil mendaftar! No Antrian Anda: $no_antrian_baru. Mohon hadir di klinik pukul $wajib_hadir untuk verifikasi pendaftaran."
        );
    }
}