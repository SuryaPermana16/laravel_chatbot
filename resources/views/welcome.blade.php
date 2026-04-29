<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik Bina Usada</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], },
                    colors: { primary: '#2563eb', secondary: '#1e40af', dark: '#0f172a' }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-800 bg-white selection:bg-primary selection:text-white">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                    <i class="fas fa-heartbeat text-3xl text-primary"></i>
                    <span class="font-extrabold text-2xl tracking-tight text-dark">Klinik <span class="text-primary">Bina Usada</span></span>
                </div>
                
                <div class="hidden md:flex space-x-8 items-center font-medium text-gray-600">
                    <a href="#" class="hover:text-primary transition">Beranda</a>
                    <a href="#layanan" class="hover:text-primary transition">Layanan</a>
                    <a href="#tentang" class="hover:text-primary transition">Tentang Kami</a>
                    <a href="#dokter" class="hover:text-primary transition">Dokter</a>
                    <a href="#kontak" class="hover:text-primary transition">Kontak</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-primary text-white px-6 py-2.5 rounded-full hover:bg-secondary transition shadow-lg shadow-blue-200">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="bg-primary text-white px-6 py-2.5 rounded-full hover:bg-secondary transition shadow-lg shadow-blue-200">
                                Login / Daftar
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-16 pb-20 lg:pt-24 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight text-dark mb-6">
                        Kesehatan Anda, <br><span class="text-primary">Prioritas Kami</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Layanan kesehatan profesional dengan dokter berpengalaman dan peralatan modern. Daftar sekarang untuk kemudahan akses layanan kami.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 mb-12">
                        <a href="{{ route('register') }}" class="bg-primary text-white text-center px-8 py-3.5 rounded-lg font-bold hover:bg-secondary transition shadow-lg shadow-blue-200">
                            Daftar Pasien Baru
                        </a>
                        <a href="{{ route('login') }}" class="border-2 border-gray-300 text-gray-700 text-center px-8 py-3.5 rounded-lg font-bold hover:border-primary hover:text-primary transition">
                            Masuk Akun
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 border-t border-gray-100 pt-8">
                        <div class="text-center sm:text-left flex flex-col sm:flex-row items-center gap-3">
                            <div class="bg-blue-50 p-3 rounded-full text-primary"><i class="far fa-calendar-check text-xl"></i></div>
                            <span class="font-semibold text-sm text-gray-700">Booking<br>Online</span>
                        </div>
                        <div class="text-center sm:text-left flex flex-col sm:flex-row items-center gap-3">
                            <div class="bg-blue-50 p-3 rounded-full text-primary"><i class="far fa-clock text-xl"></i></div>
                            <span class="font-semibold text-sm text-gray-700">Buka<br>Setiap Hari</span>
                        </div>
                        <div class="text-center sm:text-left flex flex-col sm:flex-row items-center gap-3">
                            <div class="bg-blue-50 p-3 rounded-full text-primary"><i class="fas fa-shield-alt text-xl"></i></div>
                            <span class="font-semibold text-sm text-gray-700">Terpercaya &<br>Profesional</span>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <img src="{{ asset('images/foto_depan.png') }}" alt="Klinik Bina Usada" class="rounded-3xl shadow-2xl object-cover h-[500px] w-full">
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4">
                        <div class="bg-green-100 p-3 rounded-full text-green-600"><i class="fas fa-star text-xl"></i></div>
                        <div>
                            <p class="font-extrabold text-xl text-dark">4.6/5</p>
                            <p class="text-xs text-gray-500 font-medium">Rating Pasien</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan" class="py-20 bg-gray-50 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold text-dark mb-4">Layanan Kami</h2>
                <p class="text-gray-600">Kami menyediakan berbagai layanan poli kesehatan terpadu untuk memenuhi kebutuhan Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($layanans as $layanan)
                    @php
                        $namaPoli = strtolower($layanan->spesialis);
                        $ikon = 'fas fa-notes-medical';

                        if (str_contains($namaPoli, 'gigi')) {
                            $ikon = 'fas fa-tooth';
                        } elseif (str_contains($namaPoli, 'umum')) {
                            $ikon = 'fas fa-stethoscope';
                        } elseif (str_contains($namaPoli, 'anak')) {
                            $ikon = 'fas fa-baby';
                        } elseif (str_contains($namaPoli, 'jantung')) {
                            $ikon = 'fas fa-heartbeat';
                        } elseif (str_contains($namaPoli, 'mata')) {
                            $ikon = 'far fa-eye';
                        } elseif (str_contains($namaPoli, 'tulang') || str_contains($namaPoli, 'ortopedi')) {
                            $ikon = 'fas fa-bone';
                        } elseif (str_contains($namaPoli, 'kandungan') || str_contains($namaPoli, 'obgyn')) {
                            $ikon = 'fas fa-baby-carriage';
                        } elseif (str_contains($namaPoli, 'kia')) { // PENAMBAHAN UNTUK KIA
                            $ikon = 'fas fa-children';
                        } elseif (str_contains($namaPoli, 'kulit')) {
                            $ikon = 'fas fa-allergies';
                        } elseif (str_contains($namaPoli, 'tht')) {
                            $ikon = 'fas fa-deaf';
                        } elseif (str_contains($namaPoli, 'saraf')) {
                            $ikon = 'fas fa-brain';
                        }
                    @endphp

                    <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition-shadow border border-gray-100 group">
                        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-primary text-3xl mb-6 group-hover:bg-primary group-hover:text-white transition duration-300 transform group-hover:-translate-y-1">
                            <i class="{{ $ikon }}"></i>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-3">Poli {{ $layanan->spesialis }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Layanan medis khusus untuk penanganan dan konsultasi {{ strtolower($layanan->spesialis) }}.</p>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-12 bg-white rounded-3xl border border-dashed border-gray-300 text-gray-500">
                        <i class="fas fa-clinic-medical text-4xl mb-3 text-gray-300"></i>
                        <p>Belum ada data layanan yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="tentang" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Dokter Konsultasi" class="rounded-3xl shadow-xl w-full object-cover h-[500px]">
                    <div class="absolute -top-6 -right-6 bg-primary text-white p-6 rounded-2xl shadow-lg text-center">
                        <i class="fas fa-award text-3xl mb-2"></i>
                        <p class="font-bold">ISO<br><span class="text-xs font-normal">Certified</span></p>
                    </div>
                </div>
                
                <div x-data="{ tab: 'visi' }">
                    <h2 class="text-3xl font-extrabold text-dark mb-6">Tentang <span class="text-primary">Klinik Bina Usada</span></h2>
                    
                    <div class="flex space-x-2 bg-gray-100 p-1 rounded-xl mb-6">
                        <button @click="tab = 'visi'" :class="{ 'bg-white shadow text-primary': tab === 'visi', 'text-gray-500 hover:text-gray-700': tab !== 'visi' }" class="flex-1 py-2.5 px-4 rounded-lg font-bold text-sm transition-all duration-300">Visi</button>
                        <button @click="tab = 'misi'" :class="{ 'bg-white shadow text-primary': tab === 'misi', 'text-gray-500 hover:text-gray-700': tab !== 'misi' }" class="flex-1 py-2.5 px-4 rounded-lg font-bold text-sm transition-all duration-300">Misi</button>
                        <button @click="tab = 'tujuan'" :class="{ 'bg-white shadow text-primary': tab === 'tujuan', 'text-gray-500 hover:text-gray-700': tab !== 'tujuan' }" class="flex-1 py-2.5 px-4 rounded-lg font-bold text-sm transition-all duration-300">Tujuan Klinik</button>
                    </div>

                    <div x-show="tab === 'visi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <p class="text-gray-600 mb-6 leading-relaxed text-lg font-medium italic border-l-4 border-primary pl-5">
                            "Menjadi klinik swasta yang dipilih dan dipercaya oleh masyarakat dengan mengutamakan kualitas pelayanan dan kepuasan pasien."
                        </p>
                        <div class="grid grid-cols-2 gap-6 mt-8">
                            <div class="border border-gray-200 rounded-xl p-5 text-center bg-white hover:border-primary transition">
                                <i class="fas fa-users text-3xl text-primary mb-3"></i>
                                <h4 class="text-2xl font-bold text-dark">50,000+</h4>
                                <p class="text-sm text-gray-500 font-medium">Pasien Dilayani</p>
                            </div>
                            <div class="border border-gray-200 rounded-xl p-5 text-center bg-white hover:border-primary transition">
                                <i class="fas fa-user-md text-3xl text-primary mb-3"></i>
                                <h4 class="text-2xl font-bold text-dark">20+</h4>
                                <p class="text-sm text-gray-500 font-medium">Dokter Ahli</p>
                            </div>
                        </div>
                    </div>

                    <div x-show="tab === 'misi'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-50 text-primary rounded-full flex items-center justify-center font-bold mr-4 border border-blue-100">1</div>
                                <p class="text-gray-600 leading-relaxed pt-1">Memberikan pelayanan yang ramah dan bersahabat.</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-50 text-primary rounded-full flex items-center justify-center font-bold mr-4 border border-blue-100">2</div>
                                <p class="text-gray-600 leading-relaxed pt-1">Memberikan pelayanan yang berkualitas dan terjangkau.</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-50 text-primary rounded-full flex items-center justify-center font-bold mr-4 border border-blue-100">3</div>
                                <p class="text-gray-600 leading-relaxed pt-1">Memberikan pelayanan yang terintegrasi dengan pelayanan rujukan.</p>
                            </li>
                        </ul>
                    </div>

                    <div x-show="tab === 'tujuan'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                                <p class="text-gray-600 text-sm leading-relaxed">Memberikan pelayanan kesehatan yang berkualitas kepada pasien dengan perawatan yang personal, ramah, dan empatik.</p>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                                <p class="text-gray-600 text-sm leading-relaxed">Meningkatkan kepuasan pasien dengan mendengarkan, memahami, dan merespon kebutuhan serta harapan mereka secara efektif.</p>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                                <p class="text-gray-600 text-sm leading-relaxed">Menyediakan tim medis yang terlatih dan berpengalaman yang menjalankan praktik medis dan terus mengikuti perkembangan terbaru dalam bidang kesehatan.</p>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                                <p class="text-gray-600 text-sm leading-relaxed">Mengelola administrasi pasien dengan efisien dan transparan serta memberikan kemudahan akses bagi pasien.</p>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                                <p class="text-gray-600 text-sm leading-relaxed">Meningkatkan kesadaran dan edukasi masyarakat mengenai pentingnya kesehatan dan pencegahan penyakit melalui program-program penyuluhan dan kampanye kesehatan.</p>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="dokter" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold text-dark mb-4">Tim Dokter Kami</h2>
                <p class="text-gray-600">Klik kartu dokter untuk melihat jadwal praktik secara lengkap dan detail.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    // Kumpulan Foto Dummy Dokter Laki-Laki (HANYA PAKAI 2 FOTO YANG TERBUKTI JALAN)
                    $maleImages = [
                        'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1537368910025-700350fe46c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
                    ];

                    // Kumpulan Foto Dummy Dokter Perempuan (HANYA PAKAI 2 FOTO YANG TERBUKTI JALAN)
                    $femaleImages = [
                        'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1527613426441-4da17471b66d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
                    ];

                    $maleIndex = 0;
                    $femaleIndex = 0;
                @endphp

                @forelse($dokters as $d)
                
                @php
                    $urutanHari = ['senin' => 1, 'selasa' => 2, 'rabu' => 3, 'kamis' => 4, 'jumat' => 5, 'sabtu' => 6, 'minggu' => 7];
                    
                    // Ambil jadwal dan urutkan
                    $jadwalSorted = $d->jadwals->sortBy(function($j) use ($urutanHari) {
                        return $urutanHari[strtolower($j->hari)] ?? 99;
                    });

                    // --- LOGIKA PENENTUAN GENDER OTOMATIS (BUG FIXED) ---
                    $isFemale = false;

                    // 1. Cek dari database (jika ada kolom jenis kelamin)
                    if (!empty($d->jenis_kelamin)) {
                        $jk = strtolower(trim($d->jenis_kelamin));
                        if (in_array($jk, ['p', 'perempuan', 'wanita', 'w', 'female'])) {
                            $isFemale = true;
                        } elseif (in_array($jk, ['l', 'laki-laki', 'pria', 'male', 'laki'])) {
                            $isFemale = false;
                        }
                    } 
                    
                    // 2. Jika di database kosong, tebak dari nama (Disempurnakan)
                    if (empty($d->jenis_kelamin)) {
                        $kataPerempuan = ['luh', 'ayu', 'dewi', 'dita', 'arsintha', 'shakuntalangi', 'ni', 'istri', 'putri', 'sri', 'tari', 'wati', 'eka', 'indah', 'sari', 'nur', 'astri', 'ika', 'indirasari'];
                        foreach ($kataPerempuan as $kata) {
                            // Menggunakan regex word boundary (\b) agar hanya mendeteksi KATA UTUH
                            if (preg_match("/\b" . $kata . "\b/i", $d->nama_lengkap)) {
                                $isFemale = true;
                                break;
                            }
                        }
                    }

                    // Tentukan foto yang dipakai agar tidak berurutan sama
                    if ($isFemale) {
                        $fotoDokter = $femaleImages[$femaleIndex % count($femaleImages)];
                        $femaleIndex++;
                    } else {
                        $fotoDokter = $maleImages[$maleIndex % count($maleImages)];
                        $maleIndex++;
                    }
                @endphp

                <div x-data="{ showJadwal: false }">
                    
                    <div @click="showJadwal = true" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all border border-gray-100 group cursor-pointer h-full flex flex-col transform hover:-translate-y-2">
                        <div class="relative overflow-hidden">
                            <img src="{{ $fotoDokter }}" alt="{{ $d->nama_lengkap }}" class="w-full h-72 object-cover object-top filter grayscale group-hover:grayscale-0 transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-500 flex items-end justify-center pb-6">
                                <span class="text-white font-bold text-sm bg-primary/90 px-4 py-2 rounded-full backdrop-blur-sm shadow-lg">
                                    <i class="far fa-calendar-alt mr-2"></i> Lihat Jadwal
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6 relative bg-white flex-1 text-center">
                            <h3 class="font-black text-xl text-dark mb-1">{{ $d->nama_lengkap }}</h3>
                            <p class="text-primary font-bold text-sm uppercase tracking-widest bg-blue-50 inline-block px-3 py-1 rounded-md">Poli {{ $d->spesialis }}</p>
                        </div>
                    </div>

                    <div x-show="showJadwal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="showJadwal = false" x-transition.opacity></div>
                        
                        <div class="relative bg-white rounded-3xl w-full max-w-md p-6 sm:p-8 shadow-2xl transform transition-all"
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95">
                             
                             <div class="flex justify-between items-start mb-6">
                                 <div class="flex items-center gap-4">
                                     <img src="{{ $fotoDokter }}" class="w-16 h-16 rounded-full object-cover border-4 border-blue-50 shadow-sm">
                                     <div>
                                         <h3 class="font-black text-xl text-dark leading-tight">{{ $d->nama_lengkap }}</h3>
                                         <p class="text-xs font-bold text-primary uppercase tracking-widest mt-1">Poli {{ $d->spesialis }}</p>
                                     </div>
                                 </div>
                                 <button @click="showJadwal = false" class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-red-100 hover:text-red-500 transition">
                                     <i class="fas fa-times"></i>
                                 </button>
                             </div>

                             <div class="bg-slate-50 rounded-2xl p-5 border border-gray-100 shadow-inner">
                                 <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                     <i class="far fa-clock text-blue-400"></i> Rincian Jadwal Praktik
                                 </h4>
                                 
                                 @if($jadwalSorted->count() > 0)
                                     <div class="space-y-3">
                                         @foreach($jadwalSorted as $j)
                                             <div class="flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:border-blue-300 transition group">
                                                 <div class="font-bold text-gray-800 flex items-center gap-3">
                                                     <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition">
                                                         <i class="far fa-calendar"></i>
                                                     </div>
                                                     {{ strtoupper($j->hari) }}
                                                 </div>
                                                 <div class="font-black text-dark text-sm bg-gray-50 px-3 py-1.5 rounded-lg">
                                                     {{ date('H:i', strtotime($j->jam_mulai)) }} - {{ date('H:i', strtotime($j->jam_selesai)) }}
                                                 </div>
                                             </div>
                                         @endforeach
                                     </div>
                                 @else
                                     <div class="text-center py-8">
                                         <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-300 text-2xl">
                                             <i class="fas fa-calendar-times"></i>
                                         </div>
                                         <p class="text-gray-500 font-medium">Jadwal dokter belum tersedia.</p>
                                     </div>
                                 @endif
                             </div>

                             <div class="mt-8">
                                 <a href="{{ route('login') }}" class="flex items-center justify-center w-full bg-gray-900 hover:bg-primary text-white text-center font-bold py-4 rounded-xl transition duration-300 shadow-lg shadow-gray-300 gap-2">
                                     Buat Janji Temu <i class="fas fa-paper-plane text-sm"></i>
                                 </a>
                             </div>
                        </div>
                    </div>

                </div>
                @empty
                <div class="col-span-4 text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-300 text-gray-500">
                    <i class="fas fa-user-md text-4xl mb-3 text-gray-300"></i>
                    <p>Belum ada data dokter yang ditampilkan.</p>
                </div>
                @endforelse
            </div>
            
            @if($dokters->count() >= 10)
            <div class="text-center mt-14">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 border-2 border-primary text-primary px-8 py-3 rounded-full font-bold hover:bg-primary hover:text-white transition duration-300">
                    <span>Lihat Semua Dokter</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    <section id="cara-daftar" class="py-20 bg-blue-50/50 border-y border-blue-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-primary font-bold tracking-wider uppercase text-sm mb-2 block">Pendaftaran Online</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-dark mb-4">4 Langkah Mudah Berobat</h2>
                <p class="text-gray-600 text-lg">Tidak perlu antre berjam-jam di ruang tunggu. Nikmati kemudahan reservasi jadwal dokter dari rumah Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 relative">
                <div class="hidden lg:block absolute top-10 left-[12%] right-[12%] h-1 bg-gradient-to-r from-blue-200 via-primary to-blue-200 z-0 rounded-full opacity-50"></div>

                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-xl shadow-blue-100 border border-gray-100 flex items-center justify-center text-3xl text-primary mb-6 transform group-hover:-translate-y-2 group-hover:scale-110 transition duration-300">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center font-bold absolute top-14 -right-2 border-4 border-blue-50">1</div>
                    <h3 class="text-xl font-bold text-dark mb-2">Login / Daftar</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Masuk ke portal pasien atau buat akun baru jika Anda belum terdaftar.</p>
                </div>

                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-xl shadow-blue-100 border border-gray-100 flex items-center justify-center text-3xl text-primary mb-6 transform group-hover:-translate-y-2 group-hover:scale-110 transition duration-300">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center font-bold absolute top-14 -right-2 border-4 border-blue-50">2</div>
                    <h3 class="text-xl font-bold text-dark mb-2">Pilih Dokter</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Pilih poli layanan, dokter spesialis, dan tentukan tanggal kunjungan.</p>
                </div>

                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-xl shadow-blue-100 border border-gray-100 flex items-center justify-center text-3xl text-primary mb-6 transform group-hover:-translate-y-2 group-hover:scale-110 transition duration-300">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center font-bold absolute top-14 -right-2 border-4 border-blue-50">3</div>
                    <h3 class="text-xl font-bold text-dark mb-2">Dapat Antrean</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Sistem akan memberikan nomor antrean dan estimasi jam periksa Anda.</p>
                </div>

                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-xl shadow-blue-100 border border-gray-100 flex items-center justify-center text-3xl text-primary mb-6 transform group-hover:-translate-y-2 group-hover:scale-110 transition duration-300">
                        <i class="fas fa-clinic-medical"></i>
                    </div>
                    <div class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center font-bold absolute top-14 -right-2 border-4 border-blue-50">4</div>
                    <h3 class="text-xl font-bold text-dark mb-2">Datang ke Klinik</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Datang ke klinik sesuai jadwal tanpa perlu menunggu lama lagi.</p>
                </div>
            </div>
            
            <div class="mt-16 text-center">
                <a href="{{ route('register') }}" class="inline-block bg-gray-900 hover:bg-primary text-white font-bold px-8 py-4 rounded-xl shadow-lg transition duration-300 transform hover:-translate-y-1">
                    Mulai Reservasi Sekarang <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-20 bg-gray-50 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold text-dark mb-4">Hubungi Kami</h2>
                <p class="text-gray-600">Kami siap melayani Anda di Klinik Bina Usada. Jangan ragu untuk menghubungi kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] text-center border border-gray-100 transform hover:-translate-y-2 transition duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4 class="text-xl font-bold text-dark mb-2">Alamat</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Jl. Gatot Subroto Barat No.101,<br>Ubung, Kec. Denpasar Utara,<br>Bali 80237</p>
                </div>
                
                <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] text-center border border-gray-100 transform hover:-translate-y-2 transition duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h4 class="text-xl font-bold text-dark mb-2">Telepon / WA</h4>
                    <p class="text-sm text-gray-600 leading-relaxed"><a href="https://wa.me/6281337513637" target="_blank" class="hover:text-primary transition">081337513637</a><br>(0361) 410 764</p>
                </div>
                
                <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] text-center border border-gray-100 transform hover:-translate-y-2 transition duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6">
                        <i class="fab fa-instagram"></i>
                    </div>
                    <h4 class="text-xl font-bold text-dark mb-2">Instagram</h4>
                    <p class="text-sm text-gray-600 leading-relaxed"><a href="https://instagram.com/klinik.binausada" target="_blank" class="hover:text-primary transition">@klinik.binausada</a><br>Follow untuk info terbaru</p>
                </div>
                
                <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] text-center border border-gray-100 transform hover:-translate-y-2 transition duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6">
                        <i class="far fa-clock"></i>
                    </div>
                    <h4 class="text-xl font-bold text-dark mb-2">Jam Operasional</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Buka Setiap Hari<br>08:00 - 21:00 WITA</p>
                </div>
            </div>

            <div class="w-full h-[450px] rounded-3xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.12)] border-8 border-white bg-gray-200 relative">
                <iframe 
                    src="https://maps.google.com/maps?q=Klinik%20Bina%20Usada,%20Jl.%20Gatot%20Subroto%20Barat%20No.101,%20Ubung,%20Denpasar&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-white pt-16 pb-8 border-t-4 border-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <i class="fas fa-heartbeat text-3xl text-primary"></i>
                        <span class="font-extrabold text-2xl tracking-tight text-white">Klinik <span class="text-primary">Bina Usada</span></span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Layanan kesehatan profesional dengan dokter berpengalaman dan fasilitas modern untuk kesehatan Anda dan keluarga.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary transition"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/klinik.binausada?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary transition"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6">Navigasi</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-primary transition">Beranda</a></li>
                        <li><a href="#layanan" class="hover:text-primary transition">Layanan</a></li>
                        <li><a href="#tentang" class="hover:text-primary transition">Tentang Kami</a></li>
                        <li><a href="#dokter" class="hover:text-primary transition">Dokter</a></li>
                        <li><a href="#kontak" class="hover:text-primary transition">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6">Akses Cepat</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="{{ route('login') }}" class="hover:text-primary transition">Portal Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-primary transition">Pendaftaran Pasien</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6">Newsletter</h4>
                    <p class="text-sm text-gray-400 mb-4">Dapatkan informasi kesehatan terbaru dari kami.</p>
                    <form class="flex flex-col gap-3">
                        <input type="email" placeholder="Email Anda" class="bg-slate-800 text-white border border-slate-700 focus:border-primary rounded-lg px-4 py-3 text-sm outline-none w-full">
                        <button type="button" class="bg-primary hover:bg-secondary transition rounded-lg px-4 py-3 font-bold text-sm w-full">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 text-center text-sm text-gray-500">
                <p>Made with <i class="fas fa-heart text-red-500"></i> © {{ date('Y') }} Klinik Bina Usada. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>