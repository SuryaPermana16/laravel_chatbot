<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KnowledgeBase;
use App\Models\Obat;
use App\Models\Dokter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;

class KnowledgeBaseController extends Controller
{
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
            'kategori'   => 'required',
            'pertanyaan' => 'required',
            'jawaban'    => 'required'
        ]);

        KnowledgeBase::create([
            'kategori'   => $request->kategori,
            'pertanyaan' => $request->pertanyaan,
            'jawaban'    => $request->jawaban,
            'is_active'  => 1,
        ]);

        return redirect()->route('admin.kb.index')
            ->with('success', 'FAQ Baru dan Vektor AI berhasil disimpan!');
    }

    public function edit($id)
    {
        $kb = KnowledgeBase::findOrFail($id);

        return view('admin.knowledge_base.edit', compact('kb'));
    }

    public function update(Request $request, $id)
    {
        $kb = KnowledgeBase::findOrFail($id);

        $request->validate([
            'kategori'   => 'required',
            'pertanyaan' => 'required',
            'jawaban'    => 'required'
        ]);

        $kb->update([
            'kategori'   => $request->kategori,
            'pertanyaan' => $request->pertanyaan,
            'jawaban'    => $request->jawaban,
            'embedding'  => null
        ]);

        return redirect()->route('admin.kb.index')
            ->with('success', 'Data FAQ dan Vektor AI berhasil diperbarui!');
    }

    public function destroy($id)
    {
        KnowledgeBase::findOrFail($id)->delete();

        return redirect()->route('admin.kb.index')
            ->with('success', 'Data FAQ berhasil dihapus!');
    }

    public function createPdf()
    {
        return view('admin.knowledge_base.upload_pdf');
    }

    public function storePdf(Request $request)
    {
        $request->validate([
            'dokumen_pdf' => 'required|mimes:pdf|max:5120'
        ]);

        try {
            $file = $request->file('dokumen_pdf');
            $namaFile = $file->getClientOriginalName();

            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $pdf->getText();

            $cleanText = trim(preg_replace('/\s+/', ' ', $text));
            $kumpulanKata = explode(' ', $cleanText);

            $batasKata = 150;
            $kumpulanChunk = array_chunk($kumpulanKata, $batasKata);

            $jumlahDataMasuk = 0;

            foreach ($kumpulanChunk as $potonganKata) {
                $teksChunk = implode(' ', $potonganKata);

                if (strlen($teksChunk) < 50) {
                    continue;
                }

                KnowledgeBase::create([
                    'kategori'   => 'Dokumen: ' . $namaFile,
                    'pertanyaan' => 'Ekstraksi PDF (Otomatis 150 Kata)',
                    'jawaban'    => $teksChunk,
                    'is_active'  => 1
                ]);

                $jumlahDataMasuk++;
            }

            return redirect()->route('admin.kb.index')
                ->with('success', "Mantap! $jumlahDataMasuk blok data (per 150 kata) dari Dokumen PDF berhasil dipelajari oleh Asisten AI.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors([
                    'error' => 'Gagal memproses PDF: ' . $e->getMessage()
                ]);
        }
    }

    public function syncDatabaseToAI()
    {
        $berhasil = KnowledgeBase::autoSync();

        if ($berhasil) {
            return redirect()->back()
                ->with('success', 'Pipeline Berhasil! Data Obat dan Dokter terbaru dari database telah dipelajari oleh AI.');
        }

        return redirect()->back()
            ->withErrors([
                'error' => 'Gagal Sinkronisasi Pipeline. Periksa koneksi internet atau API Gemini.'
            ]);
    }
}