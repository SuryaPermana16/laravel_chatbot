<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KnowledgeBase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser; // 👈 [BARU] Tambahan library pembaca PDF

class KnowledgeBaseController extends Controller
{
    // =================================================================
    // FITUR LAMA: TAMPILAN INDEX & INPUT MANUAL FAQ (JANGAN DIUBAH)
    // =================================================================
    public function index()
    {
        $kbs = KnowledgeBase::orderBy('created_at', 'desc')->get();
        return view('admin.knowledge_base.index', compact('kbs'));
    }

    public function create()
    {
        return view('admin.knowledge_base.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);

        $apiKey = env('GEMINI_API_KEY');
        $textToEmbed = "Kategori: " . $request->kategori . " | Pertanyaan: " . $request->pertanyaan . " | Jawaban: " . $request->jawaban;

        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}", [
            'model' => 'models/gemini-embedding-001',
            'content' => ['parts' => [['text' => $textToEmbed]]]
        ]);

        if ($response->successful()) {
            KnowledgeBase::create([
                'kategori' => $request->kategori,
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $request->jawaban,
                'is_active' => 1,
                'embedding' => json_encode($response->json()['embedding']['values'])
            ]);
            return redirect()->route('admin.kb.index')->with('success', 'FAQ Baru dan Vektor AI berhasil disimpan!');
        }
        return redirect()->back()->withErrors(['error' => 'Gagal mencetak vektor AI.']);
    }

    public function edit($id)
    {
        $kb = KnowledgeBase::findOrFail($id);
        return view('admin.knowledge_base.edit', compact('kb'));
    }

    public function update(Request $request, $id)
    {
        $kb = KnowledgeBase::findOrFail($id);
        $request->validate(['kategori' => 'required', 'pertanyaan' => 'required', 'jawaban' => 'required']);

        $apiKey = env('GEMINI_API_KEY');
        $textToEmbed = "Kategori: " . $request->kategori . " | Pertanyaan: " . $request->pertanyaan . " | Jawaban: " . $request->jawaban;

        // Cetak ulang vektor karena teksnya berubah
        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}", [
            'model' => 'models/gemini-embedding-001',
            'content' => ['parts' => [['text' => $textToEmbed]]]
        ]);

        if ($response->successful()) {
            $kb->update([
                'kategori' => $request->kategori,
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $request->jawaban,
                'embedding' => json_encode($response->json()['embedding']['values'])
            ]);
            return redirect()->route('admin.kb.index')->with('success', 'Data FAQ dan Vektor AI berhasil diperbarui!');
        }
        return redirect()->back()->withErrors(['error' => 'Gagal mencetak ulang vektor AI.']);
    }

    public function destroy($id)
    {
        KnowledgeBase::findOrFail($id)->delete();
        return redirect()->route('admin.kb.index')->with('success', 'Data FAQ berhasil dihapus!');
    }


    // =================================================================
    // FITUR BARU: UPLOAD & EKSTRAKSI DOKUMEN PDF (TRUE RAG)
    // =================================================================

    // 1. Tampilkan Halaman Form Upload PDF
    public function createPdf()
    {
        // Pastikan nama view sesuai (admin.knowledge_base.upload_pdf)
        return view('admin.knowledge_base.upload_pdf'); 
    }

    // 2. Eksekusi Baca PDF, Pemotongan Teks (Chunking), dan Embedding
    public function storePdf(Request $request)
    {
        $request->validate([
            'dokumen_pdf' => 'required|mimes:pdf|max:5120', // Maksimal 5MB
        ]);

        try {
            // Baca File PDF
            $file = $request->file('dokumen_pdf');
            $namaFile = $file->getClientOriginalName();
            
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $pdf->getText();

            // Potong teks per paragraf (Chunking)
            $chunks = explode("\n\n", $text); 
            $apiKey = env('GEMINI_API_KEY');
            $jumlahDataMasuk = 0;

            foreach ($chunks as $chunk) {
                // Bersihkan spasi berlebih
                $cleanChunk = trim(preg_replace('/\s+/', ' ', $chunk));
                
                // Abaikan jika teks terlalu pendek (misal cuma nomor halaman)
                if (strlen($cleanChunk) < 50) continue; 

                // Teks yang akan di-embed (Format mengikuti gaya Kakak)
                $textToEmbed = "Kategori: Dokumen PDF | Pertanyaan: Informasi dari $namaFile | Jawaban: $cleanChunk";

                // Kirim ke Gemini untuk Embedding
                $embedResponse = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}", [
                    'model' => 'models/gemini-embedding-001',
                    'content' => ['parts' => [['text' => $textToEmbed]]]
                ]);

                if ($embedResponse->successful()) {
                    $embedding = $embedResponse->json()['embedding']['values'];

                    // Simpan ke Database
                    KnowledgeBase::create([
                        'kategori' => 'Dokumen: ' . $namaFile,
                        'pertanyaan' => 'Ekstraksi PDF', // Isi default agar validasi database aman
                        'jawaban' => $cleanChunk, // Paragraf PDF masuk ke jawaban
                        'embedding' => json_encode($embedding),
                        'is_active' => 1
                    ]);
                    
                    $jumlahDataMasuk++;
                }
            }

            return redirect()->route('admin.kb.index')->with('success', "Mantap! $jumlahDataMasuk paragraf dari Dokumen PDF berhasil dipelajari oleh Asisten AI.");

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal memproses PDF: ' . $e->getMessage()]);
        }
    }
}