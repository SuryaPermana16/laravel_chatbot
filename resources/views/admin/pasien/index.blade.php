<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-hospital-user mr-2 text-indigo-600"></i> {{ __('Data Pasien') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 font-bold transition">
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
                <h3 class="text-xl font-extrabold text-gray-900">Daftar Pasien Terdaftar</h3>
                <a href="{{ route('admin.pasien.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i> Pasien Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-2xl border border-gray-100">
                <div class="p-0 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Profil Pasien</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-center">L/P & Usia</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Kontak & Akun</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($pasiens as $p)
                            <tr class="hover:bg-slate-50 transition duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full {{ $p->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }} flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div class="font-bold text-gray-800">{{ $p->nama_lengkap }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center justify-center gap-1">
                                        @if($p->jenis_kelamin == 'L')
                                            <span class="bg-blue-50 text-blue-600 px-3 py-0.5 rounded-md text-xs font-bold border border-blue-200">Laki-laki</span>
                                        @else
                                            <span class="bg-pink-50 text-pink-600 px-3 py-0.5 rounded-md text-xs font-bold border border-pink-200">Perempuan</span>
                                        @endif
                                        <span class="text-xs font-medium text-gray-500">{{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} Thn</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-700 font-medium mb-1"><i class="fas fa-phone-alt text-gray-400 mr-2 w-4"></i>{{ $p->no_telepon }}</div>
                                    <div class="text-xs text-gray-500"><i class="far fa-envelope text-gray-400 mr-2 w-4"></i>{{ $p->user->email ?? '- Tidak ada -' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('admin.pasien.show', $p->id) }}" class="text-indigo-600 hover:text-indigo-800 font-bold px-3 py-1 bg-indigo-50 border border-indigo-200 rounded-lg transition uppercase text-xs" title="Lihat Rekam Medis">Rekam Medis</a>
                                        <a href="{{ route('admin.pasien.edit', $p->id) }}" class="text-amber-500 hover:text-amber-700 font-bold px-3 py-1 bg-amber-50 border border-amber-200 rounded-lg transition uppercase text-xs">Edit</a>
                                        
                                        <form action="{{ route('admin.pasien.destroy', $p->id) }}" method="POST" id="delete-form-{{ $p->id }}" class="inline-block">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="button" onclick="konfirmasiHapusPasien('{{ $p->id }}', '{{ $p->nama_lengkap }}')" class="text-red-500 hover:text-red-700 font-bold px-3 py-1 bg-red-50 border border-red-200 rounded-lg transition uppercase text-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada data pasien terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function konfirmasiHapusPasien(id, nama) {
            Swal.fire({
                title: 'Hapus Data Pasien?',
                text: "Pasien " + nama + " akan dihapus permanen. Seluruh riwayat rekam medisnya juga akan hilang!",
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