<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Jadwal Dokter</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Pilih Dokter</label>
                        <select name="dokter_id" class="w-full border rounded p-2" required>
                            @foreach($dokters as $dokter)
                                <option value="{{ $dokter->id }}" {{ $jadwal->dokter_id == $dokter->id ? 'selected' : '' }}>
                                    {{ $dokter->nama_lengkap }} - {{ $dokter->spesialis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Hari Praktek</label>
                        <select name="hari" class="w-full border rounded p-2" required>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                <option value="{{ $hari }}" {{ $jadwal->hari == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold mb-1">Jam Mulai</label>
                            <input type="time" name="jam_mulai" value="{{ $jadwal->jam_mulai }}" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block font-bold mb-1">Jam Selesai</label>
                            <input type="time" name="jam_selesai" value="{{ $jadwal->jam_selesai }}" class="w-full border rounded p-2" required>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <a href="{{ route('admin.jadwal.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 font-bold">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 font-bold">
                            <i class="fas fa-save mr-1"></i> Update Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>