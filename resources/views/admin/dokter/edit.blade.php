<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-edit mr-2 text-amber-500"></i> {{ __('Edit Data Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
                    <p class="text-sm text-red-700 font-bold mb-1"><i class="fas fa-exclamation-circle mr-2"></i>Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-2xl font-extrabold text-gray-900">Perbarui Data Dokter</h3>
                    <p class="text-gray-500 text-sm mt-1">Ubah informasi spesialis, tarif, dan kredensial login dokter di bawah ini.</p>
                </div>

                <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') 
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap & Gelar</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_lengkap" value="{{ $dokter->nama_lengkap }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Spesialis / Poli</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-stethoscope text-gray-400"></i>
                                </div>
                                <input type="text" name="spesialis" value="{{ $dokter->spesialis }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-phone-alt text-gray-400"></i>
                                </div>
                                <input type="text" name="no_telepon" value="{{ $dokter->no_telepon }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tarif Jasa Konsultasi (Rp)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 font-bold">
                                    Rp
                                </div>
                                <input type="number" name="harga_jasa" value="{{ old('harga_jasa', $dokter->harga_jasa) }}" required class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>
                    </div>

                    <div class="relative flex py-5 items-center">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="flex-shrink-0 mx-4 text-gray-400 text-sm font-bold uppercase tracking-wider"><i class="fas fa-sign-in-alt mr-2"></i>Informasi Akun Login</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Login</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email" value="{{ $dokter->user->email ?? '' }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru <span class="text-xs font-normal text-gray-400 ml-1">(Opsional)</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400"></i>
                                </div>
                                <input type="password" name="password" id="passDokterEdit" placeholder="Kosongkan jika tidak diubah" class="w-full pl-11 pr-12 py-3.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                                
                                <button type="button" onclick="togglePassword('passDokterEdit', 'iconDokterEdit')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-amber-500 transition focus:outline-none">
                                    <i id="iconDokterEdit" class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-center gap-3 justify-end">
                        <a href="{{ route('admin.dokter.index') }}" class="w-full sm:w-auto text-center bg-white border-2 border-slate-200 text-slate-600 px-6 py-3 rounded-xl hover:bg-slate-50 hover:text-slate-800 font-bold transition">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-amber-500 text-white px-8 py-3 rounded-xl hover:bg-amber-600 font-bold shadow-lg shadow-amber-200 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i> Update Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</x-app-layout>