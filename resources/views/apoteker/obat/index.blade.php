<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Obat (Apoteker)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('apoteker.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
            @endif

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('apoteker.obat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-sm">
                    + Tambah Obat Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama Obat</th>
                                <th class="px-4 py-2 text-left">Harga</th>
                                <th class="px-4 py-2 text-left">Stok</th>
                                <th class="px-4 py-2 text-left">Satuan</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obats as $obat)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-4 py-2 font-medium">{{ $obat->nama_obat }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($obat->harga) }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <span class="{{ $obat->stok < 10 ? 'bg-red-100 text-red-600 px-2 py-0.5 rounded font-bold' : 'text-green-600' }}">
                                        {{ $obat->stok }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm">{{ $obat->satuan }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('apoteker.obat.edit', $obat->id) }}" class="text-yellow-500 hover:text-yellow-700 font-bold mx-1">Edit</a>
                                    
                                    <form id="delete-form-{{ $obat->id }}" action="{{ route('apoteker.obat.destroy', $obat->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="konfirmasiHapus('{{ $obat->id }}', '{{ $obat->nama_obat }}')" class="text-red-500 hover:text-red-700 font-bold mx-1">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($obats->isEmpty())
                        <div class="p-8 text-center text-gray-500 italic">
                            <i class="fas fa-pills mb-2 text-2xl block text-gray-300"></i>
                            Belum ada data obat.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function konfirmasiHapus(id, namaObat) {
            Swal.fire({
                title: 'Hapus Obat?',
                text: "Anda yakin ingin menghapus data " + namaObat + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Merah untuk bahaya
                cancelButtonColor: '#3085d6', // Biru untuk batal
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form penghapusan jika dikonfirmasi
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>