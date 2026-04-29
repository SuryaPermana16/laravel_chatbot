<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwals()
    {
        return $this->hasMany(JadwalDokter::class, 'dokter_id');
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