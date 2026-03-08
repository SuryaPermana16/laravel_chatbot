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

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gray-900 rounded-3xl shadow-lg border border-gray-800 p-6 flex flex-col justify-center relative overflow-hidden group transition duration-300">
                    <i class="fas fa-chart-line absolute -right-4 -bottom-4 text-7xl text-gray-800 opacity-50 pointer-events-none"></i>
                    <div class="relative z-10">
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Grand Total Omzet</p>
                        <h3 class="text-2xl lg:text-3xl font-black text-white">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-6 flex flex-col justify-center relative overflow-hidden group hover:border-emerald-200 transition duration-300">
                    <i class="fas fa-money-bill-wave absolute -right-4 -bottom-4 text-7xl text-emerald-50 opacity-50 group-hover:scale-110 transition duration-500 pointer-events-none"></i>
                    <div class="relative z-10">
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Pemasukan Tunai (Umum)</p>
                        <h3 class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalTunai, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-6 flex flex-col justify-center relative overflow-hidden group hover:border-blue-200 transition duration-300">
                    <i class="fas fa-shield-alt absolute -right-4 -bottom-4 text-7xl text-blue-50 opacity-50 group-hover:scale-110 transition duration-500 pointer-events-none"></i>
                    <div class="relative z-10">
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Piutang Klaim BPJS</p>
                        <h3 class="text-2xl font-black text-blue-600">Rp {{ number_format($totalKlaimBpjs, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-6 flex flex-col justify-center relative overflow-hidden group hover:border-purple-200 transition duration-300">
                    <i class="fas fa-users absolute -right-4 -bottom-4 text-7xl text-purple-50 opacity-50 group-hover:scale-110 transition duration-500 pointer-events-none"></i>
                    <div class="relative z-10">
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Total Pasien Selesai</p>
                        <h3 class="text-2xl lg:text-3xl font-black text-gray-900">{{ $kunjungans->count() }} <span class="text-sm font-bold text-gray-400">Orang</span></h3>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                <div class="px-8 py-6 border-b border-gray-100 bg-white flex justify-between items-center">
                    <h3 class="font-extrabold text-lg text-gray-900"><i class="fas fa-list-ul mr-2 text-gray-400"></i> Rincian Transaksi</h3>
                    <span class="text-xs font-bold bg-gray-100 text-gray-500 px-3 py-1 rounded-full border border-gray-200 uppercase tracking-wider">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
                </div>
                
                <div class="overflow-x-auto p-0">
                    <table class="min-w-full table-auto text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-bold border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-4 uppercase text-xs tracking-wider">Tanggal</th>
                                <th class="px-8 py-4 uppercase text-xs tracking-wider">Pasien / Dokter</th>
                                <th class="px-8 py-4 uppercase text-xs tracking-wider text-right">Rincian Biaya (Asli)</th>
                                <th class="px-8 py-4 uppercase text-xs tracking-wider text-center">Metode / Status</th>
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
                                    <div class="text-xs font-medium text-gray-500 mt-0.5">Dr. {{ $kunjungan->dokter->nama_lengkap }}</div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="text-[11px] font-mono text-gray-500">Jasa: Rp {{ number_format($kunjungan->biaya_jasa_dokter, 0, ',', '.') }}</div>
                                    <div class="text-[11px] font-mono text-gray-500">Obat: Rp {{ number_format($kunjungan->biaya_obat, 0, ',', '.') }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 border-t border-gray-200 mt-1 pt-1">(Asli: Rp {{ number_format($kunjungan->biaya_jasa_dokter + $kunjungan->biaya_obat, 0, ',', '.') }})</div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($kunjungan->status_pembayaran == 'Klaim BPJS')
                                        <span class="inline-flex items-center bg-teal-50 text-teal-700 text-xs font-bold px-3 py-1 rounded-full border border-teal-200 uppercase tracking-wide">
                                            <i class="fas fa-shield-alt mr-1.5"></i> BPJS
                                        </span>
                                    @else
                                        <span class="inline-flex items-center bg-emerald-50 text-emerald-600 text-xs font-bold px-3 py-1 rounded-full border border-emerald-200 uppercase tracking-wide">
                                            <i class="fas fa-money-bill-wave mr-1.5"></i> UMUM
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @if($kunjungan->status_pembayaran == 'Klaim BPJS')
                                        <span class="font-black text-emerald-600 text-lg">Rp 0</span>
                                    @else
                                        <span class="font-black text-gray-900 text-lg">Rp {{ number_format($kunjungan->total_bayar, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center text-gray-400">
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