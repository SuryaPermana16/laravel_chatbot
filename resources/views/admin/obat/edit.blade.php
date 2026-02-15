<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST">
                    @csrf 
                    @method('PUT') 
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Nama Obat</label>
                        <input type="text" name="nama_obat" value="{{ $obat->nama_obat }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" value="{{ $obat->harga }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Stok Saat Ini</label>
                        <input type="number" name="stok" value="{{ $obat->stok }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Satuan</label>
                        <select name="satuan" class="w-full border rounded p-2">
                            <option value="Strip" {{ $obat->satuan == 'Strip' ? 'selected' : '' }}>Strip</option>
                            <option value="Botol" {{ $obat->satuan == 'Botol' ? 'selected' : '' }}>Botol</option>
                            <option value="Tablet" {{ $obat->satuan == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Kapsul" {{ $obat->satuan == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                            <option value="Pcs" {{ $obat->satuan == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                        </select>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <a href="{{ route('admin.obat.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 font-bold">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 font-bold">
                            <i class="fas fa-save mr-1"></i> Update Data Obat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>