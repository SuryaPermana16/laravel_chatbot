<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@klinik.com',
            'password' => Hash::make('password'), // Password: password
            'role' => 'admin',
        ]);

        DB::table('admins')->insert([
            'user_id' => $admin->id,
            'nama_lengkap' => 'Administrator Sistem',
            'no_telepon' => '081234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $dokter = User::create([
            'name' => 'dr. Budi Santoso',
            'email' => 'dokter@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);

        DB::table('dokters')->insert([
            'user_id' => $dokter->id,
            'nama_lengkap' => 'dr. Budi Santoso, Sp.PD',
            'spesialis' => 'Penyakit Dalam',
            'no_telepon' => '081298765432',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $apoteker = User::create([
            'name' => 'Siti Aminah',
            'email' => 'apotek@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'apoteker',
        ]);

        DB::table('apotekers')->insert([
            'user_id' => $apoteker->id,
            'nama_lengkap' => 'Siti Aminah, S.Farm',
            'alamat' => 'Jl. Kebon Jeruk No. 1',
            'no_telepon' => '081211112222',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pasien = User::create([
            'name' => 'Ahmad Yusuf',
            'email' => 'pasien@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);

        DB::table('pasiens')->insert([
            'user_id' => $pasien->id,
            'nama_lengkap' => 'Ahmad Yusuf',
            'alamat' => 'Jl. Merdeka No. 45',
            'no_telepon' => '081233334444',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}