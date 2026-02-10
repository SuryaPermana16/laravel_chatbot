<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use PDF; // Import Library PDF

class LaporanController extends Controller
{
    public function index()
    {
        // Tampilkan halaman filter tanggal
        return view('admin.laporan.index');
    }

    public function cetak(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
        ]);

        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        // Ambil data kunjungan berdasarkan rentang tanggal
        $kunjungans = Kunjungan::with(['pasien', 'dokter'])
            ->whereBetween('tanggal_kunjungan', [$tgl_awal, $tgl_akhir])
            ->orderBy('tanggal_kunjungan', 'asc')
            ->get();

        // Load view khusus PDF dan kirim datanya
        $pdf = PDF::loadView('admin.laporan.cetak', compact('kunjungans', 'tgl_awal', 'tgl_akhir'));
        
        // Atur ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // Download / Stream file PDF
        return $pdf->stream('Laporan-Kunjungan-'.$tgl_awal.'-sd-'.$tgl_akhir.'.pdf');
    }
}