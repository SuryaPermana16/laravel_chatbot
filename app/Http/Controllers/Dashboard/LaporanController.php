<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Barryvdh\DomPDF\Facade\Pdf; 

class LaporanController extends Controller
{
    // 1. HALAMAN UTAMA LAPORAN (Lihat Tabel + Filter)
    public function index(Request $request)
    {
        // Default: Tampilkan data hari ini jika tidak ada filter
        $startDate = $request->input('start_date', date('Y-m-01')); // Default tgl 1 bulan ini
        $endDate = $request->input('end_date', date('Y-m-d'));      // Default hari ini

        // Query Data Lunas ('diambil')
        $kunjungans = Kunjungan::with(['pasien', 'dokter'])
            ->where('status', 'diambil')
            ->whereDate('updated_at', '>=', $startDate)
            ->whereDate('updated_at', '<=', $endDate)
            ->latest()
            ->get();

        // Hitung Total Uang Masuk
        $totalPemasukan = $kunjungans->sum('total_bayar');

        return view('admin.laporan.index', compact('kunjungans', 'startDate', 'endDate', 'totalPemasukan'));
    }

    // 2. EXPORT KE PDF
    public function exportPdf(Request $request)
    {
        $tgl_awal = $request->input('start_date');
        $tgl_akhir = $request->input('end_date');

        $kunjungans = Kunjungan::with(['pasien', 'dokter', 'obat'])
            ->where('status', 'diambil')
            ->whereDate('updated_at', '>=', $tgl_awal)
            ->whereDate('updated_at', '<=', $tgl_akhir)
            ->get();

        $total_pemasukan = $kunjungans->sum('total_bayar');

        $pdf = Pdf::loadView('admin.laporan.cetak', compact('kunjungans', 'tgl_awal', 'tgl_akhir', 'total_pemasukan'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan-Keuangan.pdf');
    }

    // 3. EXPORT KE EXCEL (CSV Ringan)
    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $filename = "Laporan-$startDate-sd-$endDate.csv";

        $kunjungans = Kunjungan::with(['pasien', 'dokter'])
            ->where('status', 'diambil')
            ->whereDate('updated_at', '>=', $startDate)
            ->whereDate('updated_at', '<=', $endDate)
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($kunjungans) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Pasien', 'Dokter', 'Diagnosa', 'Biaya Jasa', 'Biaya Obat', 'Total Bayar']);

            foreach ($kunjungans as $row) {
                fputcsv($file, [
                    $row->updated_at->format('Y-m-d'),
                    $row->pasien->nama_lengkap,
                    $row->dokter->nama_lengkap,
                    $row->diagnosa,
                    $row->biaya_jasa_dokter,
                    $row->biaya_obat,
                    $row->total_bayar
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}