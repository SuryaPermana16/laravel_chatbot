<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-brain mr-2 text-cyan-600"></i> {{ __('Data Knowledge Base (AI)') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-cyan-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>

            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{!! session('success') !!}",
                        showConfirmButton: false,
                        timer: 2500,
                        customClass: { popup: 'rounded-2xl' }
                    });
                });
            </script>
            @endif

            @if($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: "{{ $errors->first() }}",
                        showConfirmButton: true,
                        customClass: { popup: 'rounded-2xl' }
                    });
                });
            </script>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-extrabold text-gray-900">Database Pengetahuan Chatbot</h3>
                <div class="flex gap-3">
                    
                    <form action="{{ route('admin.kb.sync_database') }}" method="POST" class="inline-block" onsubmit="return confirm('Mulai sinkronisasi data Obat & Dokter ke otak AI? Proses ini akan menimpa data otomatis lama dan memakan waktu beberapa detik.')">
                        @csrf
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-emerald-200 transition-all flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i> Sinkronisasi Database ke AI
                        </button>
                    </form>

                    <a href="{{ route('admin.kb.create_pdf') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                        <i class="fas fa-file-pdf"></i> Upload PDF SOP
                    </a>

                    <a href="{{ route('admin.kb.create') }}" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-cyan-200 transition-all flex items-center gap-2">
                        <i class="fas fa-plus"></i> Tambah FAQ
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-2xl border border-gray-100">
                <div class="p-0 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider w-1/4">Kategori</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider w-2/4">Pertanyaan & Jawaban</th>
                                <th class="px-6 py-4 font-bold text-gray-500 uppercase tracking-wider text-center w-1/4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($kbs as $kb)
                            <tr class="hover:bg-slate-50 transition duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($kb->kategori == 'Data Database Otomatis')
                                            <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                                <i class="fas fa-database"></i>
                                            </div>
                                            <div class="font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-3 py-1 rounded-lg text-xs tracking-wider uppercase">
                                                {{ $kb->kategori }}
                                            </div>
                                        @elseif(Str::contains($kb->kategori, 'Dokumen:'))
                                            <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div class="font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-3 py-1 rounded-lg text-xs tracking-wider uppercase">
                                                {{ Str::limit($kb->kategori, 20) }}
                                            </div>
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-cyan-50 text-cyan-600 flex items-center justify-center font-bold">
                                                <i class="fas fa-tags"></i>
                                            </div>
                                            <div class="font-bold text-cyan-700 bg-cyan-50 border border-cyan-100 px-3 py-1 rounded-lg text-xs tracking-wider uppercase">
                                                {{ $kb->kategori }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 text-base mb-1">{{ $kb->pertanyaan }}</div>
                                    <div class="text-sm text-gray-500 leading-relaxed">
                                        {{ Str::limit($kb->jawaban, 100, '...') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        @if($kb->kategori != 'Data Database Otomatis')
                                        <a href="{{ route('admin.kb.edit', $kb->id) }}" class="text-amber-500 hover:text-amber-700 font-bold px-3 py-1 bg-amber-50 border border-amber-200 rounded-lg transition uppercase text-xs">Edit</a>
                                        @endif

                                        <form action="{{ route('admin.kb.destroy', $kb->id) }}" method="POST" id="delete-form-{{ $kb->id }}" class="inline-block">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="button" onclick="konfirmasiHapus('{{ $kb->id }}')" class="text-red-500 hover:text-red-700 font-bold px-3 py-1 bg-red-50 border border-red-200 rounded-lg transition uppercase text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Hapus Data Ini?',
                text: "Data pengetahuan ini akan dihapus dari ingatan AI secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-6 py-2 font-bold',
                    cancelButton: 'rounded-xl px-6 py-2 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>