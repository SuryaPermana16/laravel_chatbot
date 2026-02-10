<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="flex justify-end items-center mb-4">
                <span class="bg-white text-gray-600 border border-gray-200 text-sm font-bold px-4 py-2 rounded-full shadow-sm flex items-center">
                    <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                    {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                </span>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full table-auto text-left">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Jam Janji</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Info Pasien</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Dokter Tujuan</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">No. Antrean</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Saat Ini</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse($kunjungans as $k)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-blue-50 text-blue-700 font-bold px-3 py-1 rounded border border-blue-100">
                                            {{ date('H:i', strtotime($k->jam_pilihan)) }}
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $k->pasien->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500 mt-1 italic">
                                        "{{ Str::limit($k->keluhan, 30) }}"
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm font-medium">
                                    {{ $k->dokter->nama_lengkap }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="bg-gray-800 text-white px-3 py-1 rounded-full font-bold text-xs shadow-sm">
                                        #{{ $k->no_antrian }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @php
                                        $colors = [
                                            'menunggu' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'diperiksa' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'selesai' => 'bg-green-100 text-green-800 border-green-200',
                                            'batal' => 'bg-red-100 text-red-800 border-red-200'
                                        ];
                                    @endphp
                                    <span class="{{ $colors[$k->status] ?? 'bg-gray-100' }} px-3 py-1 rounded-full text-xs font-bold uppercase border">
                                        {{ $k->status }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.kunjungan.updateStatus', $k->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                                class="text-xs border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 cursor-pointer hover:bg-gray-50">
                                            <option value="menunggu" {{ $k->status == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                                            <option value="diperiksa" {{ $k->status == 'diperiksa' ? 'selected' : '' }}>👨‍⚕️ Diperiksa</option>
                                            <option value="selesai" {{ $k->status == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                            <option value="batal" {{ $k->status == 'batal' ? 'selected' : '' }}>❌ Batal</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 bg-gray-50 rounded-b-lg">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-calendar-times text-4xl mb-3 text-gray-300"></i>
                                        <p>Belum ada jadwal pasien untuk hari ini.</p>
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