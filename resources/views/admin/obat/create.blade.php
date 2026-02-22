<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-plus-circle mr-2 text-blue-600"></i> {{ __('Tambah Obat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-2xl font-extrabold text-gray-900">Formulir Obat Baru</h3>
                    <p class="text-gray-500 text-sm mt-1">Masukkan rincian informasi obat untuk ditambahkan ke inventaris klinik.</p>
                </div>

                <form action="{{ route('admin.obat.store') }}" method="POST" class="space-y-6">
                    @csrf 
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Obat</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-tablets text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_obat" required placeholder="Contoh: Parasetamol 500mg" class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga Jual (Rp)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 font-bold">
                                    Rp
                                </div>
                                <input type="number" name="harga" required placeholder="5000" class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Stok Awal</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-boxes text-gray-400"></i>
                                </div>
                                <input type="number" name="stok" required placeholder="100" class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Satuan Kemasan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-box-open text-gray-400"></i>
                                </div>
                                <select name="satuan" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white appearance-none">
                                    <option value="Strip">Strip</option>
                                    <option value="Botol">Botol</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Kapsul">Kapsul</option>
                                    <option value="Pcs">Pcs</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-center gap-3 justify-end">
                        <a href="{{ route('admin.obat.index') }}" class="w-full sm:w-auto text-center bg-white border-2 border-slate-200 text-slate-600 px-6 py-3 rounded-xl hover:bg-slate-50 hover:text-slate-800 font-bold transition">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 font-bold shadow-lg shadow-blue-200 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Simpan Obat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>