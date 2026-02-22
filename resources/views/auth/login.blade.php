<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Klinik Bina Usada</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
<body class="font-sans antialiased bg-gray-50 flex items-center justify-center min-h-screen p-4 sm:p-6">

    <div class="w-full max-w-5xl bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.08)] flex overflow-hidden">
        
        <div class="w-full md:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
            
            <a href="{{ url('/') }}" class="flex items-center gap-2 mb-10 hover:opacity-80 transition inline-block w-max">
                <i class="fas fa-heartbeat text-3xl text-primary"></i>
                <span class="font-extrabold text-2xl tracking-tight text-dark">Klinik<span class="text-primary">Bina Usada</span></span>
            </a>

            <h2 class="text-3xl font-extrabold text-dark mb-2">Selamat Datang 👋</h2>
            <p class="text-gray-500 mb-8">Silakan masuk menggunakan akun yang telah terdaftar.</p>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <p class="text-sm text-red-700 font-bold mb-1"><i class="fas fa-exclamation-circle mr-2"></i>Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="far fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@klinikbinausada.com" class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-bold text-gray-700">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-bold text-primary hover:text-secondary transition">Lupa Sandi?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full pl-11 pr-12 py-3.5 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                        
                        <button type="button" onclick="togglePassword('password', 'eye-login')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary focus:outline-none transition">
                            <i id="eye-login" class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-5 h-5 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2 cursor-pointer">
                    <label for="remember_me" class="ml-3 text-sm font-medium text-gray-600 cursor-pointer">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-blue-200 transition duration-300 transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                    Masuk ke Sistem <i class="fas fa-sign-in-alt"></i>
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-primary hover:text-secondary transition">Daftar Pasien Baru</a>
            </p>
        </div>

        <div class="hidden md:block w-1/2 relative bg-primary">
            <img src="https://images.unsplash.com/photo-1551076805-e1869033e561?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Klinik Login" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-80">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent flex flex-col justify-end p-12 text-white">
                <div class="bg-white/20 backdrop-blur-md p-6 rounded-2xl border border-white/30">
                    <h3 class="text-xl font-bold mb-2">Layanan Terpadu</h3>
                    <p class="text-blue-50 text-sm leading-relaxed">Akses rekam medis, buat janji temu dokter, dan kelola profil kesehatan Anda dengan mudah melalui portal digital kami.</p>
                </div>
            </div>
        </div>

    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>