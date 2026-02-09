<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalDokter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jadwal_dokters';

    protected $fillable = [
        'dokter_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    // Relasi: Jadwal ini milik siapa? (Milik Dokter)
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
}