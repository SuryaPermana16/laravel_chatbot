<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kunjungan()
    {
        return $this->belongsToMany(Kunjungan::class, 'kunjungan_obat')
            ->withPivot('jumlah', 'harga_satuan', 'subtotal');
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            \App\Models\KnowledgeBase::autoSync();
        });

        static::deleted(function ($model) {
            \App\Models\KnowledgeBase::autoSync();
        });
    }
}