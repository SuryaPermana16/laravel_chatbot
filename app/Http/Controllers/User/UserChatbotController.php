<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\KnowledgeBase;
use Carbon\Carbon;

class UserChatbotController extends Controller
{
    public function index()
    {
        return view('user.chatbot');
    }

    public function sendMessage(Request $request)
    {
        try {
            $userMessage = trim($request->input('message', ''));

            if (!$userMessage) {
                return response()->json([
                    'reply' => 'Ada yang bisa saya bantu?'
                ]);
            }

            $apiKey = env('GEMINI_API_KEY');
            $now = Carbon::now('Asia/Makassar');
            $waktuSekarang = $now->translatedFormat('l, d F Y H:i');
            $jam = $now->hour;

            if ($jam >= 5 && $jam < 11) {
                $salam = 'Selamat pagi';
            } elseif ($jam >= 11 && $jam < 15) {
                $salam = 'Selamat siang';
            } elseif ($jam >= 15 && $jam < 18) {
                $salam = 'Selamat sore';
            } else {
                $salam = 'Selamat malam';
            }

            $contextData = '';

            $embedResponse = Http::post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}",
                [
                    'model' => 'models/gemini-embedding-001',
                    'content' => [
                        'parts' => [
                            ['text' => $userMessage]
                        ]
                    ]
                ]
            );

            if ($embedResponse->successful()) {
                $queryVector = $embedResponse->json()['embedding']['values'];

                $kbs = KnowledgeBase::where('is_active', true)
                    ->whereNotNull('embedding')
                    ->get();

                $matches = [];

                foreach ($kbs as $kb) {
                    $kbVector = json_decode($kb->embedding, true);

                    if ($kbVector) {
                        $similarity = $this->calculateCosineSimilarity($queryVector, $kbVector);

                        if ($similarity > 0.12) {
                            $matches[] = [
                                'jawaban' => $kb->jawaban,
                                'kat'     => $kb->kategori,
                                'score'   => $similarity
                            ];
                        }
                    }
                }

                usort($matches, fn($a, $b) => $b['score'] <=> $a['score']);

                $topMatches = array_slice($matches, 0, 3);

                if (count($topMatches) > 0) {
                    $contextData .= "[INFORMASI TAMBAHAN DARI DATABASE]:\n";

                    foreach ($topMatches as $m) {
                        $contextData .= "- {$m['jawaban']}\n";
                    }
                }
            }

            $systemPrompt = "Anda adalah Asisten Virtual Klinik Bina Usada. 
            [WAKTU SEKARANG]: {$waktuSekarang} WITA. Salam: {$salam}.

            [DATA DASAR KLINIK]:
            - Alamat: Jl. Gatot Subroto Barat No.101, Ubung, Denpasar.
            - Kontak: (0361) 410764.
            - Jam Buka: 08:00 - 20:30 WITA setiap hari.
            - Layanan: Poli Umum, Poli Gigi dan Poli KIA.

            [INSTRUKSI]:
            1. Jawablah pertanyaan pasien berdasarkan [DATA DASAR KLINIK] dan [INFORMASI TAMBAHAN] di bawah.
            2. Jika pertanyaan mengandung beberapa hal, jawab semuanya.
            3. Jangan memberikan info stok obat, nama pasien lain, riwayat medis, atau keuangan klinik.
            4. Jika ditanya hal tersebut, katakan: 'Mohon maaf, saya tidak memiliki akses ke database medis demi menjaga privasi. Silakan hubungi admin di (0361) 410764.'
            5. Gunakan format HTML (<b>, <br>) agar rapi.

            [INFORMASI TAMBAHAN]:\n" . $contextData;

            $chatHistory = session()->get('user_chatbot_memory', []);

            $geminiContents = [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $systemPrompt]
                    ]
                ],
                [
                    'role' => 'model',
                    'parts' => [
                        ['text' => 'Baik, saya siap melayani pasien dengan informasi yang tersedia.']
                    ]
                ]
            ];

            foreach ($chatHistory as $history) {
                $geminiContents[] = [
                    'role' => $history['role'],
                    'parts' => [
                        ['text' => $history['text']]
                    ]
                ];
            }

            $geminiContents[] = [
                'role' => 'user',
                'parts' => [
                    ['text' => $userMessage]
                ]
            ];

            $generateResponse = Http::post(
                "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                [
                    'contents' => $geminiContents,
                    'generationConfig' => [
                        'temperature' => 0.2,
                        'maxOutputTokens' => 1024
                    ]
                ]
            );

            if ($generateResponse->successful()) {
                $botReplyRaw = $generateResponse->json()['candidates'][0]['content']['parts'][0]['text'];

                $chatHistory[] = [
                    'role' => 'user',
                    'text' => $userMessage
                ];

                $chatHistory[] = [
                    'role' => 'model',
                    'text' => $botReplyRaw
                ];

                session()->put('user_chatbot_memory', array_slice($chatHistory, -10));

                return response()->json([
                    'reply' => str_replace(['**', '*'], ['<b>', '</b>'], nl2br($botReplyRaw))
                ]);
            }

            return response()->json([
                'reply' => '⚠️ Gagal terhubung ke AI.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'reply' => '⚠️ Kesalahan Sistem: ' . $e->getMessage()
            ]);
        }
    }

    private function calculateCosineSimilarity($vec1, $vec2)
    {
        $dotProduct = 0;
        $normA = 0;
        $normB = 0;

        foreach ($vec1 as $i => $v) {
            $dotProduct += $v * $vec2[$i];
            $normA += $v * $v;
            $normB += $vec2[$i] * $vec2[$i];
        }

        return ($normA * $normB) == 0
            ? 0
            : $dotProduct / (sqrt($normA) * sqrt($normB));
    }
}