<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-doctor mr-2 text-emerald-600"></i> {{ __('Data Dokter') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-emerald-600 font-bold transition">
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
                <h3 class="text-xl font-extrabold text-gray-900">Daftar Dokter Praktek</h3>
                <a href="{{ route('admin.dokter.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-emerald-200 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Dokter
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-2xl border border-gray-100">
                <div class="p-0 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Nama Dokter</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Spesialis & Tarif</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Kontak & Login</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($dokters as $dokter)
                            <tr class="hover:bg-slate-50 transition duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                                            <i class="fas fa-stethoscope"></i>
                                        </div>
                                        <div class="font-bold text-gray-800">{{ $dokter->nama_lengkap }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-emerald-600 mb-1 uppercase text-xs tracking-wider">{{ $dokter->spesialis }}</div>
                                    <div class="text-sm font-semibold text-gray-700 bg-gray-100 inline-block px-2 py-0.5 rounded border border-gray-200">
                                        Rp {{ number_format($dokter->harga_jasa, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-700 font-medium mb-1"><i class="fas fa-phone-alt text-gray-400 mr-2 w-4"></i>{{ $dokter->no_telepon }}</div>
                                    <div class="text-xs text-gray-500"><i class="far fa-envelope text-gray-400 mr-2 w-4"></i>{{ $dokter->user->email ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="text-amber-500 hover:text-amber-700 font-bold px-3 py-1 bg-amber-50 border border-amber-200 rounded-lg transition uppercase text-xs">Edit</a>

                                        <form action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST" id="delete-form-{{ $dokter->id }}" class="inline-block">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="button" onclick="konfirmasiHapus('{{ $dokter->id }}', '{{ $dokter->nama_lengkap }}')" class="text-red-500 hover:text-red-700 font-bold px-3 py-1 bg-red-50 border border-red-200 rounded-lg transition uppercase text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function konfirmasiHapus(id, nama) {
            Swal.fire({
                title: 'Hapus Data Dokter?',
                text: "Dokter " + nama + " beserta akun loginnya akan dihapus permanen!",
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