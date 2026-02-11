<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apoteker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'alamat',
        'no_telepon',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}