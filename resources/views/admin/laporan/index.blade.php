<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-file-invoice-dollar mr-2 text-red-600"></i> {{ __('Laporan Keuangan & Kunjungan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-red-600 font-bold transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    
                    <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-col sm:flex-row items-end gap-4 w-full lg:w-auto flex-1">
                        <div class="w-full sm:w-auto flex-1 max-w-xs">
                            <label class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Periode Awal</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="far fa-calendar text-gray-400"></i>
                                </div>
                                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full pl-10 pr-3 py-2.5 rounded-xl border border-gray-200 shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-500/20 text-sm outline-none transition">
                            </div>
                        </div>
                        <div class="w-full sm:w-auto flex-1 max-w-xs">
                            <label class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Periode Akhir</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="far fa-calendar-check text-gray-400"></i>
                                </div>
                                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full pl-10 pr-3 py-2.5 rounded-xl border border-gray-200 shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-500/20 text-sm outline-none transition">
                            </div>
                        </div>
                        <div class="w-full sm:w-auto">
                            <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white px-6 py-2.5 rounded-xl font-bold shadow-md transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2 h-[42px]">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </form>

                    <div class="flex gap-3 w-full lg:w-auto border-t lg:border-t-0 lg:border-l border-gray-100 pt-6 lg:pt-0 lg:pl-8">
                        <a href="{{ route('admin.laporan.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="flex-1 lg:flex-none bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-6 py-2.5 rounded-xl font-bold transition border border-red-100 flex justify-center items-center gap-2 h-[42px]">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </a>
                        <a href="{{ route('admin.laporan.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="flex-1 lg:flex-none bg-green-50 text-green-700 hover:bg-green-600 hover:text-white px-6 py-2.5 rounded-xl font-bold transition border border-green-100 flex justify-center items-center gap-2 h-[42px]">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 flex flex-col justify-center relative overflow-hidden group hover:border-emerald-200 transition duration-300">
                    <i class="fas fa-coins absolute -right-6 -bottom-6 text-8xl text-emerald-50 opacity-50 group-hover:scale-110 transition duration-500 pointer-events-none"></i>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold"><i class="fas fa-wallet"></i></div>
                            <p class="text-gray-500 text-sm font-bold uppercase tracking-wider">Total Pendapatan</p>
                        </div>
                        <h3 class="text-4xl font-black text-gray-900 mt-2 mb-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                        <p class="text-xs font-medium text-emerald-600 bg-emerald-50 inline-block px-2 py-1 rounded-md border border-emerald-100 mt-2">
                            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 flex flex-col justify-center relative overflow-hidden group hover:border-blue-200 transition duration-300">
                    <i class="fas fa-users absolute -right-6 -bottom-6 text-8xl text-blue-50 opacity-50 group-hover:scale-110 transition duration-500 pointer-events-none"></i>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold"><i class="fas fa-user-check"></i></div>
                            <p class="text-gray-500 text-sm font-bold uppercase tracking-wider">Total Pasien Selesai</p>
                        </div>
                        <h3 class="text-4xl font-black text-gray-900 mt-2 mb-1">{{ $kunjungans->count() }} <span class="text-lg font-bold text-gray-400">Orang</span></h3>
                        <p class="text-xs font-medium text-blue-600 bg-blue-50 inline-block px-2 py-1 rounded-md border border-blue-100 mt-2">
                            Telah melunasi tagihan (Obat Diambil)
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                <div class="px-8 py-6 border-b border-gray-100 bg-white flex justify-between items-center">
                    <h3 class="font-extrabold text-lg text-gray-900"><i class="fas fa-list-ul mr-2 text-gray-400"></i> Rincian Transaksi</h3>
                    <span class="text-xs font-bold bg-gray-100 text-gray-500 px-3 py-1 rounded-full border border-gray-200 uppercase tracking-wider">Terbaru di atas</span>
                </div>
                
                <div class="overflow-x-auto p-0">
                    <table class="min-w-full table-auto text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-bold border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-4 uppercase text-xs tracking-wider">Waktu Transaksi</th>
                                <th class="px-8 py-4 uppercase text-xs tracking-wider">Pasien & No. RM</th>
                                <th class="px-8 py-4 uppercase text-xs tracking-wider">Dokter Pemeriksa</th>
                                <th class="px-8 py-4 uppercase text-xs tracking-wider text-right">Biaya Jasa</th>
                                <th class="px-8 py-4 uppercase text-xs tracking-wider text-right">Biaya Obat</th>
                                <th class="px-8 py-4 uppercase text-xs tracking-wider text-right text-gray-900">Total Tagihan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($kunjungans as $kunjungan)
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="font-bold text-gray-800">{{ $kunjungan->updated_at->format('d M Y') }}</div>
                                    <div class="text-xs font-medium text-gray-400 mt-0.5"><i class="far fa-clock mr-1"></i>{{ $kunjungan->updated_at->format('H:i') }} WITA</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="font-bold text-gray-900">{{ $kunjungan->pasien->nama_lengkap }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-0.5">RM: {{ $kunjungan->pasien->no_rm ?? '-' }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="font-medium text-gray-700">Dr. {{ $kunjungan->dokter->nama_lengkap }}</div>
                                </td>
                                <td class="px-8 py-5 text-right text-gray-500 font-mono text-xs">
                                    Rp {{ number_format($kunjungan->biaya_jasa_dokter, 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-5 text-right text-gray-500 font-mono text-xs">
                                    Rp {{ number_format($kunjungan->biaya_obat, 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <span class="inline-block bg-green-50 text-green-700 px-3 py-1.5 rounded-lg font-extrabold border border-green-100 font-mono text-sm">
                                        Rp {{ number_format($kunjungan->total_bayar, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-8 py-16 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-file-invoice-dollar text-3xl text-gray-300"></i>
                                        </div>
                                        <h4 class="font-bold text-gray-500 text-lg mb-1">Data Kosong</h4>
                                        <p class="text-gray-400 text-sm">Belum ada transaksi selesai pada rentang tanggal yang dipilih.</p>
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