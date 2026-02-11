<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Kunjungan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-red-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="max-w-3xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-10">
                
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-red-50 text-red-500 mb-4 shadow-sm">
                        <i class="fas fa-file-pdf text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Cetak Laporan Kunjungan</h3>
                    <p class="text-sm text-gray-400">Pilih periode tanggal laporan yang ingin Anda cetak.</p>
                </div>

                <form action="{{ route('admin.laporan.cetak') }}" method="POST" target="_blank">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Mulai Dari Tanggal</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                                <input type="date" name="tgl_awal" 
                                    class="w-full pl-10 border-gray-300 rounded-xl shadow-sm focus:ring-red-500 focus:border-red-500 text-sm p-3 bg-gray-50/50" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Sampai Tanggal</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                                <input type="date" name="tgl_akhir" 
                                    class="w-full pl-10 border-gray-300 rounded-xl shadow-sm focus:ring-red-500 focus:border-red-500 text-sm p-3 bg-gray-50/50" required>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center border-t border-gray-100 pt-8">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-10 rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 flex items-center">
                            <i class="fas fa-print mr-3"></i> Cetak Laporan Sekarang
                        </button>
                        <p class="text-[11px] text-gray-400 mt-4 italic">Format laporan akan berupa file PDF.</p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>