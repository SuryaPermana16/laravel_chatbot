<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
    use HasFactory;

    protected $fillable = [
        'rekam_medis_id',
        'obat_id',
        'jumlah',
        'dosis',
        'catatan'
    ];

    // Relasi lain tetap dapat ditambahkan di bawah
}