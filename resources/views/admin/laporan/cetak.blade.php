<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan - Klinik Bina Usada</title>
    <style>
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            font-size: 9pt; 
            color: #333;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .header h1 { 
            margin: 0; 
            font-size: 18pt; 
            font-weight: bold; 
            color: #1e40af; /* Biru Gelap */
            text-transform: uppercase; 
            letter-spacing: 1px;
        }
        .header p { 
            margin: 3px 0; 
            font-size: 10pt; 
            color: #555;
        }
        .line { 
            border-bottom: 2px solid #1e40af; 
            margin-bottom: 2px; 
        }
        .line-thin { 
            border-bottom: 1px solid #1e40af; 
            margin-bottom: 20px; 
        }
        
        .title-section {
            text-align: center; 
            margin-bottom: 20px;
        }
        .title-section h3 {
            margin: 0 0 5px 0;
            font-size: 12pt;
            text-transform: uppercase;
        }
        .title-section .periode {
            font-size: 10pt;
            background-color: #f1f5f9;
            padding: 4px 12px;
            border-radius: 4px;
            display: inline-block;
            border: 1px solid #e2e8f0;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        th, td { 
            border: 1px solid #cbd5e1; /* Border abu-abu halus */
            padding: 8px 6px; 
            vertical-align: top; 
        }
        th { 
            background-color: #f8fafc; 
            font-weight: bold; 
            text-align: center; 
            color: #475569;
            text-transform: uppercase;
            font-size: 8pt;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .bg-gray { background-color: #f1f5f9; }
        .text-blue { color: #2563eb; }

        .obat-list { 
            margin: 0; 
            padding-left: 12px; 
            font-size: 8pt; 
            color: #64748b;
        }
        
        .summary-row td {
            font-size: 10pt;
            padding: 12px 8px;
            border-top: 2px solid #cbd5e1;
        }

        .footer { 
            margin-top: 40px; 
            width: 100%; 
        }
        .ttd { 
            float: right; 
            width: 250px; 
            text-align: center; 
        }
        .ttd p { margin: 2px 0; }
    </style>
</head>
<body>

    <div class="header">
        <h1>KLINIK BINA USADA</h1>
        <p>Jl. Gatot Subroto Barat No.101, Ubung, Denpasar, Bali</p>
        <p>Telp: (0361) 410764 | Email: admin@klinikbinausada.com</p>
    </div>
    <div class="line"></div>
    <div class="line-thin"></div>

    <div class="title-section">
        <h3>Laporan Pendapatan & Kunjungan Pasien</h3>
        <span class="periode">Periode: {{ date('d F Y', strtotime($tgl_awal)) }} s.d. {{ date('d F Y', strtotime($tgl_akhir)) }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%">No</th>
                <th style="width: 10%">Tanggal</th>
                <th style="width: 14%">Nama Pasien</th>
                <th style="width: 12%">Dokter</th>
                <th style="width: 15%">Diagnosa Akhir</th>
                <th style="width: 15%">Resep Obat</th>
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
                    {{ date('d/m/Y', strtotime($row->updated_at)) }}<br>
                    <span style="font-size: 7pt; color: #94a3b8;">{{ date('H:i', strtotime($row->updated_at)) }}</span>
                </td>
                <td>
                    <b style="color: #0f172a;">{{ $row->pasien->nama_lengkap }}</b><br>
                    <span style="font-size: 7pt; color: #64748b;">RM: {{ $row->pasien->no_rm ?? '-' }}</span>
                </td>
                <td style="font-size: 8pt;">Dr. {{ $row->dokter->nama_lengkap }}</td>
                <td style="font-size: 8pt;">{{ $row->diagnosa }}</td>
                <td>
                    @if($row->obat->count() > 0)
                        <ul class="obat-list">
                        @foreach($row->obat as $o)
                            <li>{{ $o->nama_obat }} ({{ $o->pivot->jumlah }})</li>
                        @endforeach
                        </ul>
                    @else
                        <div class="text-center" style="color: #94a3b8; font-size: 8pt;">- Tidak ada -</div>
                    @endif
                </td>
                <td class="text-right" style="font-family: monospace; font-size: 8pt;">{{ number_format($row->biaya_jasa_dokter, 0, ',', '.') }}</td>
                <td class="text-right" style="font-family: monospace; font-size: 8pt;">{{ number_format($row->biaya_obat, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="font-family: monospace; font-size: 9pt;">{{ number_format($row->total_bayar, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 20px; color: #64748b; font-style: italic;">
                    Tidak ada data transaksi yang lunas (selesai) pada rentang tanggal tersebut.
                </td>
            </tr>
            @endforelse
            
            <tr class="bg-gray summary-row">
                <td colspan="8" class="text-right font-bold" style="letter-spacing: 1px;">TOTAL PENDAPATAN PERIODE INI</td>
                <td class="text-right font-bold text-blue" style="font-family: monospace; font-size: 11pt;">Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Denpasar, {{ date('d F Y', strtotime('2026-02-22')) }}</p>
            <p style="margin-bottom: 60px;">Mengetahui,</p>
            <p class="font-bold text-blue" style="text-decoration: underline; font-size: 11pt;">{{ Auth::user()->name }}</p>
            <p style="color: #64748b; font-size: 9pt;">Administrator Klinik</p>
        </div>
    </div>

</body>
</html>