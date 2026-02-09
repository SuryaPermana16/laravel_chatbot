<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    // Nama tabel di database (opsional jika sudah jamak, tapi biar yakin)
    protected $table = 'pasiens';

    // DAFTAR KOLOM YANG BOLEH DIISI (WAJIB LENGKAP)
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'jenis_kelamin', // Tadi mungkin ini lupa
        'tanggal_lahir', // Tadi mungkin ini lupa
        'alamat',
        'no_telepon',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}