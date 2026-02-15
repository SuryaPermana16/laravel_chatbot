<?php

namespace App\Mail;

use App\Models\Kunjungan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifikasiAntrian extends Mailable
{
    use Queueable, SerializesModels;

    public $kunjungan;

    // Terima data kunjungan saat class ini dipanggil
    public function __construct(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
    }

    public function build()
    {
        return $this->subject('Tiket Antrian Klinik - ' . $this->kunjungan->no_antrian)
                    ->view('emails.antrian'); // Kita akan buat view ini di langkah 2
    }
}