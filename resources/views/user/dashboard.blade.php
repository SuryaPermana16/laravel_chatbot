<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    confirmButtonColor: '#2563eb',
                    customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl px-6 py-2 font-bold' }
                });
            });
        </script>
    @endif

    <div class="py-8 md:py-12 bg-slate-50 min-h-screen" x-data="{ showHistoryModal: false, showSpesialisModal: false, showDokterModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 rounded-[2rem] p-8 md:p-10 shadow-lg shadow-blue-200 relative overflow-hidden text-white">
                <div class="absolute -right-10 -top-10 opacity-10 pointer-events-none">
                    <i class="fas fa-heartbeat text-9xl"></i>
                </div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:justify-between md:items-center gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/20 text-blue-50 text-xs font-bold rounded-full uppercase tracking-wider mb-4 backdrop-blur-sm border border-white/20">
                            <i class="fas fa-hospital-user"></i> Portal Pasien
                        </div>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
                        <p class="text-blue-100 font-medium text-base max-w-xl">Selamat datang di Layanan Digital Klinik Bina Usada. Pantau riwayat kesehatan dan buat janji temu dokter dengan lebih mudah.</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 px-6 py-4 rounded-2xl font-bold shadow-sm flex items-center gap-3 w-fit">
                        <i class="far fa-calendar-alt text-2xl text-blue-200"></i> 
                        <div>
                            <div class="text-[10px] text-blue-200 uppercase tracking-wider">Hari Ini</div>
                            <div class="text-sm">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-extrabold text-xl mb-4 text-gray-900 flex items-center gap-2">
                    <i class="fas fa-th-large text-blue-500"></i> Layanan Informasi
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    
                    <div @click="showSpesialisModal = true" class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col items-start hover:-translate-y-1 hover:shadow-lg transition duration-300 cursor-pointer group">
                        <div class="bg-purple-50 p-4 rounded-2xl text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition duration-300 mb-4">
                            <i class="fas fa-stethoscope text-2xl"></i>
                        </div>
                        <div class="text-3xl font-black text-gray-800 mb-1">{{ $totalSpesialis }} <span class="text-sm font-bold text-gray-400">Poli</span></div>
                        <div class="text-gray-500 text-sm font-bold">Daftar Spesialis</div>
                    </div>

                    <div @click="showDokterModal = true" class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col items-start hover:-translate-y-1 hover:shadow-lg transition duration-300 cursor-pointer group">
                        <div class="bg-emerald-50 p-4 rounded-2xl text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition duration-300 mb-4">
                            <i class="fas fa-user-md text-2xl"></i>
                        </div>
                        <div class="text-3xl font-black text-gray-800 mb-1">{{ $totalDokter }} <span class="text-sm font-bold text-gray-400">Dokter</span></div>
                        <div class="text-gray-500 text-sm font-bold">Tenaga Medis Kami</div>
                    </div>

                    <div @click="showHistoryModal = true" class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col items-start hover:-translate-y-1 hover:shadow-lg transition duration-300 cursor-pointer group">
                        <div class="bg-amber-50 p-4 rounded-2xl text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition duration-300 mb-4">
                            <i class="fas fa-notes-medical text-2xl"></i>
                        </div>
                        <div class="text-xl font-black text-gray-800 mb-1 mt-2">Rekam Medis</div>
                        <div class="text-gray-500 text-sm font-bold">Riwayat Kunjungan Saya</div>
                    </div>

                    <a href="https://wa.me/6287750503953?text=Halo,%20Klinik%20Bina%20Usada.%20Saya%20ingin%20bertanya" target="_blank" class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col items-start hover:-translate-y-1 hover:shadow-lg transition duration-300 cursor-pointer group">
                        <div class="bg-green-50 p-4 rounded-2xl text-green-500 group-hover:bg-green-500 group-hover:text-white transition duration-300 mb-4">
                            <i class="fab fa-whatsapp text-2xl"></i>
                        </div>
                        <div class="text-xl font-black text-gray-800 mb-1 mt-2">Hubungi Admin</div>
                        <div class="text-gray-500 text-sm font-bold">Bantuan & Call Center</div>
                    </a>
                </div>
            </div>

            <div id="area-reservasi" class="scroll-mt-24">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-6 gap-2">
                    <h3 class="font-extrabold text-2xl text-gray-900 flex items-center gap-3">
                        Buat Janji Temu Hari Ini
                    </h3>
                    <span class="text-sm font-medium text-gray-500 bg-white border border-gray-200 px-4 py-1.5 rounded-full shadow-sm">
                        <i class="fas fa-circle text-[8px] text-green-500 mr-1 animate-pulse"></i> Jadwal Tersedia
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($jadwals as $jadwal)
                    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-blue-300 transition duration-300 overflow-hidden flex flex-col group relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-blue-100 group-hover:bg-blue-600 transition duration-300"></div>
                        <div class="p-6 md:p-8 flex-grow">
                            <div class="flex items-center gap-4 mb-6 border-b border-gray-50 pb-5">
                                <div class="w-16 h-16 bg-blue-50 border-2 border-blue-100 rounded-2xl text-blue-500 flex items-center justify-center text-3xl shadow-inner group-hover:scale-110 transition duration-300">
                                    {{ strtoupper(substr($jadwal->dokter->nama_lengkap, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-gray-900 leading-tight">{{ $jadwal->dokter->nama_lengkap }}</h4>
                                    <span class="inline-block bg-blue-50 text-blue-600 text-[10px] font-extrabold px-2.5 py-1 rounded-md mt-1.5 uppercase tracking-wider">Poli {{ $jadwal->dokter->spesialis }}</span>
                                </div>
                            </div>
                            <div class="bg-slate-50 rounded-2xl p-5 space-y-3 text-sm text-gray-700 font-medium">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-xs uppercase font-bold tracking-wider"><i class="far fa-calendar-alt mr-1"></i> Hari</span>
                                    <span class="font-bold text-gray-900">{{ $jadwal->hari }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-xs uppercase font-bold tracking-wider"><i class="far fa-clock mr-1"></i> Jam</span>
                                    <span class="font-bold text-gray-900">{{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{ route('user.daftar', $jadwal->id) }}" class="block w-full bg-gray-900 hover:bg-blue-600 text-white text-center font-bold py-3.5 rounded-xl transition duration-300 shadow-md">
                                Reservasi Sekarang <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center">
                            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl text-gray-300">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <h4 class="text-xl font-extrabold text-gray-800">Tidak Ada Jadwal Praktek</h4>
                            <p class="text-gray-500 mt-2">Maaf, belum ada dokter yang membuka jadwal praktek untuk hari <strong>{{ $hariIni }}</strong>.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="pb-10"></div>


            <div x-show="showSpesialisModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" x-show="showSpesialisModal" x-transition.opacity @click="showSpesialisModal = false"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                    
                    <div class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full"
                         x-show="showSpesialisModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div class="bg-gradient-to-r from-purple-700 to-purple-500 px-8 py-6 flex justify-between items-center">
                            <h3 class="text-xl font-extrabold text-white flex items-center"><i class="fas fa-stethoscope mr-3 opacity-80"></i> Daftar Layanan Poli</h3>
                            <button @click="showSpesialisModal = false" class="text-white hover:text-red-300 transition w-8 h-8 flex items-center justify-center bg-white/20 rounded-full"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="p-8 bg-slate-50 max-h-[60vh] overflow-y-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse($daftarSpesialis as $spesialis)
                                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-5 group">
                                    <div class="w-14 h-14 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-2xl group-hover:bg-purple-600 group-hover:text-white transition"><i class="fas fa-briefcase-medical"></i></div>
                                    <div class="font-bold text-gray-800 text-lg uppercase tracking-wide">Poli {{ $spesialis }}</div>
                                </div>
                                @empty
                                <div class="col-span-full text-center py-10 text-gray-400">Belum ada data layanan spesialis.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="showDokterModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" x-show="showDokterModal" x-transition.opacity @click="showDokterModal = false"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                    
                    <div class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full"
                         x-show="showDokterModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div class="bg-gradient-to-r from-emerald-600 to-teal-500 px-8 py-6 flex justify-between items-center">
                            <h3 class="text-xl font-extrabold text-white flex items-center"><i class="fas fa-user-md mr-3 opacity-80"></i> Direktori Tim Medis</h3>
                            <button @click="showDokterModal = false" class="text-white hover:text-red-300 transition w-8 h-8 flex items-center justify-center bg-white/20 rounded-full"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="p-8 bg-slate-50 max-h-[60vh] overflow-y-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                @forelse($daftarDokter as $dok)
                                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-5 relative overflow-hidden group">
                                    <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-emerald-50 rounded-full opacity-50 group-hover:scale-150 transition duration-500"></div>
                                    <div class="relative z-10 w-16 h-16 rounded-full bg-gray-100 border-2 border-emerald-100 text-gray-400 flex items-center justify-center text-3xl overflow-hidden">
                                        <i class="fas fa-user-md mt-2"></i>
                                    </div>
                                    <div class="relative z-10 flex-1">
                                        <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $dok->nama_lengkap }}</h4>
                                        <div class="text-[10px] font-extrabold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded uppercase tracking-wider inline-block mt-1 mb-1">Poli {{ $dok->spesialis }}</div>
                                        <div class="text-xs font-medium text-gray-500"><i class="fas fa-phone-alt mr-1 opacity-50"></i> {{ $dok->no_telepon }}</div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-span-full text-center py-10 text-gray-400">Belum ada data dokter.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="showHistoryModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" x-show="showHistoryModal" x-transition.opacity @click="showHistoryModal = false"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                    
                    <div class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full"
                         x-show="showHistoryModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div class="bg-gray-900 px-8 py-6 flex justify-between items-center">
                            <h3 class="text-xl font-extrabold text-white flex items-center"><i class="fas fa-history mr-3 text-amber-400"></i> Rekam Medis & Riwayat Saya</h3>
                            <button @click="showHistoryModal = false" class="text-gray-300 hover:text-white transition w-8 h-8 flex items-center justify-center bg-gray-800 rounded-full"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="p-0 bg-white max-h-[70vh] overflow-y-auto">
                            <table class="min-w-full table-auto text-left">
                                <thead class="bg-gray-50 border-b border-gray-100 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Waktu Kunjungan</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Dokter Tujuan</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-24">Nomor</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($riwayat as $r)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($r->tanggal_kunjungan)->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5"><i class="far fa-clock mr-1"></i> {{ date('H:i', strtotime($r->jam_pilihan)) }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $r->dokter->nama_lengkap }}</div>
                                            <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Poli {{ $r->dokter->spesialis }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-block bg-gray-900 text-white font-bold text-sm px-3 py-1 rounded-lg">{{ $r->no_antrian }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $colors = [
                                                    'menunggu'  => 'bg-yellow-50 text-yellow-600 border-yellow-200',
                                                    'diperiksa' => 'bg-blue-50 text-blue-600 border-blue-200',
                                                    'periksa'   => 'bg-blue-50 text-blue-600 border-blue-200',
                                                    'selesai'   => 'bg-purple-50 text-purple-600 border-purple-200',
                                                    'diambil'   => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                                    'batal'     => 'bg-red-50 text-red-600 border-red-200'
                                                ];
                                            @endphp
                                            <span class="inline-block px-3 py-1 rounded-full text-[10px] font-extrabold uppercase border {{ $colors[$r->status] ?? 'bg-gray-100' }}">
                                                @if($r->status == 'diambil') ✅ SELESAI
                                                @elseif($r->status == 'selesai') 💊 TUNGGU OBAT
                                                @else {{ $r->status }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto text-2xl text-gray-300 mb-3"><i class="fas fa-folder-open"></i></div>
                                            <p class="text-gray-500 font-medium">Anda belum memiliki riwayat kunjungan.</p>
                                        </td>
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
</x-app-layout>