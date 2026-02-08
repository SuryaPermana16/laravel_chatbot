<?php

namespace Database\Seeders;

use App\Models\KnowledgeBase;
use Illuminate\Database\Seeder;

class KnowledgeBaseSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'kategori' => 'Pendaftaran',
                'pertanyaan' => 'Apa syarat pendaftaran pasien baru?',
                'jawaban' => 'Untuk pasien baru, harap membawa KTP (Dewasa) atau KIA/KK (Anak) dan menuju loket pendaftaran untuk mengisi formulir rekam medis.',
                'is_active' => true,
            ],
            [
                'kategori' => 'BPJS',
                'pertanyaan' => 'Apakah menerima pasien BPJS?',
                'jawaban' => 'Ya, Klinik Bina Usada menerima pasien BPJS Kesehatan. Pastikan faskes tingkat 1 Anda terdaftar di klinik kami dan status kepesertaan aktif.',
                'is_active' => true,
            ],
            [
                'kategori' => 'BPJS',
                'pertanyaan' => 'Apa syarat berobat menggunakan BPJS?',
                'jawaban' => 'Syaratnya adalah membawa KTP asli dan Kartu BPJS (fisik atau digital di Mobile JKN). Tidak perlu fotokopi.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Umum',
                'pertanyaan' => 'Jam berapa klinik buka?',
                'jawaban' => 'Klinik buka setiap hari Senin sampai Sabtu, mulai pukul 08:00 pagi hingga 20:00 malam. Hari Minggu dan Tanggal Merah tutup.',
                'is_active' => true,
            ],
            [
                'kategori' => 'Biaya',
                'pertanyaan' => 'Berapa biaya pendaftaran pasien umum?',
                'jawaban' => 'Biaya administrasi pendaftaran pasien umum adalah Rp 15.000. Biaya konsultasi dokter dan obat dikenakan terpisah sesuai tindakan.',
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            KnowledgeBase::create($faq);
        }
    }
}