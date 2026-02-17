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
            $query = strtolower($request->input('message', ''));
            if (!$query) return response()->json(['reply' => 'Ada yang bisa saya bantu?']);

            // --- 1. LOGIKA CEK STOK OBAT (DIPERINTAR) ---
            if (str_contains($query, 'obat') || str_contains($query, 'stok') || str_contains($query, 'harga')) {
                // Ambil semua obat
                $semua_obat = Obat::all();
                foreach ($semua_obat as $obat) {
                    $namaObatDb = strtolower($obat->nama_obat);
                    
                    // Cek apakah nama obat di DB ada di dalam pertanyaan user
                    // Atau sebaliknya (misal user nanya 'parasetamol' tapi di DB 'parasetamol 500mg')
                    if (str_contains($query, $namaObatDb) || str_contains($namaObatDb, $query)) {
                        return response()->json([
                            'reply' => "💊 Stok <b>{$obat->nama_obat}</b>: {$obat->stok} {$obat->satuan}. <br>Harga: <b>Rp " . number_format($obat->harga, 0, ',', '.') . "</b>"
                        ]);
                    }
                }
            }

            // --- 2. LOGIKA CEK JADWAL DOKTER ---
            if (str_contains($query, 'jadwal') || str_contains($query, 'dokter')) {
                $jadwal = JadwalDokter::with('dokter')->get();
                if ($jadwal->count() > 0) {
                    $text = "📅 <b>Jadwal Dokter Kami:</b><br>";
                    foreach($jadwal as $j) {
                        $namaD = $j->dokter->nama_lengkap ?? 'Dokter';
                        $text .= "• <b>{$namaD}</b>: {$j->hari} (".substr($j->jam_mulai,0,5)."-".substr($j->jam_selesai,0,5).")<br>";
                    }
                    return response()->json(['reply' => $text]);
                }
            }

            // --- 3. KNOWLEDGE BASE (FAQ) ---
            $kb = KnowledgeBase::where('is_active', true)->get();
            foreach ($kb as $item) {
                $kat = strtolower($item->kategori);
                $tanya = strtolower($item->pertanyaan);
                
                // Cek apakah kata kunci ada di kategori atau pertanyaan
                if (str_contains($query, $kat) || str_contains($query, $tanya) || str_contains($tanya, $query)) {
                     return response()->json(['reply' => $item->jawaban]);
                }
            }

            // JAWABAN DEFAULT
            return response()->json([
                'reply' => 'Maaf Kak, saya belum paham. 🤔<br>Coba tanya: <b>"Stok Obat"</b>, atau <b>"Jadwal Dokter"</b>.'
            ]);

        } catch (\Exception $e) {
            return response()->json(['reply' => '⚠️ Kendala sistem: ' . $e->getMessage()]);
        }
    }
}