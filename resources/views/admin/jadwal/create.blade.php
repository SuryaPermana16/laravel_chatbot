<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="far fa-calendar-plus mr-2 text-fuchsia-600"></i> {{ __('Tambah Jadwal Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-2xl font-extrabold text-gray-900">Formulir Jadwal Baru</h3>
                    <p class="text-gray-500 text-sm mt-1">Tentukan dokter, hari, dan jam operasional untuk membuka sesi antrean.</p>
                </div>

                <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Dokter Praktek</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user-md text-gray-400"></i>
                                </div>
                                <select name="dokter_id" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-fuchsia-600 focus:ring-2 focus:ring-fuchsia-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white appearance-none">
                                    <option value="" disabled selected>-- Pilih Dokter --</option>
                                    @foreach($dokters as $dokter)
                                        <option value="{{ $dokter->id }}">{{ $dokter->nama_lengkap }} (Poli {{ $dokter->spesialis }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Hari Praktek</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-calendar-alt text-gray-400"></i>
                                </div>
                                <select name="hari" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-fuchsia-600 focus:ring-2 focus:ring-fuchsia-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white appearance-none">
                                    <option value="" disabled selected>-- Pilih Hari --</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jam Mulai</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="far fa-clock text-gray-400"></i>
                                    </div>
                                    <input type="time" name="jam_mulai" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-fuchsia-600 focus:ring-2 focus:ring-fuchsia-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jam Selesai</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-history text-gray-400"></i>
                                    </div>
                                    <input type="time" name="jam_selesai" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-fuchsia-600 focus:ring-2 focus:ring-fuchsia-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-center gap-3 justify-end">
                        <a href="{{ route('admin.jadwal.index') }}" class="w-full sm:w-auto text-center bg-white border-2 border-slate-200 text-slate-600 px-6 py-3 rounded-xl hover:bg-slate-50 hover:text-slate-800 font-bold transition">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-fuchsia-600 text-white px-8 py-3 rounded-xl hover:bg-fuchsia-700 font-bold shadow-lg shadow-fuchsia-200 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>