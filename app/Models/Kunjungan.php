<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungans'; 

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'no_antrian',
        'jam_pilihan',
        'tanggal_kunjungan',
        'keluhan',
        'diagnosa',    // TAMBAHKAN INI
        'resep_obat',  // TAMBAHKAN INI
        'status',
    ];

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    // Relasi ke Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}