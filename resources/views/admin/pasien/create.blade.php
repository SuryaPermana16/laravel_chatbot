<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-plus mr-2 text-indigo-600"></i> {{ __('Pendaftaran Pasien Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-2xl font-extrabold text-gray-900">Formulir Pendaftaran</h3>
                    <p class="text-gray-500 text-sm mt-1">Lengkapi biodata pasien beserta akses akun portalnya.</p>
                </div>

                <form action="{{ route('admin.pasien.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap Pasien</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_lengkap" required placeholder="Sesuai KTP" class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-venus-mars text-gray-400"></i>
                                </div>
                                <select name="jenis_kelamin" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white appearance-none">
                                    <option value="L">Laki-laki (L)</option>
                                    <option value="P">Perempuan (P)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Lahir</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="date" name="tanggal_lahir" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">No. HP / WhatsApp</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-phone-alt text-gray-400"></i>
                                </div>
                                <input type="number" name="no_telepon" required placeholder="081234567890" class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                            <div class="relative">
                                <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                                <textarea name="alamat" rows="2" required placeholder="Alamat domisili saat ini..." class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="relative flex py-5 items-center">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="flex-shrink-0 mx-4 text-indigo-600 text-sm font-bold uppercase tracking-wider"><i class="fas fa-sign-in-alt mr-2"></i>Akun Portal Pasien</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email" required placeholder="pasien@email.com" class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" name="password" id="passPasienCreate" required placeholder="Minimal 8 karakter" class="w-full pl-11 pr-12 py-3.5 rounded-xl border border-gray-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                                
                                <button type="button" onclick="togglePassword('passPasienCreate', 'iconPasienCreate')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-indigo-600 transition focus:outline-none">
                                    <i id="iconPasienCreate" class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-center gap-3 justify-end">
                        <a href="{{ route('admin.pasien.index') }}" class="w-full sm:w-auto text-center bg-white border-2 border-slate-200 text-slate-600 px-6 py-3 rounded-xl hover:bg-slate-50 hover:text-slate-800 font-bold transition">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-indigo-600 text-white px-8 py-3 rounded-xl hover:bg-indigo-700 font-bold shadow-lg shadow-indigo-200 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Daftarkan Pasien
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