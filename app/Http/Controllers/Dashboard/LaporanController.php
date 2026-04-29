<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        $kunjungans = Kunjungan::with(['pasien', 'dokter'])
            ->where('status', 'diambil')
            ->whereDate('updated_at', '>=', $startDate)
            ->whereDate('updated_at', '<=', $endDate)
            ->latest()
            ->get();

        $totalTunai = $kunjungans->sum('total_bayar');

        $totalKlaimBpjs = $kunjungans
            ->where('status_pembayaran', 'Klaim BPJS')
            ->sum(function ($k) {
                return $k->biaya_jasa_dokter + $k->biaya_obat;
            });

        $totalOmzet = $totalTunai + $totalKlaimBpjs;

        return view('admin.laporan.index', compact(
            'kunjungans',
            'startDate',
            'endDate',
            'totalTunai',
            'totalKlaimBpjs',
            'totalOmzet'
        ));
    }

    public function exportPdf(Request $request)
    {
        $tgl_awal = $request->input('start_date');
        $tgl_akhir = $request->input('end_date');

        $kunjungans = Kunjungan::with(['pasien', 'dokter', 'obat'])
            ->where('status', 'diambil')
            ->whereDate('updated_at', '>=', $tgl_awal)
            ->whereDate('updated_at', '<=', $tgl_akhir)
            ->get();

        $total_tunai = $kunjungans->sum('total_bayar');

        $total_klaim = $kunjungans
            ->where('status_pembayaran', 'Klaim BPJS')
            ->sum(function ($k) {
                return $k->biaya_jasa_dokter + $k->biaya_obat;
            });

        $grand_total = $total_tunai + $total_klaim;

        $pdf = Pdf::loadView('admin.laporan.cetak', compact(
            'kunjungans',
            'tgl_awal',
            'tgl_akhir',
            'total_tunai',
            'total_klaim',
            'grand_total'
        ));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan-Keuangan.pdf');
    }

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

        $callback = function () use ($kunjungans) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Tanggal',
                'Pasien',
                'Dokter',
                'Diagnosa',
                'Metode Bayar',
                'Biaya Jasa',
                'Biaya Obat',
                'Total Asli (Omzet)',
                'Dibayar Pasien (Tunai)'
            ]);

            foreach ($kunjungans as $row) {
                $totalAsli = $row->biaya_jasa_dokter + $row->biaya_obat;

                fputcsv($file, [
                    $row->updated_at->format('Y-m-d'),
                    $row->pasien->nama_lengkap,
                    $row->dokter->nama_lengkap,
                    $row->diagnosa,
                    $row->status_pembayaran,
                    $row->biaya_jasa_dokter,
                    $row->biaya_obat,
                    $totalAsli,
                    $row->total_bayar
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}