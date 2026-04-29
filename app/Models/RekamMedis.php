<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'kunjungan_id',
        'tgl_periksa',
        'keluhan',
        'pemeriksaan_fisik',
        'diagnosa',
        'tindakan',
        'keterangan_tambahan'
    ];
}