<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-file-pdf mr-2 text-indigo-600"></i> {{ __('Pelatihan AI (Upload PDF)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.kb.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Database Pengetahuan
                </a>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Gagal Memproses Dokumen!</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <div class="mb-8 border-b border-gray-100 pb-5">
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Upload Dokumen SOP Klinik</h3>
                        <p class="text-gray-500 text-base leading-relaxed">Unggah dokumen operasional klinik (SOP, Panduan Pelayanan, atau Aturan BPJS). Sistem RAG akan otomatis membaca teks, memotongnya per paragraf, dan menjadikannya "Otak" (Vektor) untuk Chatbot AI.</p>
                    </div>

                    <form action="{{ route('admin.kb.store_pdf') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih File PDF <span class="text-red-500">*</span></label>
                            
                            <div class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 hover:bg-indigo-50 transition-all bg-gray-50 group">
                                <div class="space-y-2 text-center">
                                    <i class="fas fa-file-pdf text-5xl text-gray-400 group-hover:text-indigo-500 transition-colors mb-3"></i>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="dokumen_pdf" class="relative cursor-pointer bg-white rounded-md font-bold text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 px-3 py-1 shadow-sm border border-gray-200">
                                            <span id="file-name">Pilih File dari Komputer</span>
                                            <input id="dokumen_pdf" name="dokumen_pdf" type="file" class="sr-only" accept=".pdf" required>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 pt-2 font-medium">
                                        Hanya menerima file berformat <b>.PDF</b> (Maksimal 5MB).
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-gray-100">
                            <a href="{{ route('admin.kb.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-xl transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                                <i class="fas fa-brain"></i> Proses & Pelajari Dokumen
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('dokumen_pdf');
            const fileNameDisplay = document.getElementById('file-name');

            fileInput.addEventListener('change', function(e) {
                // Jika ada file yang dipilih, tampilkan namanya. Jika batal, kembalikan ke teks awal.
                if (e.target.files.length > 0) {
                    fileNameDisplay.textContent = e.target.files[0].name;
                    // Ubah warna teks agar terlihat bahwa file sudah terpilih
                    fileNameDisplay.classList.remove('text-indigo-600');
                    fileNameDisplay.classList.add('text-green-600'); 
                } else {
                    fileNameDisplay.textContent = 'Pilih File dari Komputer';
                    fileNameDisplay.classList.remove('text-green-600');
                    fileNameDisplay.classList.add('text-indigo-600');
                }
            });
        });
    </script>
</x-app-layout>