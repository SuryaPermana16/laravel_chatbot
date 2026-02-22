<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-boxes mr-2 text-teal-600"></i> {{ __('Katalog & Stok Obat') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('apoteker.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-teal-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: { popup: 'rounded-2xl' }
                    });
                });
            </script>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-extrabold text-gray-900">Manajemen Inventaris Obat</h3>
                <a href="{{ route('apoteker.obat.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-teal-200 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Obat Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                <div class="p-0 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Nama Obat</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider">Harga Jual</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-center">Stok & Satuan</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($obats as $obat)
                            <tr class="hover:bg-slate-50 transition duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-teal-50 text-teal-500 flex items-center justify-center font-bold">
                                            <i class="fas fa-pills"></i>
                                        </div>
                                        <div class="font-extrabold text-gray-800">{{ $obat->nama_obat }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-md border border-emerald-100">
                                        Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        @if($obat->stok < 10)
                                            <span class="font-extrabold text-red-600 bg-red-50 px-2 py-0.5 rounded border border-red-200 animate-pulse" title="Stok Menipis!">{{ $obat->stok }}</span>
                                        @else
                                            <span class="font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded border border-gray-200">{{ $obat->stok }}</span>
                                        @endif
                                        <span class="text-xs text-gray-500 font-medium">{{ $obat->satuan }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('apoteker.obat.edit', $obat->id) }}" class="text-amber-500 hover:text-amber-700 font-bold px-3 py-1 bg-amber-50 border border-amber-200 rounded-lg transition uppercase text-xs">Edit</a>
                                        
                                        <form id="delete-form-{{ $obat->id }}" action="{{ route('apoteker.obat.destroy', $obat->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="konfirmasiHapus('{{ $obat->id }}', '{{ $obat->nama_obat }}')" class="text-red-500 hover:text-red-700 font-bold px-3 py-1 bg-red-50 border border-red-200 rounded-lg transition uppercase text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-box-open text-4xl mb-3 text-gray-300"></i>
                                        <p>Belum ada data obat di inventaris.</p>
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
        function konfirmasiHapus(id, namaObat) {
            Swal.fire({
                title: 'Hapus Obat?',
                text: "Anda yakin ingin menghapus data " + namaObat + " dari katalog?",
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