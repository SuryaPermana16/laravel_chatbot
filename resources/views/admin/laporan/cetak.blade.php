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
            color: #1e40af;
            text-transform: uppercase; 
            letter-spacing: 1px;
        }
        .header p { 
            margin: 3px 0; 
            font-size: 10pt; 
            color: #555;
        }
        .line { border-bottom: 2px solid #1e40af; margin-bottom: 2px; }
        .line-thin { border-bottom: 1px solid #1e40af; margin-bottom: 20px; }
        
        .title-section { text-align: center; margin-bottom: 15px; }
        .title-section h3 { margin: 0 0 5px 0; font-size: 12pt; text-transform: uppercase; }
        .title-section .periode {
            font-size: 10pt; background-color: #f1f5f9; padding: 4px 12px;
            border-radius: 4px; display: inline-block; border: 1px solid #e2e8f0;
        }

        /* SUMMARY BOXES (Baru) */
        .summary-container {
            width: 100%;
            margin-bottom: 20px;
        }
        .summary-box {
            display: inline-block;
            width: 31%; /* 3 Kolom */
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 10px;
            text-align: center;
            box-sizing: border-box;
        }
        .summary-title { font-size: 8pt; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
        .summary-value { font-size: 14pt; font-weight: bold; color: #0f172a; margin: 0; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 6px; vertical-align: top; }
        th { background-color: #f8fafc; font-weight: bold; text-align: center; color: #475569; text-transform: uppercase; font-size: 8pt; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .bg-gray { background-color: #f1f5f9; }
        .text-blue { color: #2563eb; }
        .text-green { color: #16a34a; }

        .obat-list { margin: 0; padding-left: 12px; font-size: 8pt; color: #64748b; }
        
        .footer { margin-top: 40px; width: 100%; }
        .ttd { float: right; width: 250px; text-align: center; }
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

    <div class="summary-container">
        <div class="summary-box">
            <div class="summary-title">Total Pendapatan Tunai (Umum)</div>
            <p class="summary-value text-green">Rp {{ number_format($total_tunai, 0, ',', '.') }}</p>
        </div>
        <div class="summary-box" style="margin: 0 2%;">
            <div class="summary-title">Total Piutang Klaim (BPJS)</div>
            <p class="summary-value text-blue">Rp {{ number_format($total_klaim, 0, ',', '.') }}</p>
        </div>
        <div class="summary-box">
            <div class="summary-title">Grand Total Omzet</div>
            <p class="summary-value">Rp {{ number_format($grand_total, 0, ',', '.') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%">No</th>
                <th style="width: 10%">Tanggal</th>
                <th style="width: 14%">Nama Pasien</th>
                <th style="width: 12%">Status Bayar</th>
                <th style="width: 15%">Resep Obat</th>
                <th style="width: 12%">Biaya Asli (Rp)</th>
                <th style="width: 12%">Ditagihkan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kunjungans as $index => $row)
            @php $biayaAsli = $row->biaya_jasa_dokter + $row->biaya_obat; @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    {{ date('d/m/Y', strtotime($row->updated_at)) }}<br>
                    <span style="font-size: 7pt; color: #94a3b8;">{{ date('H:i', strtotime($row->updated_at)) }}</span>
                </td>
                <td>
                    <b style="color: #0f172a;">{{ $row->pasien->nama_lengkap }}</b><br>
                    <span style="font-size: 7pt; color: #64748b;">Dr. {{ $row->dokter->nama_lengkap }}</span>
                </td>
                <td class="text-center font-bold" style="font-size: 8pt;">
                    @if($row->status_pembayaran == 'Klaim BPJS')
                        <span class="text-blue">BPJS</span>
                    @else
                        <span class="text-green">UMUM LUNAS</span>
                    @endif
                </td>
                <td>
                    @if($row->obat->count() > 0)
                        <ul class="obat-list">
                        @foreach($row->obat as $o)
                            <li>{{ $o->nama_obat }} ({{ $o->pivot->jumlah }})</li>
                        @endforeach
                        </ul>
                    @else
                        <div class="text-center" style="color: #94a3b8; font-size: 8pt;">- Hanya Jasa -</div>
                    @endif
                </td>
                <td class="text-right" style="font-family: monospace; font-size: 8pt;">
                    {{ number_format($biayaAsli, 0, ',', '.') }}<br>
                    <span style="font-size: 6pt; color: #64748b;">Jasa: {{ number_format($row->biaya_jasa_dokter, 0, ',', '.') }}<br>Obat: {{ number_format($row->biaya_obat, 0, ',', '.') }}</span>
                </td>
                <td class="text-right font-bold" style="font-family: monospace; font-size: 9pt;">
                    @if($row->status_pembayaran == 'Klaim BPJS')
                        0
                    @else
                        {{ number_format($row->total_bayar, 0, ',', '.') }}
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px; color: #64748b; font-style: italic;">
                    Tidak ada data transaksi yang lunas (selesai) pada rentang tanggal tersebut.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Denpasar, {{ date('d F Y') }}</p>
            <p style="margin-bottom: 60px;">Mengetahui,</p>
            <p class="font-bold text-blue" style="text-decoration: underline; font-size: 11pt;">{{ Auth::user()->name ?? 'Administrator' }}</p>
            <p style="color: #64748b; font-size: 9pt;">Pimpinan Klinik</p>
        </div>
    </div>

</body>
</html>