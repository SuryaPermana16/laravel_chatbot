<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Admin') }}
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
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm">
                <span class="block sm:inline font-bold"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
            </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('admin.kelola-admin.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-sm">
                    + Tambah Admin
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama Admin</th>
                                <th class="px-4 py-2 text-left">Email Login</th>
                                <th class="px-4 py-2 text-left">Bergabung</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 font-bold">
                                    {{ $admin->name }}
                                    @if(Auth::id() == $admin->id) 
                                        <span class="ml-2 bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">(Anda)</span> 
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-gray-500">{{ $admin->email }}</td>
                                <td class="px-4 py-2">{{ $admin->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('admin.kelola-admin.edit', $admin->id) }}" class="text-yellow-500 hover:text-yellow-700 font-bold mx-2">Edit</a>
                                    
                                    @if(Auth::id() != $admin->id)
                                    <form action="{{ route('admin.kelola-admin.destroy', $admin->id) }}" method="POST" class="delete-form inline-block" onsubmit="return confirm('Yakin ingin menghapus admin ini?');">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold mx-2">Hapus</button>
                                    </form>
                                    @endif
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