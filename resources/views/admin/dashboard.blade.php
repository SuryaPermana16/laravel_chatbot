<x-app-layout>
    <div class="py-8 md:py-12 text-left bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-gradient-to-r from-slate-800 to-slate-700 rounded-3xl p-8 mb-8 shadow-xl shadow-slate-200 relative overflow-hidden text-white">
                <div class="absolute -right-10 -top-10 opacity-10">
                    <i class="fas fa-user-shield text-9xl"></i>
                </div>
                
                <div class="flex flex-col md:flex-row md:justify-between md:items-center relative z-10 gap-4">
                    <div>
                        <div class="inline-flex items-center px-3 py-1.5 bg-white/10 text-slate-100 text-xs font-bold rounded-full uppercase tracking-wider mb-4 border border-white/20 backdrop-blur-sm">
                            <i class="fas fa-server mr-2"></i> Administrator Panel
                        </div>
                        <h2 class="text-3xl font-extrabold mb-1">Halo, {{ Auth::user()->name }}! 👋</h2>
                        <p class="text-slate-300 font-medium text-sm md:text-base">Berikut adalah laporan ringkas kondisi Klinik Bina Usada hari ini.</p>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-100 bg-white/10 border border-white/20 backdrop-blur-md px-6 py-4 rounded-2xl font-bold shadow-sm w-fit">
                        <i class="far fa-calendar-check text-2xl text-slate-300"></i> 
                        <div>
                            <div class="text-[10px] text-slate-300 uppercase tracking-wider font-bold">Hari Ini</div>
                            <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex items-center justify-between group hover:-translate-y-1 transition duration-300">
                    <div>
                        <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Pasien</div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $total_pasien }}</div>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                        <i class="fas fa-hospital-user"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex items-center justify-between group hover:-translate-y-1 transition duration-300">
                    <div>
                        <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Dokter Aktif</div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $total_dokter }}</div>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-2xl group-hover:bg-green-600 group-hover:text-white transition duration-300">
                        <i class="fas fa-user-md"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex items-center justify-between group hover:-translate-y-1 transition duration-300">
                    <div>
                        <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Jenis Obat</div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $total_obat }}</div>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl group-hover:bg-amber-500 group-hover:text-white transition duration-300">
                        <i class="fas fa-pills"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex items-center justify-between group hover:-translate-y-1 transition duration-300">
                    <div>
                        <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Jadwal Praktek</div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $total_jadwal }}</div>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4 mb-8 mt-6">
                <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-slate-200">
                    <i class="fas fa-border-all text-xl"></i>
                </div>
                <h3 class="font-extrabold text-2xl text-gray-900 tracking-tight">Menu Navigasi Cepat</h3>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <a href="{{ route('admin.kelola-admin.index') }}" class="group bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-slate-400 hover:shadow-lg transition duration-300 block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center text-xl group-hover:scale-110 transition duration-300">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-slate-600 transition -translate-x-2 opacity-0 group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">Kelola Admin</h4>
                    <p class="text-xs text-gray-500 font-medium">Tambah & kelola akun admin</p>
                </a>

                <a href="{{ route('admin.apoteker.index') }}" class="group bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-teal-400 hover:shadow-lg transition duration-300 block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl group-hover:scale-110 transition duration-300">
                            <i class="fas fa-user-nurse"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-teal-600 transition -translate-x-2 opacity-0 group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">Kelola Apoteker</h4>
                    <p class="text-xs text-gray-500 font-medium">Data & profil apoteker</p>
                </a>

                <a href="{{ route('admin.dokter.index') }}" class="group bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-green-400 hover:shadow-lg transition duration-300 block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl group-hover:scale-110 transition duration-300">
                            <i class="fas fa-user-doctor"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-green-600 transition -translate-x-2 opacity-0 group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">Kelola Dokter</h4>
                    <p class="text-xs text-gray-500 font-medium">Informasi dokter & tarif poli</p>
                </a>

                <a href="{{ route('admin.pasien.index') }}" class="group bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-indigo-400 hover:shadow-lg transition duration-300 block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl group-hover:scale-110 transition duration-300">
                            <i class="fas fa-hospital-user"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-indigo-600 transition -translate-x-2 opacity-0 group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">Data Pasien</h4>
                    <p class="text-xs text-gray-500 font-medium">Profil & riwayat rekam medis</p>
                </a>

                <a href="{{ route('admin.obat.index') }}" class="group bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-blue-400 hover:shadow-lg transition duration-300 block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:scale-110 transition duration-300">
                            <i class="fas fa-capsules"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-blue-600 transition -translate-x-2 opacity-0 group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">Kelola Obat</h4>
                    <p class="text-xs text-gray-500 font-medium">Inventaris stok & harga obat</p>
                </a>

                <a href="{{ route('admin.jadwal.index') }}" class="group bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-purple-400 hover:shadow-lg transition duration-300 block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl group-hover:scale-110 transition duration-300">
                            <i class="far fa-calendar-check"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-purple-600 transition -translate-x-2 opacity-0 group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">Jadwal Praktek</h4>
                    <p class="text-xs text-gray-500 font-medium">Atur jam operasional dokter</p>
                </a>

                <a href="{{ route('admin.kunjungan.index') }}" class="group bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-pink-400 hover:shadow-lg transition duration-300 block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-xl group-hover:scale-110 transition duration-300">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-pink-600 transition -translate-x-2 opacity-0 group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">Antrean Pasien</h4>
                    <p class="text-xs text-gray-500 font-medium">Pantau status kunjungan harian</p>
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="group bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-red-400 hover:shadow-lg transition duration-300 block">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl group-hover:scale-110 transition duration-300">
                            <i class="far fa-file-pdf"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-red-600 transition -translate-x-2 opacity-0 group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">Laporan Klinik</h4>
                    <p class="text-xs text-gray-500 font-medium">Cetak PDF riwayat & transaksi</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>