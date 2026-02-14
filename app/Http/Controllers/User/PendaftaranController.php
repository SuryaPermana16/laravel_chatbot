<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\JadwalDokter;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    public function showForm($id_jadwal)
    {
        // 1. Set Locale & Timezone WITA
        Carbon::setLocale('id');
        $now = Carbon::now('Asia/Makassar'); 

        $jadwal = JadwalDokter::with('dokter')->findOrFail($id_jadwal);
        
        // 2. Tentukan Tanggal Kunjungan
        $hariIni = $now->translatedFormat('l');
        
        if (strtolower($jadwal->hari) == strtolower($hariIni)) {
            // Jika jam tutup praktek belum lewat, bisa daftar hari ini
            if ($now->format('H:i') < $jadwal->jam_selesai) {
                $tanggalKunjungan = $now->format('Y-m-d');
            } else {
                $tanggalKunjungan = Carbon::parse('next ' . $jadwal->hari)->format('Y-m-d');
            }
        } else {
            $tanggalKunjungan = Carbon::parse('next ' . $jadwal->hari)->format('Y-m-d');
        }

        // 3. Generate Slot Waktu
        $jamBuka = Carbon::parse($jadwal->jam_mulai);
        $jamTutup = Carbon::parse($jadwal->jam_selesai);
        $slots = [];

        // Ambil jam yang sudah dibooking
        $bookedSlots = Kunjungan::where('dokter_id', $jadwal->dokter_id)
                        ->whereDate('tanggal_kunjungan', $tanggalKunjungan)
                        ->whereNotIn('status', ['batal']) 
                        ->pluck('jam_pilihan')
                        ->map(fn($jam) => Carbon::parse($jam)->format('H:i'))
                        ->toArray();

        $isToday = ($tanggalKunjungan == $now->format('Y-m-d'));

        while ($jamBuka->lt($jamTutup)) {
            $jamStart = $jamBuka->format('H:i');
            
            // LOGIC REALTIME: 
            // Jika pendaftaran untuk HARI INI, dan jam slot kurang dari jam SEKARANG (WITA)
            // Maka slot dianggap 'Lewat'
            $isPast = ($isToday && $jamStart <= $now->format('H:i'));
            $isBooked = in_array($jamStart, $bookedSlots);

            $status = 'Tersedia';
            if ($isBooked) $status = 'Penuh';
            if ($isPast) $status = 'Lewat';

            $slots[] = [
                'jam' => $jamStart,
                'available' => ($status == 'Tersedia'),
                'status' => $status
            ];

            $jamBuka->addMinutes(20);
        }

        return view('user.pendaftaran', compact('jadwal', 'slots', 'tanggalKunjungan'));
    }

    public function store(Request $request, $id_jadwal)
    {
        $now = Carbon::now('Asia/Makassar');

        $request->validate([
            'jam_pilihan' => 'required',
            'keluhan' => 'required|string',
            'tanggal_kunjungan' => 'required|date'
        ]);

        // Cek lagi di Backend agar tidak kecolongan lewat inspect element
        $isToday = ($request->tanggal_kunjungan == $now->format('Y-m-d'));
        if ($isToday && $request->jam_pilihan <= $now->format('H:i')) {
            return back()->with('error', 'Waktu sudah terlewati. Silakan pilih jam lain.');
        }

        $jadwal = JadwalDokter::findOrFail($id_jadwal);
        $pasien = Auth::user()->pasien;

        if (!$pasien) {
            return back()->with('error', 'Lengkapi profil pasien terlebih dahulu.');
        }

        $cekBentrok = Kunjungan::where('dokter_id', $jadwal->dokter_id)
                    ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
                    ->where('jam_pilihan', $request->jam_pilihan)
                    ->whereNotIn('status', ['batal'])
                    ->exists();

        if ($cekBentrok) {
            return back()->with('error', 'Jam tersebut baru saja dipesan orang lain.');
        }

        $urutan = Kunjungan::where('dokter_id', $jadwal->dokter_id)
                    ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
                    ->count() + 1;
        
        $noAntrian = 'A-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

        Kunjungan::create([
            'id_pasien' => $pasien->id,
            'dokter_id' => $jadwal->dokter_id,
            'jadwal_id' => $id_jadwal,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_pilihan' => $request->jam_pilihan,
            'no_antrian' => $noAntrian,
            'keluhan' => $request->keluhan,
            'status' => 'menunggu',
            'total_bayar' => 0
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Berhasil! Antrian Anda: ' . $noAntrian);
    }
}