<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik Bina Usada</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

    <div class="bg-primary text-white text-xs md:text-sm py-2 px-4 hidden md:block">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex space-x-6">
                <span><i class="fas fa-phone-alt mr-2"></i>+62 812 3456 7890</span>
                <span><i class="fas fa-envelope mr-2"></i>info@klinik.com</span>
            </div>
            <div>
                <span><i class="far fa-clock mr-2"></i>Setiap Hari: 08:00 - 20:30</span>
            </div>
        </div>
    </div>

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
                            <a href="#portal-akses" class="bg-primary text-white px-6 py-2.5 rounded-full hover:bg-secondary transition shadow-lg shadow-blue-200">
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
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Klinik Interior" class="rounded-3xl shadow-2xl object-cover h-[500px] w-full">
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
                        $ikon = 'fas fa-notes-medical'; // Ikon Default (Jika tidak ada yang cocok)

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
                    <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Dokter Konsultasi" class="rounded-3xl shadow-xl w-full object-cover h-[450px]">
                    <div class="absolute -top-6 -right-6 bg-primary text-white p-6 rounded-2xl shadow-lg text-center">
                        <i class="fas fa-award text-3xl mb-2"></i>
                        <p class="font-bold">ISO<br><span class="text-xs font-normal">Certified</span></p>
                    </div>
                </div>
                <div>
                    <h2 class="text-3xl font-extrabold text-dark mb-6">Tentang <span class="text-primary">Klinik Bina Usada</span></h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Klinik Bina Usada adalah klinik kesehatan terpercaya yang telah melayani masyarakat selama lebih dari 15 tahun. Kami berkomitmen untuk memberikan pelayanan kesehatan berkualitas tinggi dengan mengutamakan kenyamanan dan kepuasan pasien.
                    </p>
                    <div class="grid grid-cols-2 gap-6 mt-8">
                        <div class="border border-gray-200 rounded-xl p-5 text-center">
                            <i class="fas fa-users text-3xl text-primary mb-3"></i>
                            <h4 class="text-2xl font-bold text-dark">50,000+</h4>
                            <p class="text-sm text-gray-500 font-medium">Pasien Dilayani</p>
                        </div>
                        <div class="border border-gray-200 rounded-xl p-5 text-center">
                            <i class="fas fa-user-md text-3xl text-primary mb-3"></i>
                            <h4 class="text-2xl font-bold text-dark">20+</h4>
                            <p class="text-sm text-gray-500 font-medium">Dokter Ahli</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="dokter" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold text-dark mb-4">Tim Dokter Kami</h2>
                <p class="text-gray-600">Dokter spesialis berpengalaman dan bersertifikasi siap memberikan perawatan terbaik untuk Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Kita siapkan array gambar statisnya dulu --}}
                @php
                    $doctorImages = [
                        'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1537368910025-700350fe46c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1622253692010-333f2da6031d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
                    ];
                @endphp

                @forelse($dokters as $d)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow border border-gray-100 group">
                    <div class="relative overflow-hidden">
                        <img src="{{ $doctorImages[$loop->index % 4] }}" alt="{{ $d->nama_lengkap }}" class="w-full h-72 object-cover object-top filter grayscale group-hover:grayscale-0 transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-dark/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    </div>
                    
                    <div class="p-6 relative bg-white">
                        <h3 class="font-bold text-xl text-dark mb-1">{{ $d->nama_lengkap }}</h3>
                        <p class="text-primary font-bold text-sm mb-4 uppercase tracking-wider">{{ $d->spesialis }}</p>
                        
                        <div class="text-sm text-gray-600 space-y-3 border-t border-gray-100 pt-4 mt-2">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center mr-3">
                                    <i class="fas fa-money-bill-wave text-green-500"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Tarif Jasa</p>
                                    <p class="font-bold text-dark">Rp {{ number_format($d->harga_jasa, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center mr-3">
                                    <i class="fas fa-phone-alt text-blue-500"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Kontak</p>
                                    <p class="font-medium">{{ $d->no_telepon ?? '-' }}</p>
                                </div>
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
            
            @if($dokters->count() >= 4)
            <div class="text-center mt-14">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 border-2 border-primary text-primary px-8 py-3 rounded-full font-bold hover:bg-primary hover:text-white transition duration-300">
                    <span>Lihat Semua Dokter</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    <section id="portal-akses" class="py-20 bg-white border-y border-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-dark mb-4">Bergabung Bersama Kami</h2>
                <p class="text-gray-600 text-lg">Pilih portal akses sesuai dengan kebutuhan Anda untuk memulai.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-3xl p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100 transform hover:-translate-y-2 transition duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-3xl mb-6">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4">Pasien Baru</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Belum punya akun? Daftar sekarang untuk membuat janji temu, melihat riwayat medis, dan mengelola profil kesehatan Anda.
                    </p>
                    <a href="{{ route('register') }}" class="block w-full bg-primary hover:bg-secondary text-white text-center font-bold py-4 px-6 rounded-xl shadow-lg shadow-blue-200 transition">
                        Buat Akun Sekarang
                    </a>
                </div>

                <div class="bg-white rounded-3xl p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100 transform hover:-translate-y-2 transition duration-300">
                    <div class="w-16 h-16 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4">Sudah Punya Akun?</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Portal login untuk semua pengguna terdaftar. Baik Anda sebagai <strong>Pasien, Dokter, ataupun Admin Klinik</strong>.
                    </p>
                    <a href="{{ route('login') }}" class="block w-full bg-slate-800 hover:bg-dark text-white text-center font-bold py-4 px-6 rounded-xl shadow-lg transition">
                        Masuk ke Dashboard
                    </a>
                </div>
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
                    <h4 class="text-xl font-bold text-dark mb-2">Telepon</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">+62 361 410764<br>Hubungi untuk darurat</p>
                </div>
                
                <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] text-center border border-gray-100 transform hover:-translate-y-2 transition duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6">
                        <i class="far fa-envelope"></i>
                    </div>
                    <h4 class="text-xl font-bold text-dark mb-2">Email</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">info@klinikbinausada.com<br>admin@klinikbinausada.com</p>
                </div>
                
                <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] text-center border border-gray-100 transform hover:-translate-y-2 transition duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6">
                        <i class="far fa-clock"></i>
                    </div>
                    <h4 class="text-xl font-bold text-dark mb-2">Jam Operasional</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Buka Setiap Hari<br>08:00 - 20:30 WITA</p>
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