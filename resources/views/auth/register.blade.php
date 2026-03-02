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

    <div class="w-full max-w-6xl bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.1)] flex overflow-hidden flex-row-reverse min-h-[85vh]">
        
        <div class="w-full lg:w-3/5 p-8 sm:p-12 flex flex-col justify-center bg-white">
            
            <div class="mb-8">
                <a href="{{ url('/') }}" class="flex items-center gap-2 mb-6 hover:opacity-80 transition inline-block text-dark">
                    <i class="fas fa-heartbeat text-3xl text-primary"></i>
                    <span class="font-extrabold text-2xl tracking-tight uppercase">Klinik<span class="text-primary">Bina Usada</span></span>
                </a>
                <h2 class="text-3xl font-extrabold text-dark">Buat Akun Pasien</h2>
                <p class="text-gray-500 mt-2">Lengkapi data diri Anda untuk pendaftaran pasien baru.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center text-red-700 font-bold mb-1 text-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i> Pendaftaran Gagal
                    </div>
                    <p class="text-xs text-red-600">Mohon perbaiki kesalahan yang ditandai merah di bawah ini.</p>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Lengkap Sesuai KTP</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="far fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: John Doe" class="w-full pl-11 pr-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-200' }} focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                        </div>
                        @error('name') <p class="text-[10px] text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-venus-mars text-gray-400"></i>
                            </div>
                            <select name="jenis_kelamin" required class="w-full pl-11 pr-10 py-3 rounded-xl border {{ $errors->has('jenis_kelamin') ? 'border-red-500' : 'border-gray-200' }} focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition text-gray-700 bg-gray-50 focus:bg-white appearance-none">
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tanggal Lahir</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="far fa-calendar-alt text-gray-400"></i>
                            </div>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full pl-11 pr-4 py-3 rounded-xl border {{ $errors->has('tanggal_lahir') ? 'border-red-500' : 'border-gray-200' }} focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                        </div>
                        @error('tanggal_lahir') <p class="text-[10px] text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">No. HP / WhatsApp Aktif</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fab fa-whatsapp text-gray-400"></i>
                            </div>
                            <input type="number" name="no_telepon" value="{{ old('no_telepon') }}" required placeholder="081234567890" class="w-full pl-11 pr-4 py-3 rounded-xl border {{ $errors->has('no_telepon') ? 'border-red-500' : 'border-gray-200' }} focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                        </div>
                        @error('no_telepon') <p class="text-[10px] text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Alamat Lengkap Saat Ini</label>
                        <div class="relative">
                            <div class="absolute top-3 left-0 pl-4 flex items-start pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <textarea name="alamat" rows="2" required placeholder="Jl. Raya No. 123..." class="w-full pl-11 pr-4 py-3 rounded-xl border {{ $errors->has('alamat') ? 'border-red-500' : 'border-gray-200' }} focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition text-gray-700 bg-gray-50 focus:bg-white resize-none">{{ old('alamat') }}</textarea>
                        </div>
                        @error('alamat') <p class="text-[10px] text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2"><div class="h-px bg-gray-100 my-1"></div></div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Alamat Email (Akun Login)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="far fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com" class="w-full pl-11 pr-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                        </div>
                        @error('email') <p class="text-[10px] text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" type="password" name="password" required placeholder="Min. 8 Karakter" class="w-full pl-11 pr-12 py-3 rounded-xl border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                            <button type="button" onclick="togglePassword('password', 'eye1')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary focus:outline-none transition">
                                <i id="eye1" class="far fa-eye"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-[10px] text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ulangi Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-check-double text-gray-400"></i>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ketik ulang" class="w-full pl-11 pr-12 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-gray-700 bg-gray-50 focus:bg-white">
                            <button type="button" onclick="togglePassword('password_confirmation', 'eye2')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary focus:outline-none transition">
                                <i id="eye2" class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 bg-primary hover:bg-secondary text-white font-bold py-4 px-8 rounded-2xl shadow-xl shadow-blue-200 transition duration-300 transform hover:-translate-y-1 flex justify-center items-center gap-2 text-lg">
                    Daftar Sekarang <i class="fas fa-user-plus text-sm"></i>
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-extrabold text-primary hover:underline transition">Masuk di sini</a>
            </p>
        </div>

        <div class="hidden lg:block lg:w-2/5 relative bg-dark">
            <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Klinik Image" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-50">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-dark/90 flex flex-col justify-end p-16 text-white">
                <div class="bg-primary w-16 h-1 mb-6"></div>
                <h3 class="text-4xl font-black mb-4 leading-tight uppercase">Privasi & Keamanan<br>Data Medis.</h3>
                <p class="text-gray-300 text-lg leading-relaxed">Kami menggunakan enkripsi tingkat lanjut untuk melindungi rekam medis Anda. Kesehatan Anda prioritas kami.</p>
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