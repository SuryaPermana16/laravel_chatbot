<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekam Medis Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div>
                <a href="{{ route('admin.pasien.index') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Pasien
                </a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                
                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $pasien->nama_lengkap }}</h3>
                    <div class="text-sm text-gray-500 mb-4 flex gap-4">
                        <span><i class="fas fa-envelope mr-1"></i> {{ $pasien->user->email ?? 'Tidak ada email' }}</span>
                        <span><i class="fas fa-phone mr-1"></i> {{ $pasien->no_telepon }}</span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-100 text-sm">
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase">Jenis Kelamin</span>
                            <span class="font-bold text-gray-800">{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase">Usia</span>
                            <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase">Tanggal Lahir</span>
                            <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase">Alamat</span>
                            <span class="font-bold text-gray-800 truncate" title="{{ $pasien->alamat }}">{{ Str::limit($pasien->alamat, 30) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-gray-700"><i class="fas fa-history mr-2 text-blue-500"></i> Riwayat Pengobatan</h3>
                    <span class="text-xs text-gray-400">{{ $riwayat->count() }} Kunjungan Selesai</span>
                </div>
                
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-medium">
                            <tr>
                                <th class="px-6 py-3 w-1/6">Tanggal</th>
                                <th class="px-6 py-3 w-1/6">Dokter</th>
                                <th class="px-6 py-3 w-1/4">Keluhan & Diagnosa</th>
                                <th class="px-6 py-3 w-1/4">Resep Obat</th>
                                <th class="px-6 py-3 text-right">Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($riwayat as $kunjungan)
                            <tr class="hover:bg-gray-50 transition align-top">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-800">{{ $kunjungan->updated_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $kunjungan->updated_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-700">Dr. {{ $kunjungan->dokter->nama_lengkap }}</div>
                                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">{{ $kunjungan->dokter->spesialis }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="mb-2">
                                        <span class="text-xs font-bold text-gray-400 uppercase">Keluhan:</span>
                                        <p class="italic text-gray-600">"{{ $kunjungan->keluhan }}"</p>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-gray-400 uppercase">Diagnosa:</span>
                                        <p class="font-bold text-gray-800">{{ $kunjungan->diagnosa }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($kunjungan->obat->count() > 0)
                                        <ul class="list-disc list-inside text-gray-600 space-y-1">
                                            @foreach($kunjungan->obat as $obat)
                                                <li>
                                                    {{ $obat->nama_obat }} 
                                                    <span class="text-xs text-gray-400">({{ $obat->pivot->jumlah }} pcs)</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-400 text-xs italic">- Tidak ada obat -</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="font-bold text-green-600">Rp {{ number_format($kunjungan->total_bayar, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 bg-gray-50/30">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-folder-open text-3xl mb-2 opacity-30"></i>
                                        <p>Belum ada riwayat pengobatan untuk pasien ini.</p>
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