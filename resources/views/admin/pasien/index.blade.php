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

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('admin.pasien.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Daftar Pasien Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama</th>
                                <th class="px-4 py-2 text-left">L/P</th>
                                <th class="px-4 py-2 text-left">Usia/Tgl Lahir</th>
                                <th class="px-4 py-2 text-left">No HP</th>
                                <th class="px-4 py-2 text-left">Akun Email</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pasiens as $p)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 font-bold">{{ $p->nama_lengkap }}</td>
                                <td class="px-4 py-2">{{ $p->jenis_kelamin }}</td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} Thn <br>
                                    <span class="text-xs text-gray-500">({{ $p->tanggal_lahir }})</span>
                                </td>
                                <td class="px-4 py-2">{{ $p->no_telepon }}</td>
                                <td class="px-4 py-2 text-gray-500">{{ $p->user->email ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('admin.pasien.edit', $p->id) }}" class="text-yellow-600 hover:text-yellow-800 font-bold mx-1">Edit</a>
                                    
                                    <form action="{{ route('admin.pasien.destroy', $p->id) }}" method="POST" class="delete-form inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold mx-1">Hapus</button>
                                    </form>
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