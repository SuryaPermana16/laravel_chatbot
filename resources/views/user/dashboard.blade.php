<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-blue-600 overflow-hidden shadow-sm sm:rounded-lg mb-6 text-white text-gray-900">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-white">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="mt-2 text-blue-100">Selamat datang di Klinik Bina Usada. Silakan pilih dokter untuk konsultasi.</p>
                </div>
            </div>

            <h3 class="font-bold text-xl mb-4 text-gray-800 flex items-center">
                <i class="fas fa-calendar-day mr-2 text-blue-600"></i> Jadwal Dokter Hari Ini ({{ $hariIni }})
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach($jadwals as $jadwal)
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition border border-gray-100">
                    <div class="flex items-center mb-4 text-gray-900">
                        <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                            <i class="fas fa-user-md text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-lg text-gray-800 text-gray-900">{{ $jadwal->dokter->nama_lengkap }}</h4>
                            <p class="text-sm text-gray-500 text-gray-900">{{ $jadwal->dokter->spesialis }}</p>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center text-sm mb-2 text-gray-900">
                            <span class="text-gray-600"><i class="far fa-calendar-alt mr-1"></i> Hari:</span>
                            <span class="font-bold text-gray-800 text-gray-900">{{ $jadwal->hari }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm mb-4 text-gray-900">
                            <span class="text-gray-600"><i class="far fa-clock mr-1"></i> Jam Praktek:</span>
                            <span class="font-bold text-green-600">
                                {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                            </span>
                        </div>
                        <a href="{{ route('user.daftar', $jadwal->id) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-bold shadow-sm transition">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            @if($jadwals->isEmpty())
                <div class="bg-white rounded-lg shadow-sm border border-dashed p-10 text-center">
                    <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 text-gray-900">Maaf, tidak ada jadwal dokter yang tersedia untuk hari **{{ $hariIni }}**.</p>
                </div>
            @endif

            <h3 class="font-bold text-xl mb-4 text-gray-800 flex items-center">
                <i class="fas fa-history mr-2 text-blue-600"></i> Riwayat Kunjungan Saya
            </h3>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50 text-gray-900">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Dokter</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">No. Antrean</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider text-blue-600">Jam Datang</th> 
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Keluhan</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider text-gray-900">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-900">
                            @forelse($riwayat as $r)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 text-gray-900">
                                    {{ \Carbon\Carbon::parse($r->tanggal_kunjungan)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-4 text-sm font-bold text-gray-800 text-gray-900">
                                    {{ $r->dokter->nama_lengkap }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="bg-blue-100 text-blue-700 font-extrabold px-3 py-1 rounded-full text-sm">
                                        {{ $r->no_antrian }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="text-sm font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded border border-blue-100">
                                        {{ date('H:i', strtotime($r->jam_pilihan)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500 text-gray-900">
                                    {{ Str::limit($r->keluhan, 40) }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @php
                                        $statusColor = [
                                            'menunggu' => 'bg-yellow-100 text-yellow-800',
                                            'diperiksa' => 'bg-blue-100 text-blue-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'batal' => 'bg-red-100 text-red-800',
                                        ][$r->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="{{ $statusColor }} px-2 py-1 rounded-md text-xs font-bold uppercase tracking-tighter text-gray-900">
                                        {{ $r->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400 italic text-sm text-gray-900 text-gray-900">
                                    Kamu belum memiliki riwayat pendaftaran kunjungan.
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