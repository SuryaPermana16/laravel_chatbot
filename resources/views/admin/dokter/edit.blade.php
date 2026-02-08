<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Dokter</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-4">
                        <label class="block font-bold mb-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" value="{{ $dokter->nama_lengkap }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Spesialis</label>
                        <input type="text" name="spesialis" value="{{ $dokter->spesialis }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">No Telepon</label>
                        <input type="text" name="no_telepon" value="{{ $dokter->no_telepon }}" class="w-full border rounded p-2" required>
                    </div>

                    <hr class="my-4 border-gray-300">
                    <p class="text-sm text-gray-500 mb-2">Akun Login (Edit jika perlu):</p>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Email</label>
                        <input type="email" name="email" value="{{ $dokter->user->email ?? '' }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Password Baru</label>
                        <input type="password" name="password" class="w-full border rounded p-2" placeholder="Biarkan kosong jika tidak ingin mengganti password">
                        <p class="text-xs text-gray-400 mt-1">*Isi hanya jika ingin mereset password dokter ini.</p>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Update Dokter</button>
                        <a href="{{ route('admin.dokter.index') }}" class="text-gray-500 px-4 py-2">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>