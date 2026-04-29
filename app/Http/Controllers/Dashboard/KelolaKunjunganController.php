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
        $kunjungans = Kunjungan::with(['pasien', 'dokter'])
            ->whereDate('tanggal_kunjungan', Carbon::today())
            ->orderBy('jam_pilihan', 'asc')
            ->get();

        return view('admin.kunjungan.index', compact('kunjungans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diperiksa,selesai,batal'
        ]);

        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pasien berhasil diperbarui!');
    }
}