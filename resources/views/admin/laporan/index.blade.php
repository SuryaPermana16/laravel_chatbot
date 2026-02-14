<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <i class="fas fa-chart-line mr-3 text-blue-600"></i>
            {{ __('Laporan Keuangan & Kunjungan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 font-bold transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-col sm:flex-row items-end gap-4 w-full md:w-auto">
                        <div class="w-full sm:w-auto">
                            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div class="w-full sm:w-auto">
                            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div class="w-full sm:w-auto">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-md transition transform hover:scale-105 flex justify-center items-center gap-2">
                                <i class="fas fa-filter"></i> Tampilkan
                            </button>
                        </div>
                    </form>

                    <div class="flex gap-3 w-full md:w-auto mt-4 md:mt-0 border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6">
                        <a href="{{ route('admin.laporan.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="flex-1 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-5 py-2.5 rounded-lg font-bold shadow-sm transition border border-red-200 flex justify-center items-center gap-2">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a href="{{ route('admin.laporan.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="flex-1 bg-green-50 text-green-600 hover:bg-green-600 hover:text-white px-5 py-2.5 rounded-lg font-bold shadow-sm transition border border-green-200 flex justify-center items-center gap-2">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-5 transition hover:shadow-md">
                    <div class="bg-green-100 text-green-600 p-4 rounded-xl">
                        <i class="fas fa-coins text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Pendapatan</p>
                        <h3 class="text-3xl font-black text-gray-800 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                        <p class="text-xs text-gray-400 mt-1">
                            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-5 transition hover:shadow-md">
                    <div class="bg-blue-100 text-blue-600 p-4 rounded-xl">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Pasien</p>
                        <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $kunjungans->count() }} <span class="text-sm font-normal text-gray-400">Orang</span></h3>
                        <p class="text-xs text-gray-400 mt-1">
                            Pasien Lunas (Obat Diambil)
                        </p>
                    </div>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">Rincian Transaksi</h3>
                    <span class="text-xs text-gray-400 italic">Data terurut dari yang terbaru</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-medium border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 uppercase text-xs tracking-wider">Waktu</th>
                                <th class="px-6 py-4 uppercase text-xs tracking-wider">Pasien</th>
                                <th class="px-6 py-4 uppercase text-xs tracking-wider">Dokter</th>
                                <th class="px-6 py-4 uppercase text-xs tracking-wider text-right">Biaya Jasa</th>
                                <th class="px-6 py-4 uppercase text-xs tracking-wider text-right">Biaya Obat</th>
                                <th class="px-6 py-4 uppercase text-xs tracking-wider text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($kunjungans as $kunjungan)
                            <tr class="hover:bg-blue-50/30 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                    <div class="font-bold text-gray-800">{{ $kunjungan->updated_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $kunjungan->updated_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">{{ $kunjungan->pasien->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500">RM: {{ $kunjungan->pasien->no_rm ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs">
                                            <i class="fas fa-user-md"></i>
                                        </div>
                                        <span class="text-gray-700">Dr. {{ $kunjungan->dokter->nama_lengkap }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right text-gray-600 font-mono">
                                    Rp {{ number_format($kunjungan->biaya_jasa_dokter, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right text-gray-600 font-mono">
                                    Rp {{ number_format($kunjungan->biaya_obat, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                        Rp {{ number_format($kunjungan->total_bayar, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-gray-400 bg-gray-50/30">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                            <i class="fas fa-receipt text-2xl text-gray-300"></i>
                                        </div>
                                        <p class="font-medium">Belum ada transaksi pada periode ini.</p>
                                        <p class="text-xs mt-1">Coba ubah filter tanggalnya.</p>
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