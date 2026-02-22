<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-notes-medical mr-2 text-indigo-600"></i> {{ __('Detail Rekam Medis Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div>
                <a href="{{ route('admin.pasien.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Pasien
                </a>
            </div>

            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-full bg-gradient-to-l from-indigo-50 to-transparent opacity-50 pointer-events-none"></div>
                <i class="fas fa-hospital-user absolute -right-6 -bottom-6 text-9xl text-indigo-50 opacity-50 pointer-events-none"></i>

                <div class="p-8 sm:p-10 relative z-10">
                    <div class="flex flex-col md:flex-row gap-6 md:items-center justify-between mb-8">
                        <div class="flex items-center gap-5">
                            <div class="w-20 h-20 rounded-2xl {{ $pasien->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }} flex items-center justify-center text-3xl font-extrabold shadow-sm">
                                {{ strtoupper(substr($pasien->nama_lengkap, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $pasien->nama_lengkap }}</h3>
                                <div class="flex flex-wrap gap-4 text-sm font-medium text-gray-500">
                                    <span class="flex items-center bg-gray-50 px-3 py-1 rounded-lg border border-gray-100"><i class="fas fa-envelope mr-2 text-gray-400"></i> {{ $pasien->user->email ?? 'Tidak ada email' }}</span>
                                    <span class="flex items-center bg-gray-50 px-3 py-1 rounded-lg border border-gray-100"><i class="fas fa-phone-alt mr-2 text-gray-400"></i> {{ $pasien->no_telepon }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="bg-white border-2 border-amber-500 text-amber-500 hover:bg-amber-500 hover:text-white px-5 py-2.5 rounded-xl font-bold transition flex items-center justify-center gap-2">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 p-6 rounded-2xl border border-gray-100">
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Jenis Kelamin</span>
                            <span class="font-bold text-gray-900 text-lg">{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Usia Pasien</span>
                            <span class="font-bold text-gray-900 text-lg">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} <span class="text-sm font-normal text-gray-500">Tahun</span></span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Lahir</span>
                            <span class="font-bold text-gray-900 text-lg">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Domisili</span>
                            <span class="font-medium text-gray-700 block leading-tight">{{ $pasien->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-white flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-lg">
                            <i class="fas fa-file-medical-alt"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-gray-900">Riwayat Pengobatan</h3>
                    </div>
                    <span class="bg-slate-100 text-slate-600 px-4 py-2 rounded-lg text-sm font-bold border border-slate-200">
                        Total: {{ $riwayat->count() }} Kunjungan
                    </span>
                </div>
                
                <div class="p-0 overflow-x-auto">
                    <table class="min-w-full table-auto text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-4 font-bold text-gray-500 uppercase tracking-wider text-sm w-1/6">Tanggal & Waktu</th>
                                <th class="px-8 py-4 font-bold text-gray-500 uppercase tracking-wider text-sm w-1/5">Dokter Pemeriksa</th>
                                <th class="px-8 py-4 font-bold text-gray-500 uppercase tracking-wider text-sm w-1/4">Keluhan & Diagnosa</th>
                                <th class="px-8 py-4 font-bold text-gray-500 uppercase tracking-wider text-sm w-1/4">Resep Obat</th>
                                <th class="px-8 py-4 font-bold text-gray-500 uppercase tracking-wider text-sm text-right">Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($riwayat as $kunjungan)
                            <tr class="hover:bg-slate-50 transition align-top">
                                <td class="px-8 py-5">
                                    <div class="font-extrabold text-indigo-600">{{ $kunjungan->updated_at->format('d M Y') }}</div>
                                    <div class="text-sm font-medium text-gray-500 mt-1"><i class="far fa-clock mr-1"></i>{{ $kunjungan->updated_at->format('H:i') }} WITA</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="font-bold text-gray-900">Dr. {{ $kunjungan->dokter->nama_lengkap }}</div>
                                    <span class="inline-block mt-1 text-[10px] bg-emerald-50 border border-emerald-100 text-emerald-600 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">{{ $kunjungan->dokter->spesialis }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="mb-3">
                                        <span class="inline-block text-[10px] font-bold text-amber-500 bg-amber-50 px-2 py-0.5 rounded mb-1 uppercase tracking-wider">Keluhan</span>
                                        <p class="text-sm text-gray-600 italic leading-relaxed">"{{ $kunjungan->keluhan }}"</p>
                                    </div>
                                    <div>
                                        <span class="inline-block text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-0.5 rounded mb-1 uppercase tracking-wider">Diagnosa Akhir</span>
                                        <p class="text-sm font-bold text-gray-900 leading-relaxed">{{ $kunjungan->diagnosa }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    @if($kunjungan->obat->count() > 0)
                                        <ul class="space-y-2">
                                            @foreach($kunjungan->obat as $obat)
                                                <li class="flex justify-between items-center text-sm border-b border-gray-100 pb-1 last:border-0 last:pb-0">
                                                    <span class="font-medium text-gray-700"><i class="fas fa-pills text-blue-400 mr-2"></i>{{ $obat->nama_obat }}</span> 
                                                    <span class="text-xs font-bold bg-gray-100 px-2 py-0.5 rounded text-gray-600">{{ $obat->pivot->jumlah }} pcs</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-lg italic inline-flex items-center"><i class="fas fa-ban mr-2"></i>Tanpa resep obat</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <span class="inline-block bg-green-50 text-green-700 border border-green-200 font-extrabold px-3 py-1.5 rounded-lg">
                                        Rp {{ number_format($kunjungan->total_bayar, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 text-3xl mb-4">
                                            <i class="fas fa-folder-open"></i>
                                        </div>
                                        <h4 class="font-bold text-gray-500 text-lg mb-1">Belum Ada Riwayat</h4>
                                        <p class="text-gray-400 text-sm">Pasien ini belum memiliki catatan pengobatan atau kunjungan yang selesai.</p>
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