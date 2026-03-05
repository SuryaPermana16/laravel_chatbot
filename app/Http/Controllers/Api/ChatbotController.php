<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\KnowledgeBase;
use App\Models\Obat;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\RekamMedis;
use App\Models\Pembayaran;
use Carbon\Carbon;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {
        try {
            // Pembersihan input pesan dari user
            $userMessage = trim($request->input('message', ''));
            if (!$userMessage) return response()->json(['reply' => 'Ada yang bisa saya bantu?']);

            $apiKey = env('GEMINI_API_KEY');

            $now = Carbon::now('Asia/Makassar'); 
            $waktuSekarang = $now->translatedFormat('l, d F Y H:i');
            $jam = $now->hour;

            if ($jam >= 5 && $jam < 11) {
                $salam = "Selamat pagi";
            } elseif ($jam >= 11 && $jam < 15) {
                $salam = "Selamat siang";
            } elseif ($jam >= 15 && $jam < 18) {
                $salam = "Selamat sore";
            } else {
                $salam = "Selamat malam";
            }
            $contextData = "";

            // ==========================================================
            // TAHAP 1 & 2: EMBEDDING QUERY & VECTOR RETRIEVAL (INTI RAG)
            // ==========================================================
            
            // 1. Mengubah pertanyaan user menjadi vektor numerik
            $embedResponse = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}", [
                'model' => 'models/gemini-embedding-001',
                'content' => ['parts' => [['text' => $userMessage]]]
            ]);

            if ($embedResponse->successful()) {
                $queryVector = $embedResponse->json()['embedding']['values'];
                
                // 2. Mengambil basis pengetahuan yang sudah ter-embedding di database
                $kbs = KnowledgeBase::where('is_active', true)->whereNotNull('embedding')->get();
                $bestKbMatch = null;
                $highestSimilarity = 0;

                // 3. Pencarian Semantic menggunakan Algoritma Cosine Similarity
                foreach ($kbs as $kb) {
                    $kbVector = json_decode($kb->embedding, true);
                    if ($kbVector) {
                        $similarity = $this->calculateCosineSimilarity($queryVector, $kbVector);

                        // Ambang batas kemiripan (threshold) 0.15
                        if ($similarity > 0.15 && $similarity > $highestSimilarity) {
                            $highestSimilarity = $similarity;
                            $bestKbMatch = $kb;
                        }
                    }
                }

                if ($bestKbMatch) {
                    $contextData .= "[DATA KNOWLEDGE BASE]\n";
                    $contextData .= "Informasi Terkait: {$bestKbMatch->jawaban}\n";
                    $contextData .= "Sumber Data: {$bestKbMatch->kategori}\n\n";
                    // Info debug bisa dihapus nanti kalau sudah fix buat skripsi
                    $contextData .= "INFO DEBUG: Kasih tau user kalau skor kemiripan data ini adalah: " . $highestSimilarity . "\n\n";
                }
            }

            // ==========================================================
            // TAHAP 2 (Lanjutan): REAL-TIME DATA RETRIEVAL (SQL)
            // ==========================================================
            
            // Data Laporan Statistik
            $totalPasien = Pasien::count();
            $pasienHariIni = Kunjungan::whereDate('created_at', Carbon::today())->count();
            $pendapatanHariIni = Pembayaran::whereDate('created_at', Carbon::today())->sum('total_biaya') ?? 0;
            $pendapatanKeseluruhan = Pembayaran::sum('total_biaya') ?? 0;
            
            $penyakitTeratas = RekamMedis::select('diagnosa')
                                ->selectRaw('count(*) as jumlah')
                                ->groupBy('diagnosa')
                                ->orderByDesc('jumlah')
                                ->first();
            $namaPenyakit = $penyakitTeratas ? $penyakitTeratas->diagnosa : 'Belum ada data';

            $contextData .= "[DATA OPERASIONAL KLINIK REAL-TIME]\n";
            $contextData .= "- Statistik Pasien: Hari ini {$pasienHariIni} orang, Total terdaftar {$totalPasien} orang.\n";
            $contextData .= "- Keuangan: Pendapatan hari ini Rp " . number_format($pendapatanHariIni, 0, ',', '.') . ", Total pendapatan Rp " . number_format($pendapatanKeseluruhan, 0, ',', '.') . ".\n";
            $contextData .= "- Tren Kesehatan: Penyakit tersering saat ini adalah {$namaPenyakit}.\n";
            $contextData .= "Sumber Data: Sistem Manajemen Klinik\n\n";

            // Data Stok Obat
            $semua_obat = Obat::all();
            $contextData .= "[DATA STOK OBAT]\n";
            foreach ($semua_obat as $obat) {
                $contextData .= "- {$obat->nama_obat}: Stok sisa {$obat->stok} {$obat->satuan}, Harga Rp " . number_format($obat->harga, 0, ',', '.') . ".\n";
            }
            $contextData .= "Sumber Data: Database Apotek\n\n";

            // Data Jadwal Dokter
            $jadwal = JadwalDokter::with('dokter')->get();
            $contextData .= "[DATA JADWAL DOKTER]\n";
            foreach($jadwal as $j) {
                $namaD = $j->dokter->nama_lengkap ?? 'Dokter';
                $contextData .= "- {$namaD} praktik hari " . ucfirst($j->hari) . " jam " . substr($j->jam_mulai,0,5) . " - " . substr($j->jam_selesai,0,5) . ".\n";
            }
            $contextData .= "Sumber Data: Database Jadwal Dokter\n\n";

            // ==========================================================
            // TAHAP 3: AUGMENTATION (PEMBENTUKAN PROMPT)
            // ==========================================================
            
            $systemPrompt = "Kamu adalah Asisten AI Virtual (RAG System) untuk staf Klinik Bina Usada.
            [WAKTU SEKARANG]
            {$waktuSekarang} (Zona WITA)
            Gunakan salam pembuka: {$salam}
            Tugasmu adalah memberikan jawaban yang akurat berdasarkan [KONTEKS DATA] yang disediakan.
            - Jawablah dengan bahasa Indonesia yang profesional dan ramah.
            - Jika data tidak ditemukan dalam konteks, katakan 'Mohon maaf, data tersebut belum tersedia di sistem'.
            - Gunakan format HTML (<b> untuk teks tebal dan <br> untuk baris baru) agar tampilan di web rapi.
            - Dilarang memberikan saran medis atau diagnosis. Fokus pada informasi operasional klinik.
            - WAJIB tampilkan sumber data di akhir jawaban dengan format:
            <br><br><i>(Sumber: Nama Sumber)</i>
            - Gunakan informasi dari label 'Sumber Data' yang tersedia di konteks.
            - Jika menggunakan data Knowledge Base, gunakan kategorinya sebagai sumber.
            - Jika menggunakan data operasional, gunakan label sumber yang tersedia.
            - Jangan menentukan salam sendiri, patuhi salam dari sistem.

            [KONTEKS DATA DATABASE]:\n" . $contextData;

            // ==========================================================
            // TAHAP 4: GENERATION DENGAN FITUR INGATAN (CHAT HISTORY)
            // ==========================================================
            
            // 1. Ambil memori percakapan sebelumnya dari Session Laravel
            $chatHistory = session()->get('chatbot_memory', []);

            // 2. Susun urutan pesan (System Prompt -> Riwayat -> Pertanyaan Baru)
            $geminiContents = [];

            // A. Masukkan Aturan RAG (System Prompt) di urutan paling awal
            $geminiContents[] = [
                'role' => 'user',
                'parts' => [['text' => $systemPrompt]]
            ];
            $geminiContents[] = [
                'role' => 'model',
                'parts' => [['text' => 'Baik, saya mengerti aturan tersebut. Saya akan menjawab sesuai data yang diberikan.']]
            ];

            // B. Masukkan Ingatan Percakapan Sebelumnya
            foreach ($chatHistory as $history) {
                $geminiContents[] = [
                    'role' => $history['role'],
                    'parts' => [['text' => $history['text']]]
                ];
            }

            // C. Masukkan Pertanyaan User yang Paling Baru
            $geminiContents[] = [
                'role' => 'user',
                'parts' => [['text' => $userMessage]]
            ];

            // 3. Tembak ke API Gemini (v1)
            $generateResponse = Http::post(
                "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                [
                    'contents' => $geminiContents,
                    'generationConfig' => [
                        'temperature' => 0.1, // Tetap rendah agar bot tidak halusinasi
                        'topP' => 0.95,
                        'maxOutputTokens' => 2048,
                    ]
                ]
            );

            if ($generateResponse->successful()) {
                // Ambil teks balasan asli dari AI
                $botReplyRaw = $generateResponse->json()['candidates'][0]['content']['parts'][0]['text'];
                
                // 4. SIMPAN KE MEMORI UNTUK PERTANYAAN SELANJUTNYA
                $chatHistory[] = ['role' => 'user', 'text' => $userMessage];
                $chatHistory[] = ['role' => 'model', 'text' => $botReplyRaw];

                // Batasi memori maksimal 6 pasang (12 pesan) agar kuota server aman
                if (count($chatHistory) > 12) {
                    $chatHistory = array_slice($chatHistory, -12);
                }
                session()->put('chatbot_memory', $chatHistory);

                // Membersihkan markdown AI menjadi format HTML yang didukung sistem
                $botReplyHtml = str_replace(['**', '*'], ['<b>', '</b>'], $botReplyRaw); 
                return response()->json(['reply' => $botReplyHtml]);
            }

            // Menampilkan pesan error detail jika gagal terhubung ke AI
            $errorData = $generateResponse->json();
            $pesanError = $errorData['error']['message'] ?? 'Gagal mendapatkan respon dari server AI.';
            return response()->json(['reply' => '⚠️ Kendala AI: ' . $pesanError]);

        } catch (\Exception $e) {
            return response()->json(['reply' => '⚠️ Kesalahan Sistem RAG: ' . $e->getMessage()]);
        }
    }

    /**
     * ALGORITMA COSINE SIMILARITY
     */
    private function calculateCosineSimilarity($vec1, $vec2) {
        $dotProduct = 0; $normA = 0; $normB = 0;
        $count = min(count($vec1), count($vec2));
        
        for ($i = 0; $i < $count; $i++) {
            $dotProduct += $vec1[$i] * $vec2[$i];
            $normA += pow($vec1[$i], 2);
            $normB += pow($vec2[$i], 2);
        }
        
        if ($normA == 0 || $normB == 0) return 0;
        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }
}