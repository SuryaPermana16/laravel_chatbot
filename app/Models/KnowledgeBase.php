<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class KnowledgeBase extends Model
{
    use HasFactory;

    protected $table = 'knowledge_bases';
    
    // Pastikan kolom-kolom ini sesuai dengan tabel Kakak
    protected $fillable = ['kategori', 'pertanyaan', 'jawaban', 'is_active', 'embedding'];

    // Fitur ini otomatis berjalan setiap kali data FAQ baru disimpan atau diupdate
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($knowledgeBase) {
            // Gabungkan teks untuk di-embed
            $textToEmbed = "Kategori: " . $knowledgeBase->kategori . " | Pertanyaan: " . $knowledgeBase->pertanyaan . " | Jawaban: " . $knowledgeBase->jawaban;

            // Panggil API Embedding Gemini
            $apiKey = env('GEMINI_API_KEY');
            $response = Http::post("https://generativelanguage.googleapis.com/v1/models/gemini-embedding-001:embedContent?key={$apiKey}", [
                'model' => 'models/gemini-embedding-001',
                'content' => [
                    'parts' => [['text' => $textToEmbed]]
                ]
            ]);

            // Jika berhasil, simpan array angka vektor ke kolom 'embedding' dalam bentuk JSON
            if ($response->successful()) {
                $vector = $response->json()['embedding']['values'];
                $knowledgeBase->embedding = json_encode($vector);
            }
        });
    }
}