<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-edit mr-2 text-amber-500"></i> {{ __('Edit Data Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
                    <p class="text-sm text-red-700 font-bold mb-1"><i class="fas fa-exclamation-circle mr-2"></i>Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2rem] border border-gray-100">
                
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-2xl font-extrabold text-gray-900">Perbarui Data Obat</h3>
                    <p class="text-gray-500 text-sm mt-1">Ubah rincian nama, harga, stok, atau satuan obat di bawah ini.</p>
                </div>

                <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST" class="space-y-6">
                    @csrf 
                    @method('PUT') 
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Obat</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-tablets text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_obat" value="{{ $obat->nama_obat }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga Jual (Rp)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 font-bold">
                                    Rp
                                </div>
                                <input type="number" name="harga" value="{{ $obat->harga }}" required class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Stok Saat Ini</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-boxes text-gray-400"></i>
                                </div>
                                <input type="number" name="stok" value="{{ $obat->stok }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Satuan Kemasan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-box-open text-gray-400"></i>
                                </div>
                                <select name="satuan" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white appearance-none">
                                    <option value="Strip" {{ $obat->satuan == 'Strip' ? 'selected' : '' }}>Strip</option>
                                    <option value="Botol" {{ $obat->satuan == 'Botol' ? 'selected' : '' }}>Botol</option>
                                    <option value="Tablet" {{ $obat->satuan == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                    <option value="Kapsul" {{ $obat->satuan == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                                    <option value="Pcs" {{ $obat->satuan == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-center gap-3 justify-end">
                        <a href="{{ route('admin.obat.index') }}" class="w-full sm:w-auto text-center bg-white border-2 border-slate-200 text-slate-600 px-6 py-3 rounded-xl hover:bg-slate-50 hover:text-slate-800 font-bold transition">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-amber-500 text-white px-8 py-3 rounded-xl hover:bg-amber-600 font-bold shadow-lg shadow-amber-200 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i> Update Obat
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>