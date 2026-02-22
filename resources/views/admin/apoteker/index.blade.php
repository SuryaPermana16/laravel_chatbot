<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-user-nurse mr-2 text-teal-600"></i> {{ __('Data Apoteker') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-teal-600 font-bold transition">
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
                <h3 class="text-xl font-extrabold text-gray-900">Daftar Apoteker</h3>
                <a href="{{ route('admin.apoteker.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-teal-200 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Apoteker
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-2xl border border-gray-100">
                <div class="p-0 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Nama Apoteker</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Kontak & Info</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($apotekers as $apoteker)
                            <tr class="hover:bg-slate-50 transition duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center font-bold">
                                            <i class="fas fa-user-nurse"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $apoteker->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $apoteker->user->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-700 font-medium mb-1"><i class="fas fa-phone-alt text-teal-400 mr-2 w-4"></i>{{ $apoteker->no_telepon ?? '-' }}</div>
                                    <div class="text-xs text-gray-500"><i class="fas fa-map-marker-alt text-gray-400 mr-2 w-4"></i>{{ \Illuminate\Support\Str::limit($apoteker->alamat ?? '-', 40) }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('admin.apoteker.edit', $apoteker->id) }}" class="text-amber-500 hover:text-amber-700 font-bold px-3 py-1 bg-amber-50 border border-amber-200 rounded-lg transition uppercase text-xs">Edit</a>
                                        
                                        <form action="{{ route('admin.apoteker.destroy', $apoteker->id) }}" method="POST" id="delete-form-{{ $apoteker->id }}" class="inline-block">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="button" onclick="hapusApoteker('{{ $apoteker->id }}', '{{ $apoteker->nama_lengkap }}')" class="text-red-500 hover:text-red-700 font-bold px-3 py-1 bg-red-50 border border-red-200 rounded-lg transition uppercase text-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-400">Belum ada data Apoteker.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        function hapusApoteker(id, nama) {
            Swal.fire({
                title: 'Hapus Apoteker?',
                text: "Data " + nama + " beserta akun loginnya akan dihapus permanen!",
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