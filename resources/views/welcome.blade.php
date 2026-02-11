<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Bina Usada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">
    <div class="min-h-screen flex flex-col items-center justify-center p-6 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-blue-100 via-slate-50 to-white">
        
        <div class="max-w-md w-full text-center">
            <div class="bg-blue-600 w-24 h-24 rounded-[2rem] flex items-center justify-center text-white shadow-2xl mb-8 mx-auto rotate-3 hover:rotate-0 transition-transform duration-500 shadow-blue-200">
                <i class="fas fa-hospital text-5xl"></i>
            </div>

            <h1 class="text-4xl font-black text-slate-800 mb-3 tracking-tighter uppercase">
                Klinik <span class="text-blue-600">Bina Usada</span>
            </h1>
            <p class="text-slate-500 mb-12 italic text-sm">
                "Melayani dengan Hati, Sehat Bersama Kami."
            </p>

            <div class="space-y-4">
                @if (Route::has('login'))
                    @auth
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-4">
                            <p class="text-sm text-slate-400 mb-4 uppercase font-bold tracking-widest">Sesi Aktif: {{ Auth::user()->name }}</p>
                            
                            <div class="flex flex-col gap-3">
                                <a href="{{ url('/dashboard') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-10 rounded-2xl shadow-lg transition-all transform active:scale-95 flex items-center justify-center">
                                    <i class="fas fa-th-large mr-2"></i> Ke Dashboard Saya
                                </a>

                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full bg-red-50 text-red-600 border border-red-100 font-bold py-3 px-10 rounded-2xl hover:bg-red-100 transition-all text-sm flex items-center justify-center">
                                        <i class="fas fa-power-off mr-2"></i> Keluar & Ganti Akun
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col gap-4">
                            <a href="{{ route('login') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-12 rounded-2xl shadow-xl transition-all transform active:scale-95 text-xl flex items-center justify-center">
                                <i class="fas fa-sign-in-alt mr-3"></i> Login Sistem
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="w-full bg-white border-2 border-slate-200 text-slate-600 hover:bg-slate-50 font-bold py-4 px-12 rounded-2xl transition-all transform active:scale-95 text-lg flex items-center justify-center">
                                    <i class="fas fa-user-plus mr-3"></i> Daftar Akun Pasien
                                </a>
                            @endif
                        </div>
                    @endauth
                @endif
            </div>

            <div class="mt-20 border-t border-slate-200 pt-8">
                <div class="flex justify-center gap-6 text-slate-400 mb-6">
                    <i class="fab fa-whatsapp text-xl hover:text-green-500 cursor-pointer"></i>
                    <i class="fab fa-instagram text-xl hover:text-pink-500 cursor-pointer"></i>
                    <i class="fas fa-map-marker-alt text-xl hover:text-blue-500 cursor-pointer"></i>
                </div>
                <p class="text-[11px] text-slate-400 uppercase font-black tracking-[0.2em]">
                    &copy; 2026 Klinik Bina Usada - Information System
                </p>
            </div>
        </div>
    </div>
</body>
</html>