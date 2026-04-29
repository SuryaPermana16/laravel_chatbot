<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-hospital-user mr-2 text-indigo-600"></i>
            {{ __('Data Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="mb-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 font-bold transition group">
                    <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">
                        Daftar Pasien
                    </h3>

                    <p class="text-sm text-gray-500">
                        Total terdaftar:
                        <span class="font-bold text-indigo-600">
                            {{ $pasiens->count() }} Pasien
                        </span>
                    </p>
                </div>

                <a href="{{ route('admin.pasien.create') }}"
                   class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-indigo-200 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Pasien Baru
                </a>
            </div>

            {{-- SEARCH --}}
            <form method="GET" action="{{ route('admin.pasien.index') }}">
                <div class="bg-white rounded-2xl shadow border border-gray-100 p-4 flex flex-col md:flex-row gap-3">

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama pasien / RM / telepon / email..."
                           class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 outline-none">

                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold whitespace-nowrap">
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('admin.pasien.index') }}"
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold text-center whitespace-nowrap">
                            Reset
                        </a>
                    @endif

                </div>
            </form>

            <div class="bg-white overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[2.5rem] border border-gray-100">
                <div class="p-0 text-gray-900 overflow-x-auto">

                    <table class="min-w-full table-auto text-sm text-left">

                        <thead class="bg-gray-50/50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-5 font-bold text-gray-400 uppercase text-[10px] text-center w-32">
                                    Nomor RM
                                </th>

                                <th class="px-6 py-5 font-bold text-gray-400 uppercase text-[10px]">
                                    Profil Pasien
                                </th>

                                <th class="px-6 py-5 font-bold text-gray-400 uppercase text-[10px] text-center">
                                    Gender & Usia
                                </th>

                                <th class="px-6 py-5 font-bold text-gray-400 uppercase text-[10px]">
                                    Kontak & Akun
                                </th>

                                <th class="px-6 py-5 font-bold text-gray-400 uppercase text-[10px] text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-50">

                            @forelse ($pasiens as $p)
                                <tr class="hover:bg-indigo-50/30 transition duration-200">

                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block bg-slate-900 text-white font-black text-xs px-3 py-1.5 rounded-xl">
                                            {{ $p->no_rm ?? 'OTOMATIS' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">

                                            <div class="w-11 h-11 rounded-2xl {{ $p->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }} flex items-center justify-center font-black text-lg shadow-sm shrink-0">
                                                {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                            </div>

                                            <div>
                                                <div class="font-extrabold text-gray-800 text-base">
                                                    {{ $p->nama_lengkap }}
                                                </div>

                                                <div class="text-[10px] text-gray-400 uppercase font-bold mt-0.5">
                                                    ID: #{{ $p->id }}
                                                </div>
                                            </div>

                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-col items-center gap-1">

                                            @if($p->jenis_kelamin == 'L')
                                                <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-[10px] font-black border border-blue-100 uppercase">
                                                    Laki-laki
                                                </span>
                                            @else
                                                <span class="bg-pink-50 text-pink-600 px-3 py-1 rounded-lg text-[10px] font-black border border-pink-100 uppercase">
                                                    Perempuan
                                                </span>
                                            @endif

                                            <span class="text-xs font-bold text-gray-600">
                                                {{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} Tahun
                                            </span>

                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-gray-700 font-bold mb-1 flex items-center gap-2">
                                            <i class="fas fa-phone-alt text-indigo-400 text-xs"></i>
                                            {{ $p->no_telepon }}
                                        </div>

                                        <div class="text-xs text-gray-400 flex items-center gap-2 italic">
                                            <i class="far fa-envelope text-gray-300 text-xs"></i>
                                            {{ $p->user->email ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">

                                            <a href="{{ route('admin.pasien.show', $p->id) }}"
                                               class="p-2.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition-all">
                                                <i class="fas fa-file-medical"></i>
                                            </a>

                                            <a href="{{ route('admin.pasien.edit', $p->id) }}"
                                               class="p-2.5 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-xl transition-all">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.pasien.destroy', $p->id) }}"
                                                  method="POST"
                                                  id="form-hapus-{{ $p->id }}"
                                                  class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <button type="button"
                                                    onclick="confirmDelete('{{ $p->id }}', '{{ $p->nama_lengkap }}')"
                                                    class="p-2.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center text-gray-400">
                                        Data pasien tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Pasien?',
                text: "Data " + name + " akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-hapus-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>