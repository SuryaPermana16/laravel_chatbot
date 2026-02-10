<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Kunjungan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="max-w-lg mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-8">
                
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-50 text-red-500 mb-3">
                        <i class="fas fa-file-pdf text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Cetak Laporan</h3>
                    <p class="text-xs text-gray-500">Pilih periode tanggal laporan.</p>
                </div>

                <form action="{{ route('admin.laporan.cetak') }}" method="POST" target="_blank">
                    @csrf
                    
                    <div class="space-y-4 mb-8">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wider">Dari Tanggal</label>
                            <input type="date" name="tgl_awal" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm p-2.5" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wider">Sampai Tanggal</label>
                            <input type="date" name="tgl_akhir" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm p-2.5" required>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="bg-white text-red-600 border-2 border-red-600 w-16 h-16 rounded-full hover:bg-red-50 transition transform hover:scale-110 flex items-center justify-center shadow-sm" title="Cetak PDF">
                            <i class="fas fa-print text-3xl"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>