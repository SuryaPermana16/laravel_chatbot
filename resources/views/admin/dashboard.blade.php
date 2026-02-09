<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Selamat Datang, Administrator! 👋</h3>
                        <p class="text-gray-600">Berikut adalah laporan ringkas kondisi klinik hari ini.</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ now()->format('l, d F Y') }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <div class="text-3xl font-bold">{{ $total_pasien }}</div>
                        <div class="text-sm opacity-90">Pasien Terdaftar</div>
                    </div>
                    <i class="fas fa-users text-4xl opacity-50"></i>
                </div>

                <div class="bg-green-500 text-white p-4 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <div class="text-3xl font-bold">{{ $total_dokter }}</div>
                        <div class="text-sm opacity-90">Dokter Aktif</div>
                    </div>
                    <i class="fas fa-user-md text-4xl opacity-50"></i>
                </div>

                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <div class="text-3xl font-bold">{{ $total_obat }}</div>
                        <div class="text-sm opacity-90">Jenis Obat</div>
                    </div>
                    <i class="fas fa-pills text-4xl opacity-50"></i>
                </div>

                <div class="bg-purple-500 text-white p-4 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <div class="text-3xl font-bold">{{ $total_jadwal }}</div>
                        <div class="text-sm opacity-90">Jadwal Praktek</div>
                    </div>
                    <i class="fas fa-calendar-alt text-4xl opacity-50"></i>
                </div>
            </div>

            <h3 class="font-bold text-lg mb-4 text-gray-700">Menu Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <a href="{{ route('admin.obat.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-blue-500 transition group">
                    <div class="text-blue-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-capsules text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Kelola Obat</h4>
                    <p class="text-sm text-gray-500 mt-1">Stok & Harga Obat</p>
                </a>

                <a href="{{ route('admin.dokter.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-green-500 transition group">
                    <div class="text-green-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-doctor text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Kelola Dokter</h4>
                    <p class="text-sm text-gray-500 mt-1">Data Dokter & Spesialis</p>
                </a>

                <a href="{{ route('admin.pasien.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-indigo-500 transition group">
                    <div class="text-indigo-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-hospital-user text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Data Pasien</h4>
                    <p class="text-sm text-gray-500 mt-1">Rekam Medis & Profil</p>
                </a>

                <a href="{{ route('admin.jadwal.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-purple-500 transition group">
                    <div class="text-purple-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar-check text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Jadwal Praktek</h4>
                    <p class="text-sm text-gray-500 mt-1">Atur Jam Kerja Dokter</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>