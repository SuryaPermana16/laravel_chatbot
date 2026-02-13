<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::latest()->get();
        return view('apoteker.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('apoteker.obat.create');
    }

    public function store(Request $request)
    {
        // HAPUS 'jenis_obat' DARI VALIDASI
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'satuan' => 'required|string',
        ]);

        Obat::create($request->all());

        return redirect()->route('apoteker.obat.index')->with('success', 'Obat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('apoteker.obat.edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        // HAPUS 'jenis_obat' DARI VALIDASI
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'satuan' => 'required|string',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update($request->all());

        return redirect()->route('apoteker.obat.index')->with('success', 'Data obat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('apoteker.obat.index')->with('success', 'Obat berhasil dihapus!');
    }

    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'stok' => $request->stok
        ]);

        return redirect()->back()->with('success', 'Stok berhasil diupdate dari Dashboard!');
    }
}