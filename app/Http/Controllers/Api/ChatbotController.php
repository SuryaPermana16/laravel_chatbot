<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KnowledgeBase;
use App\Models\Obat;
use App\Models\JadwalDokter;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $query = strtolower($request->input('message'));

        if (!$query) {
            return response()->json(['status' => 'error', 'reply' => 'Mau nanya apa nih?']);
        }

        // ==========================================
        // LOGIKA 1: CEK STOK OBAT (LEBIH PINTAR)
        // ==========================================
        if (str_contains($query, 'obat') || str_contains($query, 'stok') || str_contains($query, 'harga')) {
            // Ambil semua obat di database
            $semua_obat = Obat::all();
            
            foreach ($semua_obat as $obat) {
                // Kita pecah nama obat. Misal "Parasetamol 500mg" jadi cuma "parasetamol"
                $kata_kunci_obat = strtolower(explode(' ', $obat->nama_obat)[0]);

                // Cek apakah kata "parasetamol" ada di pertanyaan user?
                if (str_contains($query, $kata_kunci_obat)) {
                    return response()->json([
                        'status' => 'success',
                        'reply' => "Stok {$obat->nama_obat} saat ini ada {$obat->stok} {$obat->satuan}. Harganya Rp " . number_format($obat->harga)
                    ]);
                }
            }
        }

        // ==========================================
        // LOGIKA 2: CEK JADWAL DOKTER
        // ==========================================
        if (str_contains($query, 'jadwal') || str_contains($query, 'dokter') || str_contains($query, 'praktek')) {
            $jadwal = JadwalDokter::with('dokter')->get();
            
            if ($jadwal->isEmpty()) {
                return response()->json(['status' => 'success', 'reply' => 'Belum ada jadwal dokter yang tersedia.']);
            }

            $text = "Berikut jadwal dokter kami:\n";
            foreach($jadwal as $j) {
                $text .= "- " . $j->dokter->nama_lengkap . " (" . $j->hari . ", " . substr($j->jam_mulai, 0, 5) . "-" . substr($j->jam_selesai, 0, 5) . ")\n";
            }
            
            return response()->json(['status' => 'success', 'reply' => $text]);
        }

        // ==========================================
        // LOGIKA 3: KNOWLEDGE BASE (SOP)
        // ==========================================
        $kb = KnowledgeBase::all();
        foreach ($kb as $item) {
            // Cek apakah pertanyaan user mirip dengan database
            if (str_contains($query, strtolower($item->kategori)) || str_contains(strtolower($item->pertanyaan), $query)) {
                 return response()->json([
                    'status' => 'success',
                    'reply' => $item->jawaban
                ]);
            }
        }

        // ==========================================
        // JIKA TIDAK MENGERTI
        // ==========================================
        return response()->json([
            'status' => 'success',
            'reply' => 'Maaf, saya belum mengerti. Coba tanya: "Stok Parasetamol", "Jadwal Dokter", atau "Syarat BPJS".'
        ]);
    }
}