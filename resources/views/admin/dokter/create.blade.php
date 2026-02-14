<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Dokter</h2>
    </x-slot>

    <style>
        input::-ms-reveal, input::-ms-clear { display: none; }
    </style>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.dokter.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Spesialis</label>
                        <input type="text" name="spesialis" class="w-full border rounded p-2" placeholder="Contoh: Umum, Gigi, Kandungan" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Tarif Jasa Konsultasi (Rp)</label>
                        <input type="number" name="harga_jasa" class="w-full border rounded p-2" placeholder="Contoh: 150000" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">No Telepon</label>
                        <input type="text" name="no_telepon" class="w-full border rounded p-2" required>
                    </div>

                    <hr class="my-4 border-gray-300">
                    <p class="text-sm text-gray-500 mb-2">Akun untuk Login:</p>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Email</label>
                        <input type="email" name="email" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Password</label>
                        
                        <div style="position: relative; width: 100%;">
                            
                            <input type="password" name="password" id="passDokterCreate" 
                                   class="w-full border rounded p-2" 
                                   style="padding-right: 40px;" 
                                   required>
                            
                            <span onclick="togglePassword('passDokterCreate', 'iconDokterCreate')" 
                                  style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6b7280; z-index: 10;">
                                <i id="iconDokterCreate" class="fas fa-eye"></i>
                            </span>

                        </div>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Dokter</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>