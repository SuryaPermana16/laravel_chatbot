<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KnowledgeBase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
}