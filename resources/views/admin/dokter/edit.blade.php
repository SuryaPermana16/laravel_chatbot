<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Dokter</h2>
    </x-slot>

    <style>
        input::-ms-reveal, input::-ms-clear { display: none; }
    </style>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
                    @csrf
                    @method('PUT') 
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" value="{{ $dokter->nama_lengkap }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Spesialis</label>
                        <input type="text" name="spesialis" value="{{ $dokter->spesialis }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Tarif Jasa Konsultasi (Rp)</label>
                        <input type="number" name="harga_jasa" value="{{ old('harga_jasa', $dokter->harga_jasa) }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">No Telepon</label>
                        <input type="text" name="no_telepon" value="{{ $dokter->no_telepon }}" class="w-full border rounded p-2" required>
                    </div>

                    <hr class="my-4 border-gray-300">
                    <p class="text-sm text-gray-500 mb-2">Akun Login (Edit jika perlu):</p>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Email</label>
                        <input type="email" name="email" value="{{ $dokter->user->email ?? '' }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Password Baru</label>
                        <div style="position: relative; width: 100%;">
                            <input type="password" name="password" id="passDokterEdit" 
                                   class="w-full border rounded p-2" 
                                   style="padding-right: 40px;" 
                                   placeholder="Biarkan kosong jika tidak ingin mengganti password">
                            
                            <span onclick="togglePassword('passDokterEdit', 'iconDokterEdit')" 
                                  style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6b7280; z-index: 10;">
                                <i id="iconDokterEdit" class="fas fa-eye"></i>
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">*Isi hanya jika ingin mereset password dokter ini.</p>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <a href="{{ route('admin.dokter.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 font-bold">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 font-bold">
                            <i class="fas fa-save mr-1"></i> Update Data Dokter
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</x-app-layout>