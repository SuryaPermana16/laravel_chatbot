<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kunjungan</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 12px; }
        .line { border-bottom: 2px solid black; margin-bottom: 2px; }
        .line-thin { border-bottom: 1px solid black; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        table, th, td { border: 1px solid black; }
        th { background-color: #f2f2f2; padding: 8px; text-align: left; }
        td { padding: 6px; }
        
        .tanda-tangan { margin-top: 50px; text-align: right; font-size: 12px; }
        .tanda-tangan p { margin: 0; }
        .ttd-space { height: 60px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>KLINIK BINA USADA</h1>
        <p>Jl. Merdeka No. 123, Kota Sehat, Indonesia</p>
        <p>Telp: (021) 555-9999 | Email: info@klinikbinausada.com</p>
    </div>
    <div class="line"></div>
    <div class="line-thin"></div>

    <h3 style="text-align: center;">LAPORAN DATA KUNJUNGAN PASIEN</h3>
    <p style="text-align: center; font-size: 12px;">Periode: {{ date('d F Y', strtotime($tgl_awal)) }} s/d {{ date('d F Y', strtotime($tgl_akhir)) }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 10%;">Jam</th>
                <th style="width: 20%;">Nama Pasien</th>
                <th style="width: 20%;">Dokter Tujuan</th>
                <th style="width: 20%;">Keluhan</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kunjungans as $index => $k)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ date('d-m-Y', strtotime($k->tanggal_kunjungan)) }}</td>
                <td style="text-align: center;">{{ date('H:i', strtotime($k->jam_pilihan)) }}</td>
                <td>{{ $k->pasien->nama_lengkap }}</td>
                <td>{{ $k->dokter->nama_lengkap }}</td>
                <td>{{ Str::limit($k->keluhan, 30) }}</td>
                <td style="text-transform: capitalize;">{{ $k->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada data pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="tanda-tangan">
        <p>Dicetak pada: {{ date('d F Y') }}</p>
        <p>Mengetahui,</p>
        <div class="ttd-space"></div> <p><b>{{ Auth::user()->name }}</b></p>
        <p>Administrator</p>
    </div>

</body>
</html>