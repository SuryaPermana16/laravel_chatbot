<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Konfirmasi Pendaftaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Detail Jadwal Dokter</h3>
                
                <div class="mb-4">
                    <label class="text-gray-500 text-sm font-medium uppercase tracking-wider text-[11px]">Nama Dokter</label>
                    <div class="font-bold text-lg text-gray-900">{{ $jadwal->dokter->nama_lengkap }}</div>
                    <div class="text-blue-600 font-medium">{{ $jadwal->dokter->spesialis }}</div>
                </div>

                <div class="flex gap-10 mb-6">
                    <div>
                        <label class="text-gray-500 text-sm font-medium uppercase tracking-wider text-[11px]">Hari</label>
                        <div class="font-bold text-gray-800">{{ $jadwal->hari }}</div>
                    </div>
                    <div>
                        <label class="text-gray-500 text-sm font-medium uppercase tracking-wider text-[11px]">Jam Praktek</label>
                        <div class="font-bold text-green-600">
                            {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                        </div>
                    </div>
                </div>

                <form action="{{ route('user.daftar.store', $jadwal->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                        <div class="flex items-center text-blue-800 font-bold mb-1 text-sm">
                            <i class="fas fa-info-circle mr-2"></i> PENTING:
                        </div>
                        <p class="text-xs text-blue-700 leading-relaxed">
                            Mohon pilih rencana jam kedatangan. Anda WAJIB hadir di klinik minimal 15 menit sebelum jam yang dipilih untuk verifikasi pendaftaran.
                        </p>
                    </div>

                    <div class="mb-5">
                        <label class="block font-bold mb-2 text-gray-700 text-sm">Pilih Jam Kedatangan:</label>
                        <input type="time" name="jam_pilihan" 
                               min="{{ date('H:i', strtotime($jadwal->jam_mulai)) }}" 
                               max="{{ date('H:i', strtotime($jadwal->jam_selesai)) }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 text-sm" 
                               required>
                        <p class="text-[10px] text-gray-400 mt-1 italic">*Pilih jam antara {{ date('H:i', strtotime($jadwal->jam_mulai)) }} s/d {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</p>
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold mb-2 text-gray-700 text-sm">Apa Keluhan Anda?</label>
                        <textarea name="keluhan" rows="3" class="w-full border-gray-300 rounded-lg p-3 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Demam tinggi sudah 3 hari, pusing..." required></textarea>
                    </div>

                    <div class="flex justify-end gap-2 border-t pt-4">
                        <a href="{{ route('user.dashboard') }}" class="bg-gray-100 text-gray-600 px-6 py-2 rounded-lg text-sm font-bold hover:bg-gray-200 transition">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-bold text-sm shadow-sm transition">
                            Ambil Antrian
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>