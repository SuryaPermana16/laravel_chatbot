<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasiens';

    protected $fillable = [
        'user_id',
        'no_rm',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'berat_badan',
        'tinggi_badan',
        'tensi_darah',
    ];

    public static function generateNoRM()
    {
        $lastPasien = self::latest('id')->first();

        if (!$lastPasien || !$lastPasien->no_rm) {
            return 'RM-00001';
        }

        $lastNumber = (int) substr($lastPasien->no_rm, 3);
        $nextNumber = $lastNumber + 1;

        return 'RM-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}