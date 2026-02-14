<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Pasien</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm">
                <span class="block sm:inline font-bold"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
            </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('admin.pasien.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-sm">
                    + Daftar Pasien Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-center">L/P</th>
                                <th class="px-4 py-3 text-left">Usia</th>
                                <th class="px-4 py-3 text-left">No HP</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($pasiens as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-bold text-gray-700">{{ $p->nama_lengkap }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($p->jenis_kelamin == 'L')
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-bold">L</span>
                                    @else
                                        <span class="bg-pink-100 text-pink-700 px-2 py-1 rounded-full text-xs font-bold">P</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} Thn
                                </td>
                                <td class="px-4 py-3">{{ $p->no_telepon }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $p->user->email ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center">
                                        <a href="{{ route('admin.pasien.show', $p->id) }}" class="text-blue-600 hover:text-blue-800 font-bold mx-2">
                                            Riwayat
                                        </a>

                                        <a href="{{ route('admin.pasien.edit', $p->id) }}" class="text-yellow-600 hover:text-yellow-800 font-bold mx-2">Edit</a>
                                        
                                        <form action="{{ route('admin.pasien.destroy', $p->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-bold mx-2">Hapus</button>
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
</x-app-layout>