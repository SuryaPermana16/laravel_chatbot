<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl mb-6 border border-gray-100">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-600 p-3 rounded-2xl text-white shadow-lg shadow-blue-200">
                            <i class="fas fa-pills text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-gray-800 tracking-tight">Dashboard Apoteker</h3>
                            <p class="text-gray-500 text-sm">Selamat bertugas, <span class="font-bold text-blue-600">{{ Auth::user()->name }}</span>. Siapkan resep pasien hari ini.</p>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center bg-blue-50 px-4 py-2 rounded-xl border border-blue-100">
                        <span class="relative flex h-3 w-3 mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                        </span>
                        <span class="text-blue-700 text-xs font-bold uppercase tracking-widest">Sistem Terhubung</span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center">
                        <i class="fas fa-prescription mr-3 text-blue-600"></i> Antrean Resep Masuk
                    </h3>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                        Total: {{ $antreanObat->count() }} Antrean
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-white border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">No</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Data Pasien</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Detail Resep</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($antreanObat as $item)
                            <tr class="hover:bg-blue-50/50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-center font-black text-blue-600 text-lg">
                                    {{ $item->no_antrian }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900 uppercase">{{ $item->pasien->nama_lengkap }}</div>
                                    <div class="text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-0.5 rounded inline-block border border-blue-100 mt-1">
                                        RM: {{ $item->pasien->no_rekam_medis ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100 italic shadow-inner line-clamp-3 hover:line-clamp-none transition-all duration-300">
                                        {!! nl2br(e($item->resep_obat)) !!}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('apoteker.selesai', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                            onclick="return confirm('Konfirmasi penyerahan obat untuk pasien ini?')" 
                                            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-blue-200 transition active:scale-95">
                                            <i class="fas fa-check-circle mr-2"></i> Serahkan Obat
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-30">
                                        <i class="fas fa-clipboard-list text-5xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 font-bold uppercase tracking-widest text-sm">Tidak Ada Resep Masuk</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-[0.3em]">
                    &copy; 2026 Klinik Bina Usada - Information System
                </p>
            </div>
        </div>
    </div>
</x-app-layout>