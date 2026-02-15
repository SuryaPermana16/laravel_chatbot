<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f3f4f6; padding: 20px; }
        .ticket { max-width: 400px; margin: 0 auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background-color: #2563eb; color: white; padding: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 20px; text-align: center; }
        .label { color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: bold; margin-top: 15px; }
        .value { color: #111827; font-size: 16px; font-weight: bold; margin-bottom: 5px; }
        .queue-number { font-size: 48px; color: #2563eb; font-weight: 800; margin: 10px 0; }
        .footer { background-color: #f9fafb; padding: 15px; text-align: center; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb; }
        .btn { display: inline-block; background-color: #2563eb; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; margin-top: 20px; font-size: 14px; }
    </style>
</head>
<body>

    <div class="ticket">
        <div class="header">
            <h1>Tiket Antrian Online</h1>
            <p style="margin: 5px 0 0 0; font-size: 12px; opacity: 0.8;">Simpan bukti pendaftaran ini</p>
        </div>
        
        <div class="content">
            <div class="label">NOMOR ANTRIAN ANDA</div>
            <div class="queue-number">{{ $kunjungan->no_antrian }}</div>
            
            <div class="label">DOKTER & SPESIALIS</div>
            <div class="value">{{ $kunjungan->dokter->nama_lengkap }}</div>
            <div style="font-size: 12px; color: #2563eb;">({{ $kunjungan->dokter->spesialis }})</div>

            <div class="label">WAKTU KUNJUNGAN</div>
            <div class="value">
                {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </div>
            <div class="value" style="color: #dc2626;">
                Pukul: {{ $kunjungan->jam_pilihan }} WITA
            </div>

            <p style="font-size: 11px; color: #9ca3af; margin-top: 20px; font-style: italic;">
                *Harap datang 15 menit sebelum jadwal. Tunjukkan email ini ke petugas resepsionis.
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Sistem Klinik Digital.
        </div>
    </div>

</body>
</html>