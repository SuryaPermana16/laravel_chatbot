<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi balik ke Kunjungan (Opsional, tapi berguna nanti)
    public function kunjungan()
    {
        return $this->belongsToMany(Kunjungan::class, 'kunjungan_obat')
                    ->withPivot('jumlah', 'harga_satuan', 'subtotal');
    }
}