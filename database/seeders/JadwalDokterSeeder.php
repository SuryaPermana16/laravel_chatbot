<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use Illuminate\Database\Seeder;

class JadwalDokterSeeder extends Seeder
{
    public function run(): void
    {
        $dokter = Dokter::first(); 
        if ($dokter) {
            $jadwal = [
                [
                    'dokter_id' => $dokter->id,
                    'hari' => 'Senin',
                    'jam_mulai' => '08:00:00',
                    'jam_selesai' => '14:00:00',
                ],
                [
                    'dokter_id' => $dokter->id,
                    'hari' => 'Selasa',
                    'jam_mulai' => '08:00:00',
                    'jam_selesai' => '14:00:00',
                ],
                [
                    'dokter_id' => $dokter->id,
                    'hari' => 'Rabu',
                    'jam_mulai' => '13:00:00',
                    'jam_selesai' => '17:00:00',
                ],
            ];

            foreach ($jadwal as $j) {
                JadwalDokter::create($j);
            }
        }
    }
}