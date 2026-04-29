<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-edit mr-2 text-amber-500"></i>
            {{ __('Edit Data Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center text-red-700 font-bold mb-1 text-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Update Data Gagal
                    </div>
                    <p class="text-xs text-red-600">
                        Mohon perbaiki data yang masih salah.
                    </p>
                </div>
            @endif

            <div class="bg-white p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">

                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-2xl font-extrabold text-gray-900 uppercase">
                        Perbarui Biodata
                    </h3>
                    <p class="text-gray-500 text-sm mt-1">
                        Ubah data pasien dan akun login di bawah ini.
                    </p>
                </div>

                <form action="{{ route('admin.pasien.update', $pasien->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">
                                Nomor RM
                            </label>

                            <input type="text"
                                   name="no_rm"
                                   value="{{ old('no_rm', $pasien->no_rm) }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">
                                Nama Lengkap
                            </label>

                            <input type="text"
                                   name="nama_lengkap"
                                   value="{{ old('nama_lengkap', $pasien->nama_lengkap) }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">
                                Jenis Kelamin
                            </label>

                            <select name="jenis_kelamin"
                                    required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none">
                                <option value="L" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">
                                Tanggal Lahir
                            </label>

                            <input type="date"
                                   name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">
                                No Telepon
                            </label>

                            <input type="number"
                                   name="no_telepon"
                                   value="{{ old('no_telepon', $pasien->no_telepon) }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">
                                Alamat
                            </label>

                            <textarea name="alamat"
                                      rows="2"
                                      required
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none">{{ old('alamat', $pasien->alamat) }}</textarea>
                        </div>

                        {{-- DATA VITAL --}}
                        <div class="md:col-span-2">
                            <div class="relative flex py-4 items-center">
                                <div class="flex-grow border-t border-gray-100"></div>
                                <span class="mx-4 text-emerald-500 text-xs font-bold uppercase">
                                    Data Vital Pasien
                                </span>
                                <div class="flex-grow border-t border-gray-100"></div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">
                                Berat Badan (Kg)
                            </label>

                            <input type="number"
                                   name="berat_badan"
                                   value="{{ old('berat_badan', $pasien->berat_badan) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">
                                Tinggi Badan (Cm)
                            </label>

                            <input type="number"
                                   name="tinggi_badan"
                                   value="{{ old('tinggi_badan', $pasien->tinggi_badan) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">
                                Tensi Darah
                            </label>

                            <input type="text"
                                   name="tensi_darah"
                                   value="{{ old('tensi_darah', $pasien->tensi_darah) }}"
                                   placeholder="120/80"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 outline-none">
                        </div>
                    </div>

                    <div class="relative flex py-5 items-center mt-4">
                        <div class="flex-grow border-t border-gray-100"></div>
                        <span class="mx-4 text-amber-500 text-xs font-bold uppercase">
                            Akun Portal Pasien
                        </span>
                        <div class="flex-grow border-t border-gray-100"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $pasien->user->email ?? '') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">
                                Password Baru
                            </label>

                            <input type="password"
                                   name="password"
                                   placeholder="Kosongkan jika tidak diubah"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none">
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex gap-3 justify-end">
                        <a href="{{ route('admin.pasien.index') }}"
                           class="bg-white border border-gray-200 text-gray-500 px-8 py-3 rounded-xl hover:bg-gray-50 font-bold text-xs uppercase">
                            Batal
                        </a>

                        <button type="submit"
                                class="bg-amber-500 text-white px-10 py-3 rounded-xl hover:bg-amber-600 font-bold text-xs uppercase">
                            Update Pasien
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>