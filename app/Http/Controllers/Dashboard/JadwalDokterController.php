<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\JadwalDokter;
use App\Models\Dokter;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    // 1. DAFTAR JADWAL
    public function index()
    {
        // Ambil jadwal beserta info dokternya
        $jadwals = JadwalDokter::with('dokter')->latest()->get();
        return view('admin.jadwal.index', compact('jadwals'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        // Kita butuh data dokter buat dipilih di Dropdown
        $dokters = Dokter::all(); 
        return view('admin.jadwal.create', compact('dokters'));
    }

    // 3. SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        JadwalDokter::create($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal praktek berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $dokters = Dokter::all(); // Data dokter buat dropdown
        return view('admin.jadwal.edit', compact('jadwal', 'dokters'));
    }

    // 5. UPDATE DATA
    public function update(Request $request, $id)
    {
        $jadwal = JadwalDokter::findOrFail($id);

        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal praktek diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal dihapus!');
    }
}