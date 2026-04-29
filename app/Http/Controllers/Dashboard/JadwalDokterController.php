<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\JadwalDokter;
use App\Models\Dokter;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $jadwals = JadwalDokter::with('dokter')->latest()->get();

        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $dokters = Dokter::all();

        return view('admin.jadwal.create', compact('dokters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokter_id'   => 'required|exists:dokters,id',
            'hari'        => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ]);

        JadwalDokter::create($request->all());

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal praktek berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $dokters = Dokter::all();

        return view('admin.jadwal.edit', compact('jadwal', 'dokters'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalDokter::findOrFail($id);

        $request->validate([
            'dokter_id'   => 'required|exists:dokters,id',
            'hari'        => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal praktek diperbarui!');
    }

    public function destroy($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal dihapus!');
    }
}