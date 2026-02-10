<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-green-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('admin.dokter.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Tambah Dokter
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama Dokter</th>
                                <th class="px-4 py-2 text-left">Spesialis</th>
                                <th class="px-4 py-2 text-left">Email Login</th>
                                <th class="px-4 py-2 text-left">No HP</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dokters as $dokter)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 font-bold">{{ $dokter->nama_lengkap }}</td>
                                <td class="px-4 py-2">{{ $dokter->spesialis }}</td>
                                <td class="px-4 py-2 text-gray-500">{{ $dokter->user->email ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $dokter->no_telepon }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="text-yellow-500 hover:text-yellow-700 font-bold mx-2">Edit</a>

                                    <form action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST" class="delete-form inline-block">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold mx-2">Hapus</button>
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