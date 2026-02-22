<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="far fa-calendar-check mr-2 text-fuchsia-600"></i> {{ __('Kelola Jadwal Dokter') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-fuchsia-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: { popup: 'rounded-2xl' }
                    });
                });
            </script>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-extrabold text-gray-900">Daftar Jadwal Praktek</h3>
                <a href="{{ route('admin.jadwal.create') }}" class="bg-fuchsia-600 hover:bg-fuchsia-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-fuchsia-200 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Jadwal
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-2xl border border-gray-100">
                <div class="p-0 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Nama Dokter</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Hari Praktek</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Jam Operasional</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($jadwals as $jadwal)
                            <tr class="hover:bg-slate-50 transition duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-fuchsia-50 text-fuchsia-500 flex items-center justify-center font-bold">
                                            <i class="fas fa-user-md"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $jadwal->dokter->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $jadwal->dokter->spesialis }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block bg-slate-100 text-slate-700 px-3 py-1 rounded-lg text-sm font-bold border border-slate-200 uppercase tracking-wider">
                                        {{ $jadwal->hari }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-fuchsia-700 bg-fuchsia-50 px-2 py-1 rounded border border-fuchsia-100"><i class="far fa-clock mr-1"></i>{{ date('H:i', strtotime($jadwal->jam_mulai)) }}</span>
                                        <span class="text-gray-400 font-bold">-</span>
                                        <span class="font-bold text-fuchsia-700 bg-fuchsia-50 px-2 py-1 rounded border border-fuchsia-100"><i class="far fa-clock mr-1"></i>{{ date('H:i', strtotime($jadwal->jam_selesai)) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center text-green-700 font-bold text-[10px] bg-green-50 border border-green-200 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span> Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="text-amber-500 hover:text-amber-700 font-bold px-3 py-1 bg-amber-50 border border-amber-200 rounded-lg transition uppercase text-xs">Edit</a>
                                        
                                        <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" id="delete-form-{{ $jadwal->id }}" class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="konfirmasiHapusJadwal('{{ $jadwal->id }}', '{{ $jadwal->dokter->nama_lengkap }}', '{{ $jadwal->hari }}')" class="text-red-500 hover:text-red-700 font-bold px-3 py-1 bg-red-50 border border-red-200 rounded-lg transition uppercase text-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="far fa-calendar-times text-4xl mb-3 text-gray-300"></i>
                                        <p>Belum ada jadwal praktek dokter yang terdaftar.</p>
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

    <script>
        function konfirmasiHapusJadwal(id, namaDokter, hari) {
            Swal.fire({
                title: 'Hapus Jadwal?',
                text: "Jadwal praktek " + namaDokter + " pada hari " + hari + " akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-6 py-2 font-bold',
                    cancelButton: 'rounded-xl px-6 py-2 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>