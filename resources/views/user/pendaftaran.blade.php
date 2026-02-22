<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-calendar-check mr-2 text-blue-600"></i> {{ __('Buat Janji Temu (Reservasi)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('user.dashboard') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <form action="{{ route('user.daftar.store', $jadwal->id) }}" method="POST">
                @csrf
                <input type="hidden" name="tanggal_kunjungan" value="{{ $tanggalKunjungan }}">

                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div class="w-full lg:w-1/3">
                        <div class="bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 lg:sticky lg:top-24 text-center">
                            
                            <div class="w-32 h-32 bg-blue-50 border-4 border-white shadow-xl rounded-full flex items-center justify-center mx-auto mb-5 text-blue-600 text-5xl relative">
                                <i class="fas fa-user-md"></i>
                                <div class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></div>
                            </div>
                            
                            <h3 class="text-2xl font-extrabold text-gray-900 leading-tight">{{ $jadwal->dokter->nama_lengkap }}</h3>
                            <div class="inline-block bg-blue-50 text-blue-600 text-[10px] font-extrabold px-3 py-1 rounded-md mt-2 uppercase tracking-wider">
                                Poli {{ $jadwal->dokter->spesialis }}
                            </div>

                            <hr class="my-6 border-gray-100">

                            <div class="text-left space-y-4">
                                <div>
                                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Hari & Jam Praktek</span>
                                    <div class="font-bold text-gray-800 flex items-center gap-2">
                                        <i class="far fa-calendar text-blue-500 w-4"></i> {{ $jadwal->hari }}
                                    </div>
                                    <div class="font-bold text-gray-800 flex items-center gap-2 mt-1">
                                        <i class="far fa-clock text-blue-500 w-4"></i> {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }} WIB
                                    </div>
                                </div>
                                
                                <div class="bg-blue-600 p-4 rounded-xl text-white mt-4 shadow-md shadow-blue-200">
                                    <span class="block text-[10px] text-blue-200 font-bold uppercase tracking-wider mb-1">Tanggal Rencana Kunjungan</span>
                                    <span class="block font-black text-lg">
                                        {{ \Carbon\Carbon::parse($tanggalKunjungan)->translatedFormat('l, d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-2/3 space-y-6">
                        
                        <div class="bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                            <h3 class="font-extrabold text-xl text-gray-900 mb-6 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-900 text-white flex items-center justify-center text-sm">1</div>
                                Pilih Estimasi Kedatangan
                            </h3>
                            
                            @if(count($slots) > 0)
                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                                    @foreach($slots as $slot)
                                        @if($slot['available'])
                                            <label class="cursor-pointer relative group">
                                                <input type="radio" name="jam_pilihan" value="{{ $slot['jam'] }}" class="peer hidden" required>
                                                <div class="py-3 px-2 text-center border-2 border-gray-100 rounded-xl bg-white text-gray-600 font-bold text-sm transition-all duration-200
                                                            group-hover:border-blue-300 group-hover:bg-blue-50
                                                            peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-blue-200 transform peer-checked:-translate-y-1">
                                                    {{ $slot['jam'] }}
                                                </div>
                                                <div class="absolute -top-2 -right-2 w-5 h-5 bg-white border-2 border-blue-600 text-blue-600 rounded-full flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity z-10">
                                                    <i class="fas fa-check text-[10px]"></i>
                                                </div>
                                            </label>
                                        @else
                                            <div class="py-3 px-2 text-center border-2 border-transparent rounded-xl bg-slate-100 text-gray-400 font-medium text-sm cursor-not-allowed relative overflow-hidden flex flex-col items-center justify-center">
                                                <span class="{{ $slot['status'] == 'Penuh' ? 'line-through opacity-50' : '' }}">{{ $slot['jam'] }}</span>
                                                @if($slot['status'] == 'Penuh')
                                                    <span class="text-[9px] font-black text-red-500 uppercase mt-0.5">Penuh</span>
                                                @else
                                                    <span class="text-[9px] font-black text-gray-400 uppercase mt-0.5">Lewat</span>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                
                                <div class="flex flex-wrap gap-4 mt-6 justify-start text-xs font-bold text-gray-500">
                                    <div class="flex items-center"><div class="w-3 h-3 bg-white border-2 border-gray-200 rounded-sm mr-2"></div> Tersedia</div>
                                    <div class="flex items-center"><div class="w-3 h-3 bg-blue-600 rounded-sm mr-2 shadow-sm"></div> Dipilih</div>
                                    <div class="flex items-center"><div class="w-3 h-3 bg-slate-200 rounded-sm mr-2"></div> Penuh/Lewat</div>
                                </div>
                            @else
                                <div class="text-center py-12 bg-slate-50 border-2 border-dashed border-gray-200 rounded-2xl">
                                    <i class="fas fa-calendar-times text-gray-300 text-5xl mb-3"></i>
                                    <p class="text-gray-500 font-medium">Tidak ada slot jam tersedia untuk hari ini.</p>
                                </div>
                            @endif

                            @error('jam_pilihan')
                                <p class="text-red-500 text-sm mt-3 font-bold bg-red-50 p-3 rounded-lg flex items-center"><i class="fas fa-exclamation-circle mr-2"></i> Silakan klik salah satu jam di atas.</p>
                            @enderror
                        </div>

                        <div class="bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                            <h3 class="font-extrabold text-xl text-gray-900 mb-6 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-900 text-white flex items-center justify-center text-sm">2</div>
                                Jelaskan Keluhan Anda
                            </h3>
                            <textarea name="keluhan" rows="4" 
                                class="w-full border-gray-200 bg-slate-50 focus:bg-white rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 p-5 text-gray-800 placeholder-gray-400 outline-none transition resize-none" 
                                placeholder="Tuliskan gejala yang dirasakan. Contoh: Demam naik turun sejak 2 hari lalu, disertai batuk kering..." required></textarea>
                            <p class="text-xs text-gray-400 font-medium mt-2"><i class="fas fa-info-circle mr-1"></i> Informasi ini akan dibaca oleh dokter sebelum pemeriksaan.</p>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-2">
                            <a href="{{ route('user.dashboard') }}" class="text-gray-500 font-bold hover:text-gray-800 transition px-4 py-2">Batal</a>
                            
                            @if(count($slots) > 0)
                            <button type="submit" class="bg-gray-900 hover:bg-black text-white font-extrabold text-sm uppercase tracking-wide py-4 px-8 rounded-xl shadow-xl transition transform hover:-translate-y-1 flex items-center gap-2">
                                Konfirmasi & Buat Janji <i class="fas fa-paper-plane"></i>
                            </button>
                            @endif
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>