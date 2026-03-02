<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-notes-medical mr-2 text-indigo-600"></i> {{ __('Detail Rekam Medis') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="mb-2">
                <a href="{{ route('admin.pasien.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 font-bold transition group">
                    <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i> Kembali ke Daftar Pasien
                </a>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-80 h-full bg-gradient-to-l from-indigo-50/50 to-transparent pointer-events-none"></div>
                <i class="fas fa-microscope absolute -right-10 -bottom-10 text-[15rem] text-indigo-50/30 pointer-events-none rotate-12"></i>

                <div class="p-8 sm:p-12 relative z-10">
                    <div class="flex flex-col lg:flex-row gap-10 items-start lg:items-center justify-between">
                        
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                            <div class="w-24 h-24 rounded-[2rem] {{ $pasien->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }} flex items-center justify-center text-4xl font-black shadow-inner border-4 border-white">
                                {{ strtoupper(substr($pasien->nama_lengkap, 0, 1)) }}
                            </div>
                            <div>
                                <div class="flex flex-wrap items-center gap-3 mb-2">
                                    <h3 class="text-4xl font-black text-gray-900 tracking-tight">{{ $pasien->nama_lengkap }}</h3>
                                    <span class="bg-slate-900 text-white text-xs font-black px-4 py-1.5 rounded-xl uppercase tracking-[0.2em] shadow-lg">
                                        {{ $pasien->no_rm ?? 'NO-RM' }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-y-2 gap-x-6 text-sm font-bold text-gray-400 uppercase tracking-widest">
                                    <span class="flex items-center"><i class="far fa-envelope mr-2 text-indigo-400"></i> {{ $pasien->user->email ?? 'N/A' }}</span>
                                    <span class="flex items-center"><i class="fas fa-phone-alt mr-2 text-indigo-400"></i> {{ $pasien->no_telepon }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 w-full lg:w-auto">
                            <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="flex-1 lg:flex-none bg-white border-2 border-amber-400 text-amber-500 hover:bg-amber-400 hover:text-white px-8 py-3 rounded-2xl font-black transition-all flex items-center justify-center gap-2 uppercase text-xs tracking-widest shadow-sm">
                                <i class="fas fa-edit"></i> Edit Profil
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12 bg-slate-50/80 backdrop-blur-sm p-8 rounded-[2rem] border border-white">
                        <div class="space-y-1">
                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Gender</span>
                            <span class="font-bold text-gray-800 text-lg flex items-center gap-2">
                                @if($pasien->jenis_kelamin == 'L')
                                    <i class="fas fa-mars text-blue-500"></i> Laki-laki
                                @else
                                    <i class="fas fa-venus text-pink-500"></i> Perempuan
                                @endif
                            </span>
                        </div>
                        <div class="space-y-1">
                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Usia Saat Ini</span>
                            <span class="font-bold text-gray-800 text-lg">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} <span class="text-gray-400 font-medium">Tahun</span></span>
                        </div>
                        <div class="space-y-1">
                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tanggal Lahir</span>
                            <span class="font-bold text-gray-800 text-lg">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d F Y') }}</span>
                        </div>
                        <div class="space-y-1">
                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Domisili</span>
                            <span class="font-bold text-gray-700 text-sm leading-snug line-clamp-2">{{ $pasien->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden">
                <div class="px-10 py-8 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                            <i class="fas fa-history text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-2xl text-gray-900 tracking-tight uppercase">Riwayat Medis</h3>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Catatan Kunjungan Pasien</p>
                        </div>
                    </div>
                    <div class="bg-slate-100 px-6 py-2.5 rounded-xl border border-slate-200">
                        <span class="text-slate-500 font-bold text-sm uppercase tracking-wider">Total: </span>
                        <span class="text-indigo-600 font-black text-lg">{{ $riwayat->count() }}</span>
                    </div>
                </div>
                
                <div class="p-0 overflow-x-auto">
                    <table class="min-w-full table-auto text-left border-collapse">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-10 py-5 font-black text-gray-400 uppercase tracking-[0.2em] text-[10px] w-48">Waktu Kunjungan</th>
                                <th class="px-8 py-5 font-black text-gray-400 uppercase tracking-[0.2em] text-[10px]">Dokter / Spesialis</th>
                                <th class="px-8 py-5 font-black text-gray-400 uppercase tracking-[0.2em] text-[10px]">Diagnosa & Keluhan</th>
                                <th class="px-8 py-5 font-black text-gray-400 uppercase tracking-[0.2em] text-[10px]">Resep Obat</th>
                                <th class="px-10 py-5 font-black text-gray-400 uppercase tracking-[0.2em] text-[10px] text-right">Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($riwayat as $kunjungan)
                            <tr class="hover:bg-indigo-50/20 transition-all duration-200 group">
                                <td class="px-10 py-8">
                                    <div class="font-black text-indigo-600 text-base">{{ $kunjungan->updated_at->format('d M Y') }}</div>
                                    <div class="text-[11px] font-bold text-gray-400 uppercase mt-1 tracking-widest"><i class="far fa-clock mr-1 text-indigo-300"></i>{{ $kunjungan->updated_at->format('H:i') }} WITA</div>
                                </td>
                                <td class="px-8 py-8">
                                    <div class="font-extrabold text-gray-800 text-base">Dr. {{ $kunjungan->dokter->nama_lengkap }}</div>
                                    <div class="inline-block mt-2 text-[9px] bg-emerald-500 text-white px-3 py-1 rounded-lg font-black uppercase tracking-widest shadow-sm">
                                        {{ $kunjungan->dokter->spesialis }}
                                    </div>
                                </td>
                                <td class="px-8 py-8">
                                    <div class="mb-4">
                                        <div class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1">Keluhan</div>
                                        <p class="text-sm text-gray-500 italic leading-relaxed bg-amber-50/50 p-3 rounded-xl border border-amber-100/50">"{{ $kunjungan->keluhan }}"</p>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-1">Diagnosa Final</div>
                                        <p class="text-sm font-black text-gray-900 leading-relaxed">{{ $kunjungan->diagnosa }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-8">
                                    @if($kunjungan->obat->count() > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($kunjungan->obat as $obat)
                                                <div class="bg-white border border-gray-200 rounded-xl p-3 flex flex-col min-w-[120px] shadow-sm group-hover:border-indigo-200 transition-colors">
                                                    <span class="text-xs font-black text-gray-800 mb-1"><i class="fas fa-pills text-indigo-400 mr-2"></i>{{ $obat->nama_obat }}</span>
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase italic">{{ $obat->pivot->jumlah }} Satuan</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs font-bold text-gray-400 bg-gray-100 px-4 py-2 rounded-xl italic border border-dashed border-gray-200">Tidak ada resep</span>
                                    @endif
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <div class="text-xs font-bold text-gray-400 uppercase mb-1">Total Bayar</div>
                                    <div class="text-xl font-black text-indigo-600 tracking-tighter">
                                        Rp {{ number_format($kunjungan->total_bayar, 0, ',', '.') }}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 text-5xl mb-6 shadow-inner">
                                            <i class="fas fa-folder-open"></i>
                                        </div>
                                        <h4 class="font-black text-slate-400 uppercase tracking-[0.3em] text-xl">Kosong</h4>
                                        <p class="text-slate-400 text-sm mt-2 max-w-xs mx-auto">Pasien ini belum memiliki riwayat pengobatan yang tercatat di sistem Bina Usada.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="bg-gray-50/50 p-6 text-center border-t border-gray-100">
                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.5em]">Layanan Rekam Medis Terintegrasi Bina Usada</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>