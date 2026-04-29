<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-stethoscope mr-2 text-blue-600"></i> {{ __('Pemeriksaan Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="mb-2">
                <a href="{{ route('dokter.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 font-bold transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Antrean
                </a>
            </div>

            {{-- CARD PASIEN --}}
            <div class="bg-white rounded-[2rem] shadow border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-blue-600"></div>

                <div class="p-8 sm:p-10">

                    <div class="flex flex-col md:flex-row gap-6 md:items-center justify-between border-b border-gray-100 pb-6 mb-6">
                        <div class="flex items-center gap-5">

                            <div class="w-16 h-16 rounded-2xl {{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }} flex items-center justify-center text-2xl font-extrabold">
                                {{ strtoupper(substr($kunjungan->pasien->nama_lengkap, 0, 1)) }}
                            </div>

                            <div>
                                <h3 class="text-2xl font-extrabold text-gray-900 mb-1">
                                    {{ $kunjungan->pasien->nama_lengkap }}
                                </h3>

                                <div class="flex items-center gap-2 text-sm font-bold text-gray-500">
                                    <span>{{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    <span>•</span>
                                    <span>{{ \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->age }} Thn</span>
                                    <span>•</span>
                                    <span>RM: {{ $kunjungan->pasien->no_rm }}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- DATA VITAL --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                        <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                            <div class="text-xs text-gray-400 font-bold uppercase mb-1">Berat Badan</div>
                            <div class="text-xl font-black text-gray-900">
                                {{ $kunjungan->pasien->berat_badan ? $kunjungan->pasien->berat_badan . ' Kg' : 'Belum diisi' }}
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                            <div class="text-xs text-gray-400 font-bold uppercase mb-1">Tinggi Badan</div>
                            <div class="text-xl font-black text-gray-900">
                                {{ $kunjungan->pasien->tinggi_badan ? $kunjungan->pasien->tinggi_badan . ' Cm' : 'Belum diisi' }}
                            </div>
                        </div>

                        <div class="bg-red-50 border border-red-100 rounded-xl p-4">
                            <div class="text-xs text-gray-400 font-bold uppercase mb-1">Tensi Darah</div>
                            <div class="text-xl font-black text-gray-900">
                                {{ $kunjungan->pasien->tensi_darah ?? 'Belum diisi' }}
                            </div>
                        </div>

                    </div>

                    {{-- KELUHAN --}}
                    <div class="bg-amber-50 border border-amber-100 rounded-xl p-5">
                        <div class="text-xs font-bold text-amber-600 uppercase mb-2">
                            Keluhan Awal Pasien
                        </div>

                        <p class="text-gray-700 italic">
                            "{{ $kunjungan->keluhan }}"
                        </p>
                    </div>

                </div>
            </div>

            {{-- FORM --}}
            <div class="bg-white rounded-[2rem] shadow border border-gray-100 p-8 sm:p-10"
                 x-data="{ resep: [] }">

                <div class="mb-8 pb-4 border-b border-gray-100">
                    <h3 class="font-extrabold text-xl text-gray-900">
                        Catatan Pemeriksaan & Resep Dokter
                    </h3>
                </div>

                <form action="{{ route('dokter.periksa.simpan', $kunjungan->id) }}" method="POST" class="space-y-8">
                    @csrf

                    <div>
                        <label class="text-sm font-bold text-gray-700 mb-2 block">
                            Hasil Pemeriksaan
                        </label>

                        <textarea name="diagnosa" rows="4" required
                                  class="w-full border-gray-200 bg-slate-50 rounded-xl p-4"
                                  placeholder="Tuliskan hasil pemeriksaan..."></textarea>
                    </div>

                    {{-- RESEP --}}
                    <div>
                        <label class="text-sm font-bold text-gray-700 mb-3 block">
                            Resep Obat Terintegrasi (Opsional)
                        </label>

                        <div class="space-y-3 mb-4">

                            <template x-for="(item, index) in resep" :key="index">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 p-4 bg-slate-50 border rounded-xl">

                                    {{-- SEARCH + PILIH SATU KOLOM --}}
                                    <div class="md:col-span-5">
                                        <label class="text-xs font-bold text-gray-500 block mb-1">
                                            Pilih Obat
                                        </label>

                                        <input type="text"
                                               x-model="item.search"
                                               list="obatList"
                                               @input="
                                                let found = item.options.find(ob =>
                                                    (ob.nama + ' (Stok: ' + ob.stok + ')') === item.search
                                                );
                                                item.id = found ? found.id : '';
                                               "
                                               placeholder="Cari obat..."
                                               class="w-full border-gray-300 rounded-lg text-sm">

                                        <input type="hidden" name="obat_id[]" x-model="item.id">

                                        <datalist id="obatList">
                                            @foreach($obats as $obat)
                                                <option value="{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})"></option>
                                            @endforeach
                                        </datalist>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="text-xs font-bold text-gray-500 block mb-1">
                                            Jumlah
                                        </label>

                                        <input type="number"
                                               name="jumlah[]"
                                               min="1"
                                               x-model="item.jumlah"
                                               class="w-full border-gray-300 rounded-lg text-sm">
                                    </div>

                                    <div class="md:col-span-4">
                                        <label class="text-xs font-bold text-gray-500 block mb-1">
                                            Aturan Minum
                                        </label>

                                        <input type="text"
                                               name="aturan_minum[]"
                                               x-model="item.aturan"
                                               placeholder="3 x 1 Sesudah Makan"
                                               class="w-full border-gray-300 rounded-lg text-sm">
                                    </div>

                                    <div class="md:col-span-1 flex items-end">
                                        <button type="button"
                                                @click="resep.splice(index,1)"
                                                class="w-full py-2 bg-red-100 text-red-600 rounded-lg">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                </div>
                            </template>

                        </div>

                        <button type="button"
                            @click="resep.push({
                                id:'',
                                jumlah:1,
                                aturan:'',
                                search:'',
                                options:[
                                    @foreach($obats as $obat)
                                    {id:'{{ $obat->id }}', nama:'{{ $obat->nama_obat }}', stok:'{{ $obat->stok }}'},
                                    @endforeach
                                ]
                            })"
                            class="w-full py-3 border-2 border-dashed border-emerald-300 text-emerald-600 font-bold rounded-xl hover:bg-emerald-50">
                            + Tambah Obat ke Resep
                        </button>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl">
                            Simpan Rekam Medis & Selesaikan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>