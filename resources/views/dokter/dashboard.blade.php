<x-app-layout>
    <div class="py-12 text-left bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gradient-to-r from-emerald-600 to-teal-500 rounded-[2rem] p-8 md:p-10 shadow-lg shadow-emerald-200 relative overflow-hidden text-white">
                <div class="absolute -right-10 -top-10 opacity-20 pointer-events-none">
                    <i class="fas fa-user-md text-9xl"></i>
                </div>
                
                <div class="flex flex-col md:flex-row md:justify-between md:items-center relative z-10 gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/20 text-emerald-50 text-xs font-bold rounded-full uppercase tracking-wider mb-4 border border-white/20 backdrop-blur-sm">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span> Sedang Bertugas
                        </div>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
                        <p class="text-emerald-50 font-medium text-base">Semoga hari Anda menyenangkan. Berikut adalah ringkasan antrean pasien Anda hari ini.</p>
                    </div>
                    <div class="flex flex-col items-start md:items-end gap-2">
                        <div class="text-sm text-emerald-50 bg-white/10 backdrop-blur-md border border-white/20 px-6 py-4 rounded-2xl font-bold shadow-sm flex items-center gap-3 w-fit">
                            <i class="far fa-calendar-check text-2xl"></i> 
                            <div>
                                <div class="text-[10px] text-emerald-100 uppercase tracking-wider">Hari Ini</div>
                                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex items-center justify-between group hover:-translate-y-1 transition duration-300">
                    <div>
                        <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Total Pasien Hari Ini</div>
                        <div class="text-4xl font-black text-gray-800">{{ $totalAntrean }} <span class="text-sm font-medium text-gray-400">Orang</span></div>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-3xl group-hover:bg-blue-500 group-hover:text-white transition duration-300 shadow-inner">
                        <i class="fas fa-users"></i>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex items-center justify-between group hover:-translate-y-1 transition duration-300">
                    <div>
                        <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Menunggu Diperiksa</div>
                        <div class="text-4xl font-black text-amber-500">{{ $sisaAntrean }} <span class="text-sm font-medium text-gray-400">Orang</span></div>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-3xl group-hover:bg-amber-500 group-hover:text-white transition duration-300 shadow-inner">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex items-center justify-between group hover:-translate-y-1 transition duration-300">
                    <div>
                        <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Selesai Diperiksa</div>
                        <div class="text-4xl font-black text-emerald-500">{{ $selesaiPeriksa }} <span class="text-sm font-medium text-gray-400">Orang</span></div>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-3xl group-hover:bg-emerald-500 group-hover:text-white transition duration-300 shadow-inner">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                <div class="px-8 py-6 border-b border-gray-100 bg-white flex justify-between items-center">
                    <h3 class="font-extrabold text-xl text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        Daftar Antrean Berjalan
                    </h3>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-100 uppercase tracking-wider">Prioritas Atas</span>
                </div>
                
                <div class="overflow-x-auto p-0">
                    <table class="min-w-full table-auto text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-24">Nomor</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Info Pasien</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Keluhan Awal</th>
                                <th class="px-8 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="antrean-table-body" class="divide-y divide-gray-100 bg-white">
                            @forelse($antreans as $kunjungan)
                            <tr class="hover:bg-blue-50/30 transition duration-200 group">
                                <td class="px-8 py-5 text-center">
                                    <span class="inline-block bg-gray-900 text-white font-extrabold text-base px-4 py-2 rounded-xl shadow-sm whitespace-nowrap">
                                        {{ $kunjungan->no_antrian }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="font-bold text-gray-900 text-base whitespace-nowrap">{{ $kunjungan->pasien->nama_lengkap }}</span>
                                        <div class="w-1 h-1 bg-gray-300 rounded-full hidden sm:block"></div>
                                        <div class="text-xs font-medium text-gray-500 flex flex-row items-center gap-2 whitespace-nowrap">
                                            <span class="bg-gray-100 px-2.5 py-1 rounded-md text-gray-600 border border-gray-200">
                                                <i class="far fa-clock mr-1.5 text-gray-400"></i>{{ date('H:i', strtotime($kunjungan->jam_pilihan)) }}
                                            </span>
                                            <span class="bg-gray-100 px-2.5 py-1 rounded-md text-gray-600 border border-gray-200">
                                                RM: {{ $kunjungan->pasien->no_rm ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm text-gray-600 italic leading-relaxed">"{{ Str::limit($kunjungan->keluhan, 60) }}"</p>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <a href="{{ route('dokter.periksa', $kunjungan->id) }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-blue-700 transition shadow-md shadow-blue-200 transform group-hover:-translate-y-0.5 whitespace-nowrap">
                                        <i class="fas fa-stethoscope text-sm"></i> Periksa
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 text-3xl mb-4">
                                            <i class="fas fa-mug-hot"></i>
                                        </div>
                                        <h4 class="font-bold text-gray-500 text-lg mb-1">Antrean Kosong</h4>
                                        <p class="text-gray-400 text-sm">Belum ada pasien yang menunggu untuk diperiksa saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100 text-left">
                <div class="px-8 py-6 border-b border-gray-100 bg-white flex justify-between items-center">
                    <h3 class="font-extrabold text-xl text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="fas fa-history"></i>
                        </div>
                        Riwayat Pasien Hari Ini
                    </h3>
                </div>
                
                <div class="overflow-x-auto p-0">
                    <table class="min-w-full table-auto text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Waktu Selesai</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Diagnosa Akhir</th>
                                <th class="px-8 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($riwayat as $item)
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="px-8 py-5">
                                    <span class="inline-flex items-center font-bold text-gray-600 bg-gray-100 px-3 py-1 rounded-lg border border-gray-200 text-sm">
                                        <i class="far fa-clock mr-2 text-gray-400"></i> {{ $item->updated_at->format('H:i') }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="font-bold text-gray-900">{{ $item->pasien->nama_lengkap }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-sm font-medium text-gray-700">{{ $item->diagnosa ?? '- Tidak ada catatan -' }}</div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <i class="fas fa-check mr-1.5"></i> Selesai
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-gray-400 italic">Belum ada riwayat pemeriksaan hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>