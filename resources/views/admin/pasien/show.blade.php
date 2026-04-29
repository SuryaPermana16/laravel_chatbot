<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-notes-medical mr-2 text-indigo-600"></i>
            {{ __('Detail Rekam Medis') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="mb-2">
                <a href="{{ route('admin.pasien.index') }}"
                   class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar Pasien
                </a>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow border border-gray-100 overflow-hidden">
                <div class="p-8 sm:p-12">

                    <div class="flex flex-col lg:flex-row gap-8 justify-between">

                        <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-center">
                            <div class="w-24 h-24 rounded-[2rem] {{ $pasien->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }} flex items-center justify-center text-4xl font-black">
                                {{ strtoupper(substr($pasien->nama_lengkap, 0, 1)) }}
                            </div>

                            <div>
                                <h3 class="text-4xl font-black text-gray-900">
                                    {{ $pasien->nama_lengkap }}
                                </h3>

                                <div class="mt-2 text-sm text-gray-500 font-bold">
                                    {{ $pasien->no_rm }}
                                </div>

                                <div class="mt-2 text-sm text-gray-500">
                                    {{ $pasien->user->email ?? '-' }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ $pasien->no_telepon }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('admin.pasien.edit', $pasien->id) }}"
                               class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl font-bold text-sm">
                                Edit Profil
                            </a>
                        </div>

                    </div>

                    {{-- BIODATA --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10 bg-slate-50 p-8 rounded-2xl">

                        <div>
                            <div class="text-xs text-gray-400 font-bold uppercase mb-1">
                                Gender
                            </div>

                            <div class="font-bold text-gray-800">
                                {{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-xs text-gray-400 font-bold uppercase mb-1">
                                Usia
                            </div>

                            <div class="font-bold text-gray-800">
                                {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun
                            </div>
                        </div>

                        <div>
                            <div class="text-xs text-gray-400 font-bold uppercase mb-1">
                                Tanggal Lahir
                            </div>

                            <div class="font-bold text-gray-800">
                                {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d F Y') }}
                            </div>
                        </div>

                        <div>
                            <div class="text-xs text-gray-400 font-bold uppercase mb-1">
                                Alamat
                            </div>

                            <div class="font-bold text-gray-700 text-sm">
                                {{ $pasien->alamat }}
                            </div>
                        </div>
                    </div>

                    {{-- DATA VITAL --}}
                    <div class="mt-8">
                        <h4 class="text-lg font-black text-emerald-600 uppercase mb-4">
                            Data Vital Pasien
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-100">
                                <div class="text-xs font-bold text-gray-400 uppercase mb-1">
                                    Berat Badan
                                </div>

                                <div class="text-2xl font-black text-gray-900">
                                    {{ $pasien->berat_badan ? $pasien->berat_badan . ' Kg' : 'Belum diisi' }}
                                </div>
                            </div>

                            <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                                <div class="text-xs font-bold text-gray-400 uppercase mb-1">
                                    Tinggi Badan
                                </div>

                                <div class="text-2xl font-black text-gray-900">
                                    {{ $pasien->tinggi_badan ? $pasien->tinggi_badan . ' Cm' : 'Belum diisi' }}
                                </div>
                            </div>

                            <div class="bg-red-50 p-6 rounded-2xl border border-red-100">
                                <div class="text-xs font-bold text-gray-400 uppercase mb-1">
                                    Tensi Darah
                                </div>

                                <div class="text-2xl font-black text-gray-900">
                                    {{ $pasien->tensi_darah ?? 'Belum diisi' }}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            {{-- RIWAYAT --}}
            <div class="bg-white rounded-[2.5rem] shadow border border-gray-100 overflow-hidden">

                <div class="px-10 py-8 border-b border-gray-100">
                    <h3 class="font-black text-2xl text-gray-900 uppercase">
                        Riwayat Medis
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase">Tanggal</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase">Dokter</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase">Diagnosa</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase">Biaya</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($riwayat as $kunjungan)
                                <tr>
                                    <td class="px-8 py-4 font-bold">
                                        {{ $kunjungan->updated_at->format('d-m-Y') }}
                                    </td>

                                    <td class="px-8 py-4">
                                        Dr. {{ $kunjungan->dokter->nama_lengkap }}
                                    </td>

                                    <td class="px-8 py-4">
                                        {{ $kunjungan->diagnosa }}
                                    </td>

                                    <td class="px-8 py-4 font-bold text-indigo-600">
                                        Rp {{ number_format($kunjungan->total_bayar, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-gray-400">
                                        Belum ada riwayat kunjungan.
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