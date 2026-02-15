<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Obat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.obat.store') }}" method="POST">
                    @csrf 
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Nama Obat</label>
                        <input type="text" name="nama_obat" class="w-full border rounded p-2" placeholder="Contoh: Parasetamol 500mg" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" class="w-full border rounded p-2" placeholder="Contoh: 5000" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Stok Awal</label>
                        <input type="number" name="stok" class="w-full border rounded p-2" placeholder="Contoh: 100" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Satuan</label>
                        <select name="satuan" class="w-full border rounded p-2">
                            <option value="Strip">Strip</option>
                            <option value="Botol">Botol</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Kapsul">Kapsul</option>
                            <option value="Pcs">Pcs</option>
                        </select>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <a href="{{ route('admin.obat.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 font-bold">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-bold">
                            <i class="fas fa-save mr-1"></i> Simpan Obat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>