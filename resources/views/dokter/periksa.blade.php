<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-stethoscope mr-2 text-blue-600"></i> {{ __('Pemeriksaan Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="mb-2">
                <a href="{{ route('dokter.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 font-bold transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Antrean
                </a>
            </div>

            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-blue-600"></div>
                
                <div class="p-8 sm:p-10">
                    <div class="flex flex-col md:flex-row gap-6 md:items-center justify-between border-b border-gray-100 pb-6 mb-6">
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-2xl {{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }} flex items-center justify-center text-2xl font-extrabold shadow-inner">
                                {{ strtoupper(substr($kunjungan->pasien->nama_lengkap, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-2xl font-extrabold text-gray-900 mb-1">{{ $kunjungan->pasien->nama_lengkap }}</h3>
                                <div class="flex items-center gap-2 text-sm font-bold text-gray-500">
                                    <span class="{{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'text-blue-600' : 'text-pink-600' }}">
                                        {{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span>{{ \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->age }} Thn</span>
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span>RM: {{ $kunjungan->pasien->no_rm ?? 'Belum ada' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-left md:text-right mt-4 md:mt-0">
                            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nomor Antrean</div>
                            <div class="inline-flex items-center gap-3 bg-slate-50 border border-slate-200 px-3 py-2 rounded-xl shadow-sm">
                                <span class="px-3 py-1 rounded-lg bg-gray-900 text-white font-black text-lg shadow-sm tracking-wider">
                                    {{ $kunjungan->no_antrian }}
                                </span>
                                <span class="font-bold text-gray-600 text-base pr-2 border-l border-slate-300 pl-3">
                                    <i class="far fa-clock text-gray-400 mr-1"></i> {{ date('H:i', strtotime($kunjungan->jam_pilihan)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-amber-50/50 border border-amber-100 rounded-xl p-5 relative">
                        <div class="absolute -top-3 left-4 bg-amber-100 text-amber-600 text-[10px] font-extrabold px-2 py-0.5 rounded uppercase tracking-wider border border-amber-200">
                            Keluhan Awal Pasien
                        </div>
                        <p class="text-gray-700 italic font-medium mt-1">"{{ $kunjungan->keluhan }}"</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 sm:p-10">
                <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg">
                        <i class="fas fa-file-medical-alt"></i>
                    </div>
                    <h3 class="font-extrabold text-xl text-gray-900">Catatan Pemeriksaan Dokter</h3>
                </div>

                <form action="{{ route('dokter.periksa.simpan', $kunjungan->id) }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div>
                        <label for="diagnosa" class="flex items-center text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-microscope text-blue-500 mr-2"></i> Hasil Diagnosa Akhir <span class="text-red-500 ml-1">*</span>
                        </label>
                        <textarea id="diagnosa" name="diagnosa" rows="4" required 
                            class="w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 rounded-xl shadow-sm p-4 transition outline-none text-gray-800 resize-none" 
                            placeholder="Tuliskan hasil anamnesa, pemeriksaan fisik, dan diagnosa penyakit..."></textarea>
                    </div>

                    <div>
                        <label for="resep_obat" class="flex items-center text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-pills text-emerald-500 mr-2"></i> Resep Obat (Opsional)
                        </label>
                        <textarea id="resep_obat" name="resep_obat" rows="3" 
                            class="w-full border-gray-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl shadow-sm p-4 transition outline-none text-gray-800 resize-none" 
                            placeholder="Catat resep obat dan aturan minumnya untuk panduan apoteker..."></textarea>
                        <p class="text-xs text-gray-400 mt-2"><i class="fas fa-info-circle mr-1"></i> Resep ini akan dibaca oleh Apoteker untuk menyiapkan obat fisik. Kosongkan jika tidak ada resep.</p>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-blue-200 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Simpan Rekam Medis & Selesaikan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>