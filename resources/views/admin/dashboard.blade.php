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
                    <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                        <i class="far fa-calendar-alt mr-1"></i> {{ now()->format('l, d F Y') }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
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

            <h3 class="font-bold text-lg mb-4 text-gray-700 flex items-center"><i class="fas fa-th-large mr-2 text-blue-600"></i> Menu Cepat</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <a href="{{ route('admin.kelola-admin.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-gray-500 transition group">
                    <div class="text-gray-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-shield text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Kelola Admin</h4>
                    <p class="text-sm text-gray-500 mt-1">Tambah akun admin baru</p>
                </a>

                <a href="{{ route('admin.apoteker.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-teal-500 transition group">
                    <div class="text-teal-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-nurse text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Kelola Apoteker</h4>
                    <p class="text-sm text-gray-500 mt-1">Data & Akun Apoteker</p>
                </a>

                <a href="{{ route('admin.dokter.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-green-500 transition group">
                    <div class="text-green-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-doctor text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Kelola Dokter</h4>
                    <p class="text-sm text-gray-500 mt-1">Data Dokter & Tarif</p>
                </a>

                <a href="{{ route('admin.pasien.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-indigo-500 transition group">
                    <div class="text-indigo-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-hospital-user text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Data Pasien</h4>
                    <p class="text-sm text-gray-500 mt-1">Rekam Medis & Profil</p>
                </a>

                <a href="{{ route('admin.obat.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-blue-500 transition group">
                    <div class="text-blue-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-capsules text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Kelola Obat</h4>
                    <p class="text-sm text-gray-500 mt-1">Stok & Harga Obat</p>
                </a>

                <a href="{{ route('admin.jadwal.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-purple-500 transition group">
                    <div class="text-purple-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar-check text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Jadwal Praktek</h4>
                    <p class="text-sm text-gray-500 mt-1">Atur Jam Kerja Dokter</p>
                </a>

                <a href="{{ route('admin.kunjungan.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-teal-500 transition group">
                    <div class="text-teal-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-clipboard-list text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Antrean Pasien</h4>
                    <p class="text-sm text-gray-500 mt-1">Pantau kunjungan hari ini</p>
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="block bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-red-500 transition group h-full">
                    <div class="text-red-600 mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-pdf text-3xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Laporan</h4>
                    <p class="text-sm text-gray-500 mt-1">Cetak Data Kunjungan</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>