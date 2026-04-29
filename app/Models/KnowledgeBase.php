<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\Obat;
use App\Models\Dokter;

class KnowledgeBase extends Model
{
    use HasFactory;

    protected $table = 'knowledge_bases';

    protected $fillable = [
        'kategori',
        'pertanyaan',
        'jawaban',
        'is_active',
        'embedding'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($knowledgeBase) {
            if (empty($knowledgeBase->embedding)) {
                $textToEmbed =
                    "Kategori: " . $knowledgeBase->kategori .
                    " | Pertanyaan: " . $knowledgeBase->pertanyaan .
                    " | Jawaban: " . $knowledgeBase->jawaban;

                $apiKey = env('GEMINI_API_KEY');

                $response = Http::post(
                    "https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}",
                    [
                        'model' => 'models/gemini-embedding-001',
                        'content' => [
                            'parts' => [
                                ['text' => $textToEmbed]
                            ]
                        ]
                    ]
                );

                if ($response->successful()) {
                    $vector = $response->json()['embedding']['values'];
                    $knowledgeBase->embedding = json_encode($vector);
                }
            }
        });
    }

    public static function autoSync()
    {
        try {
            $apiKey = env('GEMINI_API_KEY');

            if (!$apiKey) {
                return false;
            }

            self::where('kategori', 'Data Database Otomatis')->delete();

            $obats = Obat::all();

            if ($obats->isNotEmpty()) {
                $teksObat = "INFORMASI STOK OBAT KLINIK BINA USADA TERBARU:\n";

                foreach ($obats as $obat) {
                    $teksObat .= "- Obat {$obat->nama_obat} memiliki stok sebanyak {$obat->stok} {$obat->satuan} dengan harga Rp " .
                        number_format($obat->harga, 0, ',', '.') . ".\n";
                }

                $embedObat = Http::post(
                    "https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}",
                    [
                        'model' => 'models/gemini-embedding-001',
                        'content' => [
                            'parts' => [
                                ['text' => "Kategori: Data Database Otomatis | Pertanyaan: Data Stok Obat | Jawaban: " . $teksObat]
                            ]
                        ]
                    ]
                );

                if ($embedObat->successful()) {
                    self::create([
                        'kategori'   => 'Data Database Otomatis',
                        'pertanyaan' => 'Data Stok Obat Tersinkronisasi',
                        'jawaban'    => $teksObat,
                        'embedding'  => json_encode($embedObat->json()['embedding']['values']),
                        'is_active'  => 1
                    ]);
                }
            }

            $dokters = Dokter::all();

            if ($dokters->isNotEmpty()) {
                $teksDokter = "INFORMASI DOKTER DAN SPESIALIS DI KLINIK BINA USADA:\n";

                foreach ($dokters as $dokter) {
                    $teksDokter .= "- dr. {$dokter->nama_lengkap} adalah dokter spesialis {$dokter->spesialis}. Nomor telepon: {$dokter->no_telepon}.\n";
                }

                $embedDokter = Http::post(
                    "https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}",
                    [
                        'model' => 'models/gemini-embedding-001',
                        'content' => [
                            'parts' => [
                                ['text' => "Kategori: Data Database Otomatis | Pertanyaan: Data Profil Dokter | Jawaban: " . $teksDokter]
                            ]
                        ]
                    ]
                );

                if ($embedDokter->successful()) {
                    self::create([
                        'kategori'   => 'Data Database Otomatis',
                        'pertanyaan' => 'Data Profil Dokter Tersinkronisasi',
                        'jawaban'    => $teksDokter,
                        'embedding'  => json_encode($embedDokter->json()['embedding']['values']),
                        'is_active'  => 1
                    ]);
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}