<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-edit mr-2 text-amber-500"></i> {{ __('Edit Data FAQ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
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
                    <h3 class="text-2xl font-extrabold text-gray-900">Perbarui Pengetahuan AI</h3>
                    <p class="text-gray-500 text-sm mt-1">Mengubah data di bawah ini akan memicu proses pencetakan Vektor ulang di server Google.</p>
                </div>

                <form action="{{ route('admin.kb.update', $kb->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') 
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Informasi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-tags text-gray-400"></i>
                                </div>
                                <input type="text" name="kategori" value="{{ $kb->kategori }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pertanyaan (Kueri Pasien)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-question-circle text-gray-400"></i>
                                </div>
                                <input type="text" name="pertanyaan" value="{{ $kb->pertanyaan }}" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Jawaban (Konteks AI)</label>
                            <div class="relative">
                                <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                                    <i class="fas fa-comment-dots text-gray-400"></i>
                                </div>
                                <textarea name="jawaban" required rows="5" class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 outline-none transition text-gray-700 bg-slate-50 focus:bg-white resize-none">{{ $kb->jawaban }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-center gap-3 justify-end">
                        <a href="{{ route('admin.kb.index') }}" class="w-full sm:w-auto text-center bg-white border-2 border-slate-200 text-slate-600 px-6 py-3 rounded-xl hover:bg-slate-50 hover:text-slate-800 font-bold transition">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-amber-500 text-white px-8 py-3 rounded-xl hover:bg-amber-600 font-bold shadow-lg shadow-amber-200 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-sync-alt"></i> Update & Re-Embed Vektor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>