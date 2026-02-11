<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-gray-600">Selamat bertugas. Berikut adalah daftar antrean pasien Anda hari ini.</p>
                    </div>
                    <div class="text-sm font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-lg border border-blue-100">
                        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-bold uppercase tracking-wider">Total Pasien Hari Ini</div>
                        <div class="text-3xl font-extrabold text-gray-800 mt-2">{{ $totalAntrean }}</div>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-full text-blue-500">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-bold uppercase tracking-wider">Menunggu Diperiksa</div>
                        <div class="text-3xl font-extrabold text-yellow-600 mt-2">{{ $sisaAntrean }}</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-full text-yellow-500">
                        <i class="fas fa-hourglass-half text-3xl"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-bold uppercase tracking-wider">Selesai Diperiksa</div>
                        <div class="text-3xl font-extrabold text-green-600 mt-2">{{ $selesaiPeriksa }}</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-full text-green-500">
                        <i class="fas fa-check-circle text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center">
                        <i class="fas fa-clipboard-list mr-2 text-blue-500"></i> Daftar Antrean Berjalan
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-white border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">No. Antrean</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jam</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Keluhan Awal</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($antreans as $kunjungan)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold text-lg border-2 border-blue-200">
                                        {{ $kunjungan->no_antrian }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-600">
                                    {{ date('H:i', strtotime($kunjungan->jam_pilihan)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900 text-base">{{ $kunjungan->pasien->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500 mt-1">No. RM: {{ $kunjungan->pasien->no_rekam_medis ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ Str::limit($kunjungan->keluhan, 40) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($kunjungan->status == 'menunggu')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-yellow-100 text-yellow-700 border border-yellow-200">
                                            Menunggu
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-blue-100 text-blue-700 border border-blue-200">
                                            Sedang Diperiksa
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('dokter.periksa', $kunjungan->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm hover:shadow-md">
                                        <i class="fas fa-stethoscope mr-2"></i> Periksa
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-3">
                                            <i class="fas fa-mug-hot text-2xl"></i>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-700">Antrean Kosong</h4>
                                        <p class="text-gray-500 text-sm mt-1">Belum ada pasien yang mengantre saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>