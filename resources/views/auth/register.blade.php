<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pasien - Klinik Bina Usada</title>
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

    <div class="w-full max-w-5xl bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.08)] flex overflow-hidden flex-row-reverse">
        
        <div class="w-full md:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
            
            <a href="{{ url('/') }}" class="flex items-center gap-2 mb-8 hover:opacity-80 transition inline-block w-max">
                <i class="fas fa-heartbeat text-3xl text-primary"></i>
                <span class="font-extrabold text-2xl tracking-tight text-dark">Klinik<span class="text-primary">Bina Usada</span></span>
            </a>

            <h2 class="text-3xl font-extrabold text-dark mb-2">Buat Akun Pasien</h2>
            <p class="text-gray-500 mb-8">Daftar sekarang untuk kemudahan akses layanan kesehatan kami.</p>

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

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="far fa-user text-gray-400"></i>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="far fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="email@contoh.com" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="w-full pl-11 pr-12 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                        
                        <button type="button" onclick="togglePassword('password', 'eye-reg1')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary focus:outline-none transition">
                            <i id="eye-reg1" class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Ulangi Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-check-double text-gray-400"></i>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi sandi di atas" class="w-full pl-11 pr-12 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                        
                        <button type="button" onclick="togglePassword('password_confirmation', 'eye-reg2')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary focus:outline-none transition">
                            <i id="eye-reg2" class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full mt-2 bg-primary hover:bg-secondary text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-blue-200 transition duration-300 transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                    Daftar Sekarang <i class="fas fa-user-check"></i>
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-primary hover:text-secondary transition">Masuk di sini</a>
            </p>
        </div>

        <div class="hidden md:block w-1/2 relative bg-dark">
            <img src="https://images.unsplash.com/photo-1584432810601-6c7f27d2362b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Klinik Register" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-70">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent flex flex-col justify-end p-12 text-white">
                <h3 class="text-3xl font-extrabold mb-4 leading-tight">Mulai Perjalanan<br>Kesehatan Anda</h3>
                <p class="text-gray-300 text-sm leading-relaxed border-l-4 border-primary pl-4">Kami menjaga privasi dan keamanan data medis Anda dengan standar enkripsi tertinggi. Kesehatan Anda adalah tanggung jawab kami.</p>
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
                icon.classList.add('fa-eye-slash'); // Ganti ikon jadi mata dicoret
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye'); // Kembalikan ikon mata normal
            }
        }
    </script>
</body>
</html>