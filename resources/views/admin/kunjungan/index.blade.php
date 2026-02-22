<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-clipboard-list mr-2 text-pink-600"></i> {{ __('Antrean Kunjungan Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="mb-2 flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-pink-600 font-bold transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 sm:p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900">Daftar Antrean Hari Ini</h3>
                    <p class="text-gray-500 text-sm mt-1">Pantau dan kelola pergerakan status pasien di klinik secara real-time.</p>
                </div>
                <div class="bg-pink-50 border border-pink-100 text-pink-600 text-sm font-bold px-6 py-3 rounded-xl shadow-sm flex items-center gap-3">
                    <i class="far fa-calendar-alt text-lg"></i>
                    {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                <div class="p-0 overflow-x-auto">
                    <table class="min-w-full table-auto text-left text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-5 font-bold text-gray-500 uppercase tracking-wider text-center w-24">No.</th>
                                <th class="px-8 py-5 font-bold text-gray-500 uppercase tracking-wider">Info Pasien & Jam</th>
                                <th class="px-8 py-5 font-bold text-gray-500 uppercase tracking-wider">Tujuan Dokter</th>
                                <th class="px-8 py-5 font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                                <th class="px-8 py-5 font-bold text-gray-500 uppercase tracking-wider text-center">Tindakan Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($kunjungans as $k)
                            <tr class="hover:bg-pink-50/30 transition duration-200 group">
                                
                                <td class="px-8 py-5 text-center">
                                    <span class="inline-block bg-gray-900 text-white font-extrabold text-base px-4 py-2 rounded-xl shadow-sm whitespace-nowrap">
                                        {{ $k->no_antrian }}
                                    </span>
                                </td>

                                <td class="px-8 py-5">
                                    <div class="flex flex-wrap items-center gap-3 mb-2">
                                        <span class="font-bold text-gray-900 text-base whitespace-nowrap">{{ $k->pasien->nama_lengkap }}</span>
                                        
                                        <div class="w-1 h-1 bg-gray-300 rounded-full hidden sm:block"></div>
                                        
                                        <div class="text-xs font-medium text-gray-500 flex flex-row items-center gap-2 whitespace-nowrap">
                                            <span class="bg-gray-100 px-2.5 py-1 rounded-md text-gray-600 border border-gray-200">
                                                <i class="far fa-clock mr-1 text-gray-400"></i>{{ date('H:i', strtotime($k->jam_pilihan)) }}
                                            </span>
                                            <span class="bg-gray-100 px-2.5 py-1 rounded-md text-gray-600 border border-gray-200">
                                                RM: {{ $k->pasien->no_rm ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500 italic leading-snug">"{{ Str::limit($k->keluhan, 50) }}"</p>
                                </td>

                                <td class="px-8 py-5">
                                    <div class="font-bold text-gray-800 mb-1">Dr. {{ $k->dokter->nama_lengkap }}</div>
                                    <span class="inline-block text-[10px] bg-blue-50 border border-blue-100 text-blue-600 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">
                                        Poli {{ $k->dokter->spesialis }}
                                    </span>
                                </td>

                                <td class="px-8 py-5 text-center">
                                    @php
                                        // Definisi warna badge berdasarkan status
                                        $colors = [
                                            'menunggu'  => 'bg-yellow-50 text-yellow-600 border-yellow-200',
                                            'periksa'   => 'bg-blue-50 text-blue-600 border-blue-200',
                                            'diperiksa' => 'bg-blue-50 text-blue-600 border-blue-200',
                                            'selesai'   => 'bg-purple-50 text-purple-600 border-purple-200',
                                            'diambil'   => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                            'batal'     => 'bg-red-50 text-red-600 border-red-200'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center justify-center {{ $colors[$k->status] ?? 'bg-gray-100' }} px-3 py-1.5 rounded-lg text-xs font-bold uppercase border whitespace-nowrap shadow-sm">
                                        @if($k->status == 'menunggu') ⏳ Menunggu
                                        @elseif($k->status == 'periksa' || $k->status == 'diperiksa') 👨‍⚕️ Diperiksa
                                        @elseif($k->status == 'selesai') 💊 Resep Dibuat
                                        @elseif($k->status == 'diambil') ✅ Selesai
                                        @elseif($k->status == 'batal') ❌ Batal
                                        @else {{ $k->status }}
                                        @endif
                                    </span>
                                </td>

                                <td class="px-8 py-5 text-center">
                                    @if($k->status == 'diambil')
                                        <div class="text-xs font-bold text-emerald-600 bg-emerald-50 py-2.5 px-4 rounded-xl border border-emerald-100 inline-block whitespace-nowrap">
                                            <i class="fas fa-check-circle mr-1"></i> Obat Diambil
                                        </div>
                                    @elseif($k->status == 'batal')
                                        <div class="text-xs font-bold text-red-600 bg-red-50 py-2.5 px-4 rounded-xl border border-red-100 inline-block whitespace-nowrap">
                                            <i class="fas fa-ban mr-1"></i> Dibatalkan
                                        </div>
                                    @else
                                        <form action="{{ route('admin.kunjungan.updateStatus', $k->id) }}" method="POST" class="inline-block w-full max-w-[150px]">
                                            @csrf
                                            @method('PATCH')
                                            <div class="relative">
                                                <select name="status" onchange="this.form.submit()" class="block w-full pl-3 pr-8 py-2 text-xs font-bold text-gray-700 bg-white border border-gray-300 rounded-xl appearance-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 cursor-pointer shadow-sm hover:bg-gray-50 transition">
                                                    <option value="menunggu" {{ $k->status == 'menunggu' ? 'selected' : '' }}>Set: Menunggu</option>
                                                    <option value="periksa" {{ $k->status == 'periksa' || $k->status == 'diperiksa' ? 'selected' : '' }}>Set: Diperiksa</option>
                                                    <option value="selesai" {{ $k->status == 'selesai' ? 'selected' : '' }}>Set: Selesai</option>
                                                    <option value="batal" {{ $k->status == 'batal' ? 'selected' : '' }}>Batalkan</option>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                                    <i class="fas fa-chevron-down text-[10px]"></i>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 text-4xl mb-4">
                                            <i class="fas fa-clipboard-check"></i>
                                        </div>
                                        <h4 class="font-bold text-gray-500 text-lg mb-1">Ruang Tunggu Kosong</h4>
                                        <p class="text-gray-400 text-sm">Belum ada pasien yang mendaftar antrean untuk hari ini.</p>
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