<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6 px-2">
                <h3 class="font-bold text-2xl text-gray-800 flex items-center">
                    <i class="fas fa-stethoscope mr-3 text-blue-600"></i> Pemeriksaan Pasien
                </h3>
                <a href="{{ route('dokter.dashboard') }}" class="bg-white border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-bold py-2 px-5 rounded-xl shadow-sm transition inline-flex items-center text-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 mb-6 relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6 pb-4 border-b border-gray-100">
                        Data Pasien
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Nama Lengkap</div>
                            <div class="text-xl font-extrabold text-gray-800">{{ $kunjungan->pasien->nama_lengkap }}</div>
                        </div>
                        
                        <div>
                            <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">No. Rekam Medis</div>
                            <div>
                                @if($kunjungan->pasien->no_rekam_medis)
                                    <span class="inline-block bg-blue-50 text-blue-600 text-sm font-bold px-3 py-1 rounded-lg border border-blue-100">
                                        {{ $kunjungan->pasien->no_rekam_medis }}
                                    </span>
                                @else
                                    <span class="inline-block bg-gray-100 text-gray-500 text-sm font-bold px-3 py-1 rounded-lg">
                                        Belum Ada
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Jam Antrean</div>
                            <div class="text-xl font-extrabold text-gray-800">
                                {{ date('H:i', strtotime($kunjungan->jam_pilihan)) }}
                            </div>
                        </div>

                        <div class="md:col-span-3">
                            <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Keluhan Awal</div>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 text-gray-700 font-medium italic">
                                "{{ $kunjungan->keluhan }}"
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6 pb-4 border-b border-gray-100">
                    Input Rekam Medis
                </h4>

                <form action="{{ route('dokter.periksa.simpan', $kunjungan->id) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label for="diagnosa" class="block text-sm font-bold text-gray-700 mb-2">
                                Diagnosa Dokter <span class="text-red-500">*</span>
                            </label>
                            <textarea id="diagnosa" name="diagnosa" rows="4" required 
                                class="w-full border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm p-4 transition text-gray-800" 
                                placeholder="Masukkan hasil pemeriksaan dan diagnosa pasien di sini..."></textarea>
                        </div>

                        <div>
                            <label for="resep_obat" class="block text-sm font-bold text-gray-700 mb-2">
                                Resep Obat <span class="text-red-500">*</span>
                            </label>
                            <textarea id="resep_obat" name="resep_obat" rows="4" required 
                                class="w-full border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm p-4 transition text-gray-800" 
                                placeholder="Tuliskan daftar obat dan aturan pakainya di sini..."></textarea>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 text-right">
                        <button type="submit" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>