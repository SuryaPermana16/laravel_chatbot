<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan Klinik</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 9pt; }
        .line { border-bottom: 2px solid #000; margin-bottom: 2px; }
        .line-thin { border-bottom: 1px solid #000; margin-bottom: 15px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 5px; vertical-align: top; }
        th { background-color: #e0e0e0; font-weight: bold; text-align: center; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .bg-gray { background-color: #f0f0f0; }

        /* Helper untuk obat */
        .obat-list { margin: 0; padding-left: 15px; font-size: 8pt; }
        
        .footer { margin-top: 30px; width: 100%; }
        .ttd { float: right; width: 200px; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>KLINIK BINA USADA</h1>
        <p>Jl. Raya Kesehatan No. 123, Denpasar, Bali</p>
        <p>Telp: (0361) 123-4567 | Email: admin@klinikbinausada.com</p>
    </div>
    <div class="line"></div>
    <div class="line-thin"></div>

    <div style="text-align: center; margin-bottom: 15px;">
        <h3 style="margin:0;">LAPORAN PENDAPATAN & REKAM MEDIS</h3>
        <span style="font-size: 9pt;">Periode: {{ date('d F Y', strtotime($tgl_awal)) }} s.d. {{ date('d F Y', strtotime($tgl_akhir)) }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%">No</th>
                <th style="width: 10%">Tanggal</th>
                <th style="width: 12%">Pasien</th>
                <th style="width: 12%">Dokter</th>
                <th style="width: 15%">Diagnosa</th>
                <th style="width: 17%">Resep / Obat</th>
                <th style="width: 10%">Jasa (Rp)</th>
                <th style="width: 10%">Obat (Rp)</th>
                <th style="width: 10%">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kunjungans as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    {{ date('d/m/y', strtotime($row->updated_at)) }}<br>
                    <small>{{ date('H:i', strtotime($row->updated_at)) }}</small>
                </td>
                <td>
                    <b>{{ $row->pasien->nama_lengkap }}</b><br>
                    <small>RM: {{ $row->pasien->no_rm ?? '-' }}</small>
                </td>
                <td>{{ $row->dokter->nama_lengkap }}</td>
                <td>{{ $row->diagnosa }}</td>
                <td>
                    @if($row->obat->count() > 0)
                        <ul class="obat-list">
                        @foreach($row->obat as $o)
                            <li>{{ $o->nama_obat }} ({{ $o->pivot->jumlah }})</li>
                        @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </td>
                <td class="text-right">{{ number_format($row->biaya_jasa_dokter, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($row->biaya_obat, 0, ',', '.') }}</td>
                <td class="text-right font-bold">{{ number_format($row->total_bayar, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 15px;">Data transaksi tidak ditemukan pada periode ini.</td>
            </tr>
            @endforelse
            
            <tr class="bg-gray">
                <td colspan="8" class="text-right font-bold" style="padding: 8px;">TOTAL PENDAPATAN PERIODE INI</td>
                <td class="text-right font-bold" style="padding: 8px;">Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Denpasar, {{ date('d F Y') }}</p>
            <p>Mengetahui,</p>
            <br><br><br>
            <p class="font-bold"><u>{{ Auth::user()->name }}</u></p>
            <p>Administrator</p>
        </div>
    </div>

</body>
</html>