<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Pasien') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-green-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
            @endif

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('admin.pasien.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-sm">
                    + Daftar Pasien Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left">Nama Pasien</th>
                                <th class="px-4 py-3 text-center">L/P</th>
                                <th class="px-4 py-3 text-left">Usia</th>
                                <th class="px-4 py-3 text-left">No HP</th>
                                <th class="px-4 py-3 text-left">Email Akun</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($pasiens as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-bold text-gray-700">{{ $p->nama_lengkap }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($p->jenis_kelamin == 'L')
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-bold border border-blue-200">L</span>
                                    @else
                                        <span class="bg-pink-100 text-pink-700 px-2 py-1 rounded-full text-xs font-bold border border-pink-200">P</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} Thn
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $p->no_telepon }}</td>
                                <td class="px-4 py-3 text-gray-500 italic text-xs">{{ $p->user->email ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center">
                                        <a href="{{ route('admin.pasien.show', $p->id) }}" class="text-blue-600 hover:text-blue-800 font-bold mx-2 uppercase text-xs">
                                            Riwayat
                                        </a>

                                        <a href="{{ route('admin.pasien.edit', $p->id) }}" class="text-yellow-500 hover:text-yellow-700 font-bold mx-2 uppercase text-xs">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.pasien.destroy', $p->id) }}" method="POST" id="delete-form-{{ $p->id }}" class="inline-block">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="button" onclick="konfirmasiHapusPasien('{{ $p->id }}', '{{ $p->nama_lengkap }}')" class="text-red-500 hover:text-red-700 font-bold mx-2 uppercase text-xs">
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
        function konfirmasiHapusPasien(id, nama) {
            Swal.fire({
                title: 'Hapus Data Pasien?',
                text: "Pasien " + nama + " akan dihapus permanen dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Merah
                cancelButtonColor: '#3b82f6',  // Biru
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jalankan submit form jika user klik Ya
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>