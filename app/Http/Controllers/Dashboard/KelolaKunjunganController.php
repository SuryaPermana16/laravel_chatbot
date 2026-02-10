<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KelolaKunjunganController extends Controller
{
    public function index()
    {
        // 1. Ambil data kunjungan HANYA HARI INI
        // 2. Urutkan berdasarkan JAM PILIHAN (Ascending / Pagi ke Sore)
        $kunjungans = Kunjungan::with(['pasien', 'dokter'])
            ->whereDate('tanggal_kunjungan', Carbon::today()) 
            ->orderBy('jam_pilihan', 'asc')
            ->get();

        return view('admin.kunjungan.index', compact('kunjungans'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi status yang diperbolehkan
        $request->validate([
            'status' => 'required|in:menunggu,diperiksa,selesai,batal'
        ]);

        // Update Status
        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->update(['status' => $request->status]);

        return back()->with('success', 'Status pasien berhasil diperbarui!');
    }
}