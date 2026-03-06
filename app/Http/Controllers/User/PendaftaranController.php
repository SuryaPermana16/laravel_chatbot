<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\JadwalDokter;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; 
use App\Mail\NotifikasiAntrian;      
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    public function showForm(Request $request, $id_jadwal)
    {
        Carbon::setLocale('id');
        $now = Carbon::now('Asia/Makassar'); 

        // 1. Ambil Data Dokter dari ID jadwal yang diklik
        $jadwalReferensi = JadwalDokter::with('dokter')->findOrFail($id_jadwal);
        $dokter = $jadwalReferensi->dokter;

        // Urutan hari standar (Senin ke Minggu)
        $urutanHari = [
            'senin' => 1, 'selasa' => 2, 'rabu' => 3, 
            'kamis' => 4, 'jumat' => 5, 'sabtu' => 6, 'minggu' => 7
        ];

        // Ambil SEMUA jadwal hari praktek dan urutkan sesuai hari
        $semuaJadwal = JadwalDokter::where('dokter_id', $dokter->id)
                        ->get()
                        ->sortBy(function($j) use ($urutanHari) {
                            return $urutanHari[strtolower($j->hari)] ?? 99;
                        })->values(); // values() digunakan untuk me-reset nomor index array

        // Buat list dan string hari praktek dari data yang SUDAH berurutan
        $hariPraktekList = $semuaJadwal->map(fn($j) => strtolower($j->hari))->toArray();
        $hariPraktekString = implode(', ', $semuaJadwal->pluck('hari')->toArray());

        // 2. TENTUKAN TANGGAL & JADWAL AKTIF (Berdasarkan Kalender)
        if ($request->has('tanggal')) {
            $tanggalKunjungan = $request->tanggal;
            $hariPilihan = strtolower(Carbon::parse($tanggalKunjungan)->translatedFormat('l'));

            // Validasi: Cegah booking ke masa lalu
            if ($tanggalKunjungan < $now->format('Y-m-d')) {
                return redirect()->route('user.daftar', $id_jadwal)->with('error', 'Tidak dapat melakukan reservasi untuk tanggal yang sudah terlewat.');
            }

            // Validasi: Pastikan hari yang dipilih di kalender SAMA dengan jadwal praktek
            if (!in_array($hariPilihan, $hariPraktekList)) {
                return redirect()->route('user.daftar', $id_jadwal)->with('error', 'Dokter tidak praktek di hari tersebut. Jadwal praktek: ' . strtoupper($hariPraktekString));
            }

            // Ubah jadwal aktif sesuai hari yang dipilih
            $jadwalAktif = $semuaJadwal->firstWhere(fn($j) => strtolower($j->hari) == $hariPilihan);

        } else {
            // Default Load (Saat pertama kali buka halaman)
            $hariIni = strtolower($now->translatedFormat('l'));
            $jadwalAktif = $semuaJadwal->firstWhere(fn($j) => strtolower($j->hari) == $hariIni);

            // Jika hari ini dokter praktek dan belum tutup, set ke hari ini
            if ($jadwalAktif && $now->format('H:i') < $jadwalAktif->jam_selesai) {
                $tanggalKunjungan = $now->format('Y-m-d');
            } else {
                // Jika hari ini libur/tutup, otomatis arahkan ke jadwal praktek hari berikutnya
                $jadwalAktif = $semuaJadwal->first(); 
                
                // --- PERBAIKAN: KAMUS TERJEMAHAN HARI ---
                $kamusHari = [
                    'senin' => 'Monday',
                    'selasa' => 'Tuesday',
                    'rabu' => 'Wednesday',
                    'kamis' => 'Thursday',
                    'jumat' => 'Friday',
                    'sabtu' => 'Saturday',
                    'minggu' => 'Sunday'
                ];
                $hariInggris = $kamusHari[strtolower($jadwalAktif->hari)] ?? 'Monday';
                $tanggalKunjungan = Carbon::parse('next ' . $hariInggris)->format('Y-m-d');
                // ----------------------------------------
            }
        }

        // 3. GENERATE SLOT WAKTU (Otomatis menyesuaikan tanggal)
        $jamBuka = Carbon::parse($jadwalAktif->jam_mulai);
        $jamTutup = Carbon::parse($jadwalAktif->jam_selesai);
        $slots = [];

        // Cari jam berapa saja yang sudah dibooking pada TANGGAL TERSEBUT
        $bookedSlots = Kunjungan::where('dokter_id', $dokter->id)
                        ->whereDate('tanggal_kunjungan', $tanggalKunjungan)
                        ->whereNotIn('status', ['batal']) 
                        ->pluck('jam_pilihan')
                        ->map(fn($jam) => Carbon::parse($jam)->format('H:i'))
                        ->toArray();

        $isToday = ($tanggalKunjungan == $now->format('Y-m-d'));

        while ($jamBuka->lt($jamTutup)) {
            $jamStart = $jamBuka->format('H:i');
            
            // Logika: Jika booking hari ini, matikan jam yang sudah lewat
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

            $jamBuka->addMinutes(20); // Interval 20 menit per pasien
        }

        $jadwal = $jadwalAktif; // Assign kembali agar variabel di View tetap terbaca
        return view('user.pendaftaran', compact('jadwal', 'semuaJadwal', 'slots', 'tanggalKunjungan', 'hariPraktekString'));
    }

    public function store(Request $request, $id_jadwal)
    {
        $now = Carbon::now('Asia/Makassar');

        $request->validate([
            'jam_pilihan' => 'required',
            'keluhan' => 'required|string',
            'tanggal_kunjungan' => 'required|date'
        ]);

        $jadwalReferensi = JadwalDokter::findOrFail($id_jadwal);
        $dokter_id = $jadwalReferensi->dokter_id;

        // BENTENG 1: Pastikan hacker tidak mengubah hari lewat Inspect Element
        $hariPilihan = strtolower(Carbon::parse($request->tanggal_kunjungan)->translatedFormat('l'));
        $jadwalAktif = JadwalDokter::where('dokter_id', $dokter_id)
                            ->whereRaw('LOWER(hari) = ?', [$hariPilihan])
                            ->first();

        if (!$jadwalAktif) {
            return back()->with('error', 'Manipulasi data terdeteksi: Dokter tidak praktek di hari tersebut.');
        }

        // BENTENG 2: Pastikan jam belum lewat
        $isToday = ($request->tanggal_kunjungan == $now->format('Y-m-d'));
        if ($isToday && $request->jam_pilihan <= $now->format('H:i')) {
            return back()->with('error', 'Waktu sudah terlewati. Silakan pilih jam lain.');
        }

        $pasien = Auth::user()->pasien;
        if (!$pasien) {
            return back()->with('error', 'Lengkapi profil pasien terlebih dahulu.');
        }

        // BENTENG 3: Cek apakah jam tersebut baru saja diklik pasien lain di waktu yang sama
        $cekBentrok = Kunjungan::where('dokter_id', $dokter_id)
                    ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
                    ->where('jam_pilihan', $request->jam_pilihan)
                    ->whereNotIn('status', ['batal'])
                    ->exists();

        if ($cekBentrok) {
            return back()->with('error', 'Mohon maaf, jam tersebut baru saja dipesan orang lain. Silakan pilih jam lainnya.');
        }

        // Generate Nomor Antrian Harian (A-001, A-002, dst)
        $urutan = Kunjungan::where('dokter_id', $dokter_id)
                    ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
                    ->count() + 1;
        
        $noAntrian = 'A-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

        // SIMPAN KE DATABASE (Menggunakan $jadwalAktif->id yang benar sesuai tanggal)
        $kunjungan = Kunjungan::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter_id,
            'jadwal_id' => $jadwalAktif->id, 
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_pilihan' => $request->jam_pilihan,
            'no_antrian' => $noAntrian,
            'keluhan' => $request->keluhan,
            'status' => 'menunggu',
            'total_bayar' => 0
        ]);

        // Kirim Tiket via Email
        try {
            Mail::to(Auth::user()->email)->send(new NotifikasiAntrian($kunjungan));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Gagal kirim email: " . $e->getMessage());
        }

        return redirect()->route('user.dashboard')->with('success', 'Berhasil! Nomor Antrian Anda: ' . $noAntrian . '. Cek Email untuk tiket.');
    }
}