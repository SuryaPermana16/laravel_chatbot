<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $data_obat = [
            [
                'nama_obat' => 'Parasetamol 500mg',
                'harga' => 5000,
                'stok' => 100,
                'satuan' => 'Strip',
            ],
            [
                'nama_obat' => 'Amoxicillin 500mg',
                'harga' => 12000,
                'stok' => 50,
                'satuan' => 'Strip',
            ],
            [
                'nama_obat' => 'OBH Combi Batuk Flu',
                'harga' => 25000,
                'stok' => 20,
                'satuan' => 'Botol',
            ],
            [
                'nama_obat' => 'Vitamin C IPI',
                'harga' => 8000,
                'stok' => 200,
                'satuan' => 'Botol Kecil',
            ],
            [
                'nama_obat' => 'Betadine Antiseptic',
                'harga' => 35000,
                'stok' => 5,
                'satuan' => 'Botol',
            ],
            [
                'nama_obat' => 'Promag Tablet',
                'harga' => 9000,
                'stok' => 150,
                'satuan' => 'Strip',
            ],
        ];

        foreach ($data_obat as $obat) {
            Obat::create($obat);
        }
    }
}