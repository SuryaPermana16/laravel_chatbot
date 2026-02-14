<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendaftaran Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('user.daftar.store', $jadwal->id) }}" method="POST">
                @csrf
                <input type="hidden" name="tanggal_kunjungan" value="{{ $tanggalKunjungan }}">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-6 text-center">
                            
                            <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 text-4xl">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $jadwal->dokter->nama_lengkap }}</h3>
                            <div class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full mt-2 uppercase tracking-wide">
                                Spesialis {{ $jadwal->dokter->spesialis }}
                            </div>

                            <hr class="my-6 border-gray-100">

                            <div class="text-left space-y-4 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Hari Praktek</span>
                                    <span class="font-bold text-gray-800">{{ $jadwal->hari }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Jam</span>
                                    <span class="font-bold text-gray-800">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</span>
                                </div>
                                <div class="bg-green-50 p-3 rounded-lg border border-green-100 mt-4">
                                    <span class="block text-xs text-green-600 mb-1 font-bold uppercase">Tanggal Kunjungan</span>
                                    <span class="block text-green-800 font-bold text-base">
                                        {{ \Carbon\Carbon::parse($tanggalKunjungan)->translatedFormat('l, d F Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">1</span>
                                Pilih Jam Konsultasi
                            </h3>
                            
                            @if(count($slots) > 0)
                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                                    @foreach($slots as $slot)
                                        @if($slot['available'])
                                            <label class="cursor-pointer relative group">
                                                <input type="radio" name="jam_pilihan" value="{{ $slot['jam'] }}" class="peer hidden" required>
                                                
                                                <div class="py-2.5 px-2 text-center border-2 border-gray-100 rounded-xl bg-white text-gray-600 font-bold text-sm transition-all duration-200
                                                            group-hover:border-blue-400 group-hover:bg-blue-50
                                                            peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow-md">
                                                    {{ $slot['jam'] }}
                                                </div>
                                            </label>
                                        @else
                                            <div class="py-2.5 px-2 text-center border border-gray-100 rounded-xl bg-gray-50 text-gray-300 font-medium text-sm cursor-not-allowed relative overflow-hidden">
                                                {{ $slot['jam'] }}
                                                
                                                @if($slot['status'] == 'Penuh')
                                                    <div class="absolute inset-0 flex items-center justify-center bg-red-500/90 text-white text-[10px] font-bold uppercase tracking-wider">
                                                        Penuh
                                                    </div>
                                                @else
                                                    <div class="absolute inset-0 flex items-center justify-center bg-gray-200/80 text-gray-500 text-[10px] font-bold uppercase">
                                                        Lewat
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                
                                <div class="flex gap-4 mt-4 justify-end text-xs text-gray-500">
                                    <div class="flex items-center"><span class="w-3 h-3 bg-white border border-gray-300 rounded mr-1"></span> Tersedia</div>
                                    <div class="flex items-center"><span class="w-3 h-3 bg-blue-600 rounded mr-1"></span> Dipilih</div>
                                    <div class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded mr-1"></span> Penuh</div>
                                </div>
                            @else
                                <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-xl">
                                    <i class="fas fa-calendar-times text-gray-300 text-4xl mb-3"></i>
                                    <p class="text-gray-500">Tidak ada jadwal tersedia hari ini.</p>
                                </div>
                            @endif

                            @error('jam_pilihan')
                                <p class="text-red-500 text-sm mt-3 font-medium animate-pulse">* Silakan pilih jam terlebih dahulu.</p>
                            @enderror
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">2</span>
                                Keluhan Utama
                            </h3>
                            <textarea name="keluhan" rows="3" class="w-full border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 p-4 text-gray-700 placeholder-gray-400 bg-gray-50" placeholder="Contoh: Demam naik turun sejak 2 hari lalu..." required></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4">
                            <a href="{{ route('user.dashboard') }}" class="text-gray-500 font-bold hover:text-gray-800 transition">Batal</a>
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-10 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                                Booking Sekarang <i class="fas fa-check ml-2"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>