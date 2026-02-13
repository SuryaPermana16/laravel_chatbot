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
        'diagnosa',
        'resep_obat',
        'status',
        'biaya_jasa_dokter',
        'biaya_obat',
        'total_bayar',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    // --- TAMBAHAN PENTING ---
    // Relasi Many-to-Many ke Obat melalui tabel pivot
    public function obat()
    {
        return $this->belongsToMany(Obat::class, 'kunjungan_obat')
                    ->withPivot('jumlah', 'harga_satuan', 'subtotal')
                    ->withTimestamps();
    }
}