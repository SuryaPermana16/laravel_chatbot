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

        $jadwalReferensi = JadwalDokter::with('dokter')->findOrFail($id_jadwal);
        $dokter = $jadwalReferensi->dokter;

        $urutanHari = [
            'senin'  => 1,
            'selasa' => 2,
            'rabu'   => 3,
            'kamis'  => 4,
            'jumat'  => 5,
            'sabtu'  => 6,
            'minggu' => 7
        ];

        $semuaJadwal = JadwalDokter::where('dokter_id', $dokter->id)
            ->get()
            ->sortBy(function ($j) use ($urutanHari) {
                return $urutanHari[strtolower($j->hari)] ?? 99;
            })
            ->values();

        $hariPraktekList = $semuaJadwal->map(fn($j) => strtolower($j->hari))->toArray();
        $hariPraktekString = implode(', ', $semuaJadwal->pluck('hari')->toArray());

        if ($request->has('tanggal')) {
            $tanggalKunjungan = $request->tanggal;
            $hariPilihan = strtolower(Carbon::parse($tanggalKunjungan)->translatedFormat('l'));

            if ($tanggalKunjungan < $now->format('Y-m-d')) {
                return redirect()->route('user.daftar', $id_jadwal)
                    ->with('error', 'Tidak dapat melakukan reservasi untuk tanggal yang sudah terlewat.');
            }

            if (!in_array($hariPilihan, $hariPraktekList)) {
                return redirect()->route('user.daftar', $id_jadwal)
                    ->with('error', 'Dokter tidak praktek di hari tersebut. Jadwal praktek: ' . strtoupper($hariPraktekString));
            }

            $jadwalAktif = $semuaJadwal->firstWhere(fn($j) => strtolower($j->hari) == $hariPilihan);
        } else {
            $hariIni = strtolower($now->translatedFormat('l'));
            $jadwalAktif = $semuaJadwal->firstWhere(fn($j) => strtolower($j->hari) == $hariIni);

            if ($jadwalAktif && $now->format('H:i') < $jadwalAktif->jam_selesai) {
                $tanggalKunjungan = $now->format('Y-m-d');
            } else {
                $jadwalAktif = $semuaJadwal->first();

                $kamusHari = [
                    'senin'  => 'Monday',
                    'selasa' => 'Tuesday',
                    'rabu'   => 'Wednesday',
                    'kamis'  => 'Thursday',
                    'jumat'  => 'Friday',
                    'sabtu'  => 'Saturday',
                    'minggu' => 'Sunday'
                ];

                $hariInggris = $kamusHari[strtolower($jadwalAktif->hari)] ?? 'Monday';
                $tanggalKunjungan = Carbon::parse('next ' . $hariInggris)->format('Y-m-d');
            }
        }

        $jamBuka = Carbon::parse($jadwalAktif->jam_mulai);
        $jamTutup = Carbon::parse($jadwalAktif->jam_selesai);
        $slots = [];

        $bookedSlots = Kunjungan::where('dokter_id', $dokter->id)
            ->whereDate('tanggal_kunjungan', $tanggalKunjungan)
            ->whereNotIn('status', ['batal'])
            ->pluck('jam_pilihan')
            ->map(fn($jam) => Carbon::parse($jam)->format('H:i'))
            ->toArray();

        $isToday = ($tanggalKunjungan == $now->format('Y-m-d'));

        while ($jamBuka->lt($jamTutup)) {
            $jamStart = $jamBuka->format('H:i');

            $isPast = ($isToday && $jamStart <= $now->format('H:i'));
            $isBooked = in_array($jamStart, $bookedSlots);

            $status = 'Tersedia';

            if ($isBooked) {
                $status = 'Penuh';
            }

            if ($isPast) {
                $status = 'Lewat';
            }

            $slots[] = [
                'jam'       => $jamStart,
                'available' => ($status == 'Tersedia'),
                'status'    => $status
            ];

            $jamBuka->addMinutes(20);
        }

        $jadwal = $jadwalAktif;

        return view('user.pendaftaran', compact(
            'jadwal',
            'semuaJadwal',
            'slots',
            'tanggalKunjungan',
            'hariPraktekString'
        ));
    }

    public function store(Request $request, $id_jadwal)
    {
        $now = Carbon::now('Asia/Makassar');

        $request->validate([
            'jam_pilihan'       => 'required',
            'keluhan'           => 'required|string',
            'tanggal_kunjungan' => 'required|date'
        ]);

        $jadwalReferensi = JadwalDokter::findOrFail($id_jadwal);
        $dokter_id = $jadwalReferensi->dokter_id;

        $hariPilihan = strtolower(Carbon::parse($request->tanggal_kunjungan)->translatedFormat('l'));

        $jadwalAktif = JadwalDokter::where('dokter_id', $dokter_id)
            ->whereRaw('LOWER(hari) = ?', [$hariPilihan])
            ->first();

        if (!$jadwalAktif) {
            return back()->with('error', 'Manipulasi data terdeteksi: Dokter tidak praktek di hari tersebut.');
        }

        $isToday = ($request->tanggal_kunjungan == $now->format('Y-m-d'));

        if ($isToday && $request->jam_pilihan <= $now->format('H:i')) {
            return back()->with('error', 'Waktu sudah terlewati. Silakan pilih jam lain.');
        }

        $pasien = Auth::user()->pasien;

        if (!$pasien) {
            return back()->with('error', 'Lengkapi profil pasien terlebih dahulu.');
        }

        $cekBentrok = Kunjungan::where('dokter_id', $dokter_id)
            ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->where('jam_pilihan', $request->jam_pilihan)
            ->whereNotIn('status', ['batal'])
            ->exists();

        if ($cekBentrok) {
            return back()->with('error', 'Mohon maaf, jam tersebut baru saja dipesan orang lain. Silakan pilih jam lainnya.');
        }

        $urutan = Kunjungan::where('dokter_id', $dokter_id)
            ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->count() + 1;

        $noAntrian = 'A-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

        $kunjungan = Kunjungan::create([
            'pasien_id'          => $pasien->id,
            'dokter_id'          => $dokter_id,
            'jadwal_id'          => $jadwalAktif->id,
            'tanggal_kunjungan'  => $request->tanggal_kunjungan,
            'jam_pilihan'        => $request->jam_pilihan,
            'no_antrian'         => $noAntrian,
            'keluhan'            => $request->keluhan,
            'status'             => 'menunggu',
            'total_bayar'        => 0
        ]);

        try {
            Mail::to(Auth::user()->email)->send(new NotifikasiAntrian($kunjungan));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal kirim email: ' . $e->getMessage());
        }

        return redirect()->route('user.dashboard')
            ->with('success', 'Berhasil! Nomor Antrian Anda: ' . $noAntrian . '. Cek Email untuk tiket.');
    }
}