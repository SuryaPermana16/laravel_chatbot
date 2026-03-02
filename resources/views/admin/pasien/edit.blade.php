<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-edit mr-2 text-amber-500"></i> {{ __('Edit Data Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center text-red-700 font-bold mb-1 text-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i> Update Data Gagal
                    </div>
                    <p class="text-xs text-red-600">Mohon perbaiki kesalahan pada kolom yang ditandai merah di bawah ini.</p>
                </div>
            @endif

            <div class="bg-white p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-2xl font-extrabold text-gray-900 uppercase">Perbarui Biodata</h3>
                    <p class="text-gray-500 text-sm mt-1">Ubah informasi Nomor RM, demografi, dan akun login pasien di bawah ini.</p>
                </div>

                <form action="{{ route('admin.pasien.update', $pasien->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') 
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Nomor Rekam Medis (RM)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-id-card text-gray-400"></i>
                                </div>
                                <input type="text" name="no_rm" value="{{ old('no_rm', $pasien->no_rm) }}" required placeholder="Contoh: RM-00123" class="w-full pl-11 pr-4 py-3.5 rounded-xl border {{ $errors->has('no_rm') ? 'border-red-500' : 'border-gray-200' }} focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none transition text-gray-900 bg-slate-50 focus:bg-white font-bold uppercase tracking-wider">
                            </div>
                            @error('no_rm') <p class="text-xs text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Nama Lengkap Pasien</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pasien->nama_lengkap) }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border {{ $errors->has('nama_lengkap') ? 'border-red-500' : 'border-gray-200' }} focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none transition text-gray-700 bg-slate-50 focus:bg-white font-medium">
                            </div>
                            @error('nama_lengkap') <p class="text-xs text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Jenis Kelamin</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-venus-mars text-gray-400"></i>
                                </div>
                                <select name="jenis_kelamin" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none transition text-gray-700 bg-slate-50 focus:bg-white appearance-none font-medium">
                                    <option value="L" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                                    <option value="P" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Tanggal Lahir</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border {{ $errors->has('tanggal_lahir') ? 'border-red-500' : 'border-gray-200' }} focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none transition text-gray-700 bg-slate-50 focus:bg-white font-medium">
                            </div>
                            @error('tanggal_lahir') <p class="text-xs text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">No. HP / WhatsApp</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-phone-alt text-gray-400"></i>
                                </div>
                                <input type="number" name="no_telepon" value="{{ old('no_telepon', $pasien->no_telepon) }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border {{ $errors->has('no_telepon') ? 'border-red-500' : 'border-gray-200' }} focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none transition text-gray-700 bg-slate-50 focus:bg-white font-medium">
                            </div>
                            @error('no_telepon') <p class="text-xs text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2 mt-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Alamat Lengkap</label>
                            <div class="relative">
                                <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                                <textarea name="alamat" rows="2" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border {{ $errors->has('alamat') ? 'border-red-500' : 'border-gray-200' }} focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none transition text-gray-700 bg-slate-50 focus:bg-white resize-none font-medium">{{ old('alamat', $pasien->alamat) }}</textarea>
                            </div>
                            @error('alamat') <p class="text-xs text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="relative flex py-5 items-center mt-4">
                        <div class="flex-grow border-t border-gray-100"></div>
                        <span class="flex-shrink-0 mx-4 text-amber-500 text-xs font-black uppercase tracking-[0.2em]"><i class="fas fa-sign-in-alt mr-2"></i>Akun Portal Pasien</span>
                        <div class="flex-grow border-t border-gray-100"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Alamat Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email" value="{{ old('email', $pasien->user->email ?? '') }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none transition text-gray-700 bg-slate-50 focus:bg-white font-medium">
                            </div>
                            @error('email') <p class="text-xs text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Password Baru <span class="text-[10px] font-normal text-gray-400 ml-1">(Opsional)</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400"></i>
                                </div>
                                <input type="password" name="password" id="passPasienEdit" placeholder="Kosongkan jika tak diubah" class="w-full pl-11 pr-12 py-3.5 rounded-xl border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }} focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none transition text-gray-700 bg-slate-50 focus:bg-white font-medium">
                                
                                <button type="button" onclick="togglePassword('passPasienEdit', 'iconPasienEdit')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-amber-500 transition focus:outline-none">
                                    <i id="iconPasienEdit" class="far fa-eye"></i>
                                </button>
                            </div>
                            @error('password') <p class="text-xs text-red-500 mt-1 font-bold italic">* {{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-center gap-3 justify-end">
                        <a href="{{ route('admin.pasien.index') }}" class="w-full sm:w-auto text-center bg-white border border-gray-200 text-gray-500 px-8 py-3.5 rounded-xl hover:bg-gray-50 hover:text-gray-700 font-bold transition uppercase text-xs tracking-widest">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-amber-500 text-white px-10 py-3.5 rounded-xl hover:bg-amber-600 font-bold shadow-xl shadow-amber-100 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 uppercase text-xs tracking-widest">
                            <i class="fas fa-save"></i> Update Pasien
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
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>
</x-app-layout>