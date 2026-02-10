<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Jadwal Dokter</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('admin.jadwal.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Tambah Jadwal Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama Dokter</th>
                                <th class="px-4 py-2 text-left">Hari</th>
                                <th class="px-4 py-2 text-left">Jam Praktek</th>
                                <th class="px-4 py-2 text-center">Status</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwals as $jadwal)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 font-bold">{{ $jadwal->dokter->nama_lengkap }}</td>
                                <td class="px-4 py-2">
                                    <span class="bg-gray-200 px-2 py-1 rounded text-xs font-bold">{{ $jadwal->hari }}</span>
                                </td>
                                <td class="px-4 py-2">
                                    {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <span class="text-green-600 font-bold text-xs border border-green-600 px-2 py-1 rounded">AKTIF</span>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="text-yellow-600 hover:text-yellow-800 font-bold mx-1">Edit</a>
                                    
                                    <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" class="delete-form inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold mx-1">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    @if($jadwals->isEmpty())
                        <div class="p-4 text-center text-gray-500">Belum ada jadwal dokter.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>