<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KnowledgeBase;
use App\Models\Obat;
use App\Models\JadwalDokter;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {
        try {
            // Ubah ke huruf kecil semua dan hapus spasi berlebih
            $query = strtolower(trim($request->input('message', '')));
            if (!$query) return response()->json(['reply' => 'Ada yang bisa saya bantu?']);

            // ==========================================================
            // 1. LOGIKA CEK JADWAL DOKTER (DENGAN FILTER NAMA SPESIFIK)
            // ==========================================================
            if (str_contains($query, 'jadwal') || str_contains($query, 'dokter') || str_contains($query, 'praktek')) {
                
                // Algoritma Regex: Membuang kata umum untuk mendapatkan "Nama Dokter" saja
                $clean_nama = trim(preg_replace('/\b(cek|jadwal|dokter|dr|praktek|hari|ini|besok|dong|tolong|tampilkan|buat)\b/i', '', $query));
                $clean_nama = trim(str_replace(['?', '.', ','], '', $clean_nama));

                if (!empty($clean_nama) && strlen($clean_nama) > 2) {
                    // Cari jadwal khusus untuk dokter yang diketik (BUG FIX: Hanya cari di kolom nama_lengkap)
                    $jadwal_spesifik = JadwalDokter::with('dokter')
                        ->whereHas('dokter', function($q) use ($clean_nama) {
                            $q->where('nama_lengkap', 'LIKE', '%' . $clean_nama . '%');
                        })->get();

                    if ($jadwal_spesifik->count() > 0) {
                        $namaD = $jadwal_spesifik->first()->dokter->nama_lengkap ?? 'Dokter';
                        $text = "📅 <b>Jadwal Praktek Spesifik: {$namaD}</b><br>";
                        foreach($jadwal_spesifik as $j) {
                            $text .= "• " . ucfirst($j->hari) . " (".substr($j->jam_mulai,0,5)." - ".substr($j->jam_selesai,0,5).")<br>";
                        }
                        return response()->json(['reply' => $text]);
                    } else {
                        return response()->json([
                            'reply' => "Maaf, saya tidak menemukan jadwal praktek untuk dokter bernama <b>" . ucwords($clean_nama) . "</b>. 🥲"
                        ]);
                    }
                }

                // Jika user tidak mengetik nama spesifik (hanya nanya "jadwal dokter")
                $jadwal = JadwalDokter::with('dokter')->get();
                if ($jadwal->count() > 0) {
                    $text = "📅 <b>Jadwal Seluruh Dokter Kami:</b><br>";
                    foreach($jadwal as $j) {
                        $namaD = $j->dokter->nama_lengkap ?? 'Dokter';
                        $text .= "• <b>{$namaD}</b>: {$j->hari} (".substr($j->jam_mulai,0,5)."-".substr($j->jam_selesai,0,5).")<br>";
                    }
                    return response()->json(['reply' => $text]);
                }
            }

            // ==========================================================
            // 2. LOGIKA CEK STOK OBAT (DENGAN TOLERANSI TYPO / FUZZY MATCH)
            // ==========================================================
            if (str_contains($query, 'obat') || str_contains($query, 'stok') || str_contains($query, 'harga')) {
                
                // Algoritma Regex: Membuang kata umum untuk mendapatkan "Nama Obat" murni
                $kata_kunci_obat = trim(preg_replace('/\b(cek|stok|harga|obat|dong|tolong|berapa|sisa|ada|gak|tersedia)\b/i', '', $query));
                $kata_kunci_obat = trim(str_replace(['?', '.', ','], '', $kata_kunci_obat));

                $semua_obat = Obat::all();
                $bestMatch = null;
                $highestSimilarity = 0;

                foreach ($semua_obat as $obat) {
                    $namaObatDb = strtolower($obat->nama_obat);

                    // A. Exact Match (Sangat Akurat)
                    if (str_contains($query, $namaObatDb) || (!empty($kata_kunci_obat) && str_contains($namaObatDb, $kata_kunci_obat))) {
                        $bestMatch = $obat;
                        break; // Langsung ketemu cocok 100%, hentikan pencarian
                    }

                    // B. Fuzzy Match (Toleransi Typo)
                    if (!empty($kata_kunci_obat)) {
                        // Menghitung persentase kemiripan kata yang diketik dengan nama di DB
                        similar_text($kata_kunci_obat, $namaObatDb, $percent);

                        // Jika kemiripan di atas 65%, sistem menganggap itu typo yang dimaafkan
                        if ($percent > 65 && $percent > $highestSimilarity) {
                            $highestSimilarity = $percent;
                            $bestMatch = $obat;
                        }
                    }
                }

                // Jika obat ditemukan (baik karena pas atau typo)
                if ($bestMatch) {
                    return response()->json([
                        'reply' => "💊 Hasil pencarian untuk: <b>" . ucwords($bestMatch->nama_obat) . "</b><br>• Sisa Stok: <b>{$bestMatch->stok} {$bestMatch->satuan}</b><br>• Harga: <b>Rp " . number_format($bestMatch->harga, 0, ',', '.') . "</b>"
                    ]);
                } elseif (!empty($kata_kunci_obat)) {
                    return response()->json([
                        'reply' => "Maaf, obat dengan nama <b>" . ucwords($kata_kunci_obat) . "</b> tidak ditemukan di apotek kami. 🥲"
                    ]);
                }
            }

            // ==========================================================
            // 3. KNOWLEDGE BASE (FAQ UMUM)
            // ==========================================================
            $kb = KnowledgeBase::where('is_active', true)->get();
            foreach ($kb as $item) {
                $kat = strtolower($item->kategori);
                $tanya = strtolower($item->pertanyaan);
                
                if (str_contains($query, $kat) || str_contains($query, $tanya) || str_contains($tanya, $query)) {
                     return response()->json(['reply' => $item->jawaban]);
                }
            }

            // ==========================================================
            // 4. JAWABAN DEFAULT (JIKA BOT TIDAK NGERTI)
            // ==========================================================
            return response()->json([
                'reply' => 'Maaf Kak, saya belum paham maksudnya. 🤔<br><br>Coba ketik instruksi spesifik seperti:<br>• <b>"Jadwal dr. Surya"</b><br>• <b>"Cek stok parasetamol"</b>'
            ]);

        } catch (\Exception $e) {
            return response()->json(['reply' => '⚠️ Kendala sistem: ' . $e->getMessage()]);
        }
    }
}