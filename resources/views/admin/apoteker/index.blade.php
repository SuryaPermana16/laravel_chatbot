<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Apoteker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-green-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <span class="block sm:inline font-bold">{{ session('success') }}</span>
            </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('admin.apoteker.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Tambah Apoteker
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama Apoteker</th>
                                <th class="px-4 py-2 text-left">Email Login</th>
                                <th class="px-4 py-2 text-left">No HP</th>
                                <th class="px-4 py-2 text-left">Alamat</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($apotekers as $apoteker)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 font-bold">{{ $apoteker->nama_lengkap }}</td>
                                <td class="px-4 py-2 text-gray-500">{{ $apoteker->user->email ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $apoteker->no_telepon ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm">{{ \Illuminate\Support\Str::limit($apoteker->alamat ?? '-', 30) }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('admin.apoteker.edit', $apoteker->id) }}" class="text-yellow-500 hover:text-yellow-700 font-bold mx-2">Edit</a>

                                    <form action="{{ route('admin.apoteker.destroy', $apoteker->id) }}" method="POST" class="delete-form inline-block">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold mx-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data Apoteker.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>