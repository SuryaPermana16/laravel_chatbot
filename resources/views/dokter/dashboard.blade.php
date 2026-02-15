<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-100">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-gray-600">Selamat bertugas. Berikut adalah daftar antrean pasien Anda hari ini.</p>
                    </div>
                    <div class="text-sm text-blue-800 bg-blue-100 px-4 py-2 rounded-full font-bold shadow-sm">
                        <i class="far fa-calendar-alt mr-2 text-blue-600"></i> {{ now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-bold uppercase tracking-wider">Total Pasien Hari Ini</div>
                        <div class="text-3xl font-extrabold text-gray-800 mt-2">{{ $totalAntrean }}</div>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-full text-blue-500"><i class="fas fa-users text-3xl"></i></div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-bold uppercase tracking-wider">Menunggu Diperiksa</div>
                        <div class="text-3xl font-extrabold text-yellow-600 mt-2">{{ $sisaAntrean }}</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-full text-yellow-500"><i class="fas fa-hourglass-half text-3xl"></i></div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-bold uppercase tracking-wider">Selesai Diperiksa</div>
                        <div class="text-3xl font-extrabold text-green-600 mt-2">{{ $selesaiPeriksa }}</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-full text-green-500"><i class="fas fa-check-circle text-3xl"></i></div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 mb-8">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center">
                        <i class="fas fa-clipboard-list mr-2 text-blue-500"></i> Daftar Antrean Berjalan
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto text-left">
                        <thead class="bg-white border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">No. Antrean</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nama Pasien</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Keluhan</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($antreans as $kunjungan)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold border-2 border-blue-200">
                                        {{ $kunjungan->no_antrian }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $kunjungan->pasien->nama_lengkap }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($kunjungan->keluhan, 40) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('dokter.periksa', $kunjungan->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase hover:bg-blue-700 transition shadow-sm">
                                        Periksa Pasien
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">Antrean sudah habis untuk saat ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center">
                        <i class="fas fa-history mr-2 text-green-500"></i> Riwayat Pasien Terakhir
                    </h3>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-left">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Jam Selesai</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Pasien</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Diagnosa / Catatan</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Status Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($riwayat as $item)
                                <tr class="hover:bg-green-50/30 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 italic">
                                        {{ $item->updated_at->format('H:i') }} WITA
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $item->pasien->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-400">Antrean: {{ $item->no_antrian }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->rekamMedis->diagnosa ?? ($item->diagnosa ?? 'Selesai diperiksa') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'menunggu_obat')
                                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-yellow-100 text-yellow-700 border border-yellow-200">Di Apotek</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-green-100 text-green-700 border border-green-200 font-bold">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada riwayat hari ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>