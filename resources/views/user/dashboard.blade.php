<x-app-layout>
    <div class="py-12" x-data="{ showHistoryModal: false, showSpesialisModal: false, showDokterModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-gray-600">Selamat datang di Layanan Pasien Klinik Bina Usada.</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-bold text-xl mb-4 text-gray-800 flex items-center">
                    Informasi & Layanan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    
                    <div @click="showSpesialisModal = true" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition cursor-pointer group">
                        <div>
                            <div class="text-gray-500 text-sm font-bold uppercase tracking-wider group-hover:text-purple-600 transition">Poli / Spesialis</div>
                            <div class="text-3xl font-extrabold text-gray-800 mt-2">{{ $totalSpesialis }}</div>
                            <p class="text-xs text-gray-400 mt-1">Klik untuk lihat daftar</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-full text-purple-500 group-hover:bg-purple-100 transition">
                            <i class="fas fa-stethoscope text-3xl"></i>
                        </div>
                    </div>

                    <div @click="showDokterModal = true" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition cursor-pointer group">
                        <div>
                            <div class="text-gray-500 text-sm font-bold uppercase tracking-wider group-hover:text-green-600 transition">Total Dokter</div>
                            <div class="text-3xl font-extrabold text-gray-800 mt-2">{{ $totalDokter }}</div>
                            <p class="text-xs text-gray-400 mt-1">Klik untuk lihat data</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-full text-green-500 group-hover:bg-green-100 transition">
                            <i class="fas fa-user-doctor text-3xl"></i>
                        </div>
                    </div>

                    <div @click="showHistoryModal = true" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md hover:border-yellow-300 transition group cursor-pointer relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="text-yellow-600 text-sm font-bold uppercase tracking-wider group-hover:underline">History</div>
                            <div class="text-xl font-bold text-gray-800 mt-2">Riwayat Saya</div>
                            <p class="text-xs text-gray-400 mt-1">Klik untuk detail</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-full text-yellow-500 group-hover:scale-110 transition transform">
                            <i class="fas fa-history text-3xl"></i>
                        </div>
                    </div>

                    <a href="https://wa.me/6287750503953?text=Halo,%20saya%20ingin%20bertanya"
                        target="_blank"
                        class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition flex justify-between items-center group">
                            <div>
                                <div class="text-sm font-bold uppercase text-green-600">
                                    Call Center
                                </div>
                                <div class="text-xl font-bold text-gray-800 mt-2">
                                    WhatsApp
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Chat admin</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-full text-green-600 ml-4">
                                <i class="fab fa-whatsapp text-3xl"></i>
                            </div>
                    </a>
                </div>
            </div>

            <div id="area-reservasi" class="scroll-mt-24">
                <div class="mt-8 mb-4">
                    <h3 class="font-bold text-xl text-gray-800 flex items-center">
                        Jadwal Dokter Hari Ini
                    </h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($jadwals as $jadwal)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden flex flex-col">
                        <div class="p-6 flex-grow">
                            <div class="flex items-start mb-6">
                                <div class="bg-blue-50 p-3 rounded-xl text-blue-500 mr-4">
                                    <i class="fas fa-user-md text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-gray-900 leading-tight">{{ $jadwal->dokter->nama_lengkap }}</h4>
                                    <span class="inline-block text-blue-600 text-sm font-semibold mt-1">
                                        Spesialis {{ $jadwal->dokter->spesialis }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-xl p-4 space-y-3 text-sm text-gray-700 font-medium">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="far fa-calendar-alt mr-2"></i> Hari</span>
                                    <span class="font-bold">{{ $jadwal->hari }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="far fa-clock mr-2"></i> Jam</span>
                                    <span class="font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-md border border-green-200">
                                        {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('user.daftar', $jadwal->id) }}" class="bg-gray-50 border-t border-gray-100 p-4 text-center text-blue-600 font-bold text-sm hover:bg-blue-50 transition">
                            Klik untuk Reservasi <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-sm border-2 border-dashed border-gray-200 p-12 text-center">
                            <i class="fas fa-calendar-times text-5xl text-gray-300 mb-4"></i>
                            <h4 class="text-xl font-bold text-gray-800">Tidak Ada Jadwal</h4>
                            <p class="text-gray-500 mt-2">Maaf, tidak ada dokter yang praktek pada hari <strong>{{ $hariIni }}</strong>.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <div class="pb-20"></div>

            <div x-show="showSpesialisModal" 
            style="display: none;"
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"
                    @click="showSpesialisModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <!-- Modal -->
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    
                    <!-- Header -->
                    <div class="bg-purple-50 px-6 py-5 border-b border-purple-100 flex justify-between items-center">
                        <h3 class="text-xl font-extrabold text-gray-800 flex items-center">
                            <span class="bg-purple-100 text-purple-600 p-2 rounded-lg mr-3">
                                <i class="fas fa-stethoscope"></i>
                            </span>
                            Daftar Poli / Spesialis
                        </h3>
                        <button @click="showSpesialisModal = false" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-full p-2 transition">
                                <i class="fas fa-times"></i>
                            </button>
                    </div>

                    <!-- Content -->
                    <div class="p-6 bg-gray-50 max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            
                            @forelse($daftarSpesialis as $spesialis)
                            <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition duration-300 group">
                                <div class="flex items-center gap-4">
                                    
                                    <!-- Icon -->
                                    <div class="flex-shrink-0">
                                        <div class="w-16 h-16 rounded-full bg-purple-50 border-2 border-purple-100 text-purple-600 flex items-center justify-center text-2xl">
                                            <i class="fas fa-notes-medical"></i>
                                        </div>
                                    </div>

                                    <!-- Text -->
                                   <div class="flex-1">
                                        <div class="font-bold text-gray-800 text-lg group-hover:text-purple-600 transition capitalize">
                                            Spesialis {{ $spesialis }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-full text-center py-10">
                                <i class="fas fa-notes-medical text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">Belum ada data spesialis.</p>
                            </div>
                            @endforelse

                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-white px-6 py-3 border-t border-gray-100 text-right">
                        <p class="text-xs text-gray-400">
                            Total tersedia:
                            <strong class="text-purple-600">{{ count($daftarSpesialis) }} Layanan</strong>
                        </p>
                    </div>

                </div>
            </div>
        </div>

            <div x-show="showDokterModal" 
                 style="display: none;"
                 class="fixed inset-0 z-50 overflow-y-auto"
                 aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" @click="showDokterModal = false"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                        
                        <div class="bg-blue-50 px-6 py-5 border-b border-blue-100 flex justify-between items-center">
                            <h3 class="text-xl font-extrabold text-gray-800 flex items-center">
                                <span class="text-blue-600 p-2 rounded-lg mr-3">
                                    <i class="fas fa-user-doctor"></i>
                                </span>
                                Tim Dokter Kami
                            </h3>
                            <button @click="showDokterModal = false" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-full p-2 transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="p-6 bg-gray-50 max-h-[70vh] overflow-y-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                @forelse($daftarDokter as $dok)
                                <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition duration-300 relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-20 h-20 bg-blue-50 rounded-full opacity-50"></div>

                                    <div class="flex items-start gap-4 relative z-10">
                                        <div class="flex-shrink-0">
                                            <div class="w-16 h-16 rounded-full bg-white border-2 border-blue-100 text-blue-500 flex items-center justify-center text-2xl">
                                                <i class="fas fa-user-md"></i>
                                            </div>
                                        </div>

                                        <div class="flex-1 space-y-2 pt-1">
                                            <h4 class="font-bold text-gray-800 text-lg leading-tight group-hover:text-blue-600 transition">
                                                {{ $dok->nama_lengkap }}
                                            </h4>

                                            <div class="text-sm font-bold text-gray-700">
                                                Spesialis {{ $dok->spesialis }}
                                            </div>

                                            <div class="flex items-center text-gray-500 text-sm">
                                                <i class="fas fa-phone-alt text-gray-300 mr-2"></i>
                                                {{ $dok->no_telepon }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-span-full text-center py-10">
                                    <i class="fas fa-user-md text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500">Belum ada data dokter.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        
                        <div class="bg-white px-6 py-3 border-t border-gray-100 text-right">
                             <p class="text-xs text-gray-400">Total Dokter Aktif: <strong class="text-blue-600">{{ count($daftarDokter) }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="showHistoryModal" 
                 style="display: none;"
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" @click="showHistoryModal = false" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                        
                        <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                                <i class="fas fa-history mr-3 text-yellow-500"></i> Riwayat Kunjungan Saya
                            </h3>
                            <button @click="showHistoryModal = false" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-full p-2 transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="bg-gray-50 px-6 py-6 max-h-[70vh] overflow-y-auto">
                            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full table-auto">
                                        <thead class="bg-gray-50 border-b border-gray-100">
                                            <tr>
                                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Dokter</th>
                                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">No. Antrean</th>
                                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 bg-white">
                                            @forelse($riwayat as $r)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($r->tanggal_kunjungan)->format('d M Y') }}
                                                    <div class="text-xs text-gray-500 mt-1">Jam: {{ date('H:i', strtotime($r->jam_pilihan)) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    <div class="font-bold">{{ $r->dokter->nama_lengkap }}</div>
                                                    <div class="text-xs text-blue-600">{{ $r->dokter->spesialis }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-600 font-bold text-sm">
                                                        {{ $r->no_antrian }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase border bg-gray-50 text-gray-700">
                                                        {{ $r->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>