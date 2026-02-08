<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Selamat Datang, Administrator! 👋</h3>
                    <p class="text-gray-600">Berikut adalah laporan ringkas kondisi klinik hari ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md">
                    <div class="text-2xl font-bold">{{ $total_pasien }}</div>
                    <div class="text-sm opacity-80">Total Pasien Terdaftar</div>
                </div>

                <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
                    <div class="text-2xl font-bold">{{ $total_dokter }}</div>
                    <div class="text-sm opacity-80">Dokter Aktif</div>
                </div>

                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md">
                    <div class="text-2xl font-bold">{{ $total_obat }}</div>
                    <div class="text-sm opacity-80">Jenis Obat di Gudang</div>
                </div>

                <div class="bg-purple-500 text-white p-4 rounded-lg shadow-md">
                    <div class="text-2xl font-bold">{{ $kunjungan_hari_ini }}</div>
                    <div class="text-sm opacity-80">Pasien Hari Ini</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.obat.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="text-blue-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Kelola Obat</h4>
                    <p class="text-sm text-gray-500 mt-1">Tambah stok & update harga obat.</p>
                </a>

                <a href="#" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition opacity-50 cursor-not-allowed">
                    <div class="text-green-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Kelola Dokter</h4>
                    <p class="text-sm text-gray-500 mt-1">Atur jadwal & data dokter. (Segera)</p>
                </a>

                </div>

        </div>
    </div>
</x-app-layout>