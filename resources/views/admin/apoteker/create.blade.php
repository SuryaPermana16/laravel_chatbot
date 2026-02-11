<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Apoteker</h2>
    </x-slot>

    <style>
        input::-ms-reveal, input::-ms-clear { display: none; }
    </style>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('admin.apoteker.index') }}" class="inline-flex items-center text-gray-500 hover:text-green-600 font-bold transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Apoteker
                </a>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.apoteker.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" class="w-full border rounded p-2" placeholder="Contoh: Apt. Budi Santoso, S.Farm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">No Telepon</label>
                        <input type="text" name="no_telepon" class="w-full border rounded p-2" placeholder="Contoh: 081234567890">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full border rounded p-2" placeholder="Masukkan alamat domisili..."></textarea>
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
                            <input type="password" name="password" id="passApotekerCreate" 
                                   class="w-full border rounded p-2" 
                                   style="padding-right: 40px;" 
                                   required>
                            <span onclick="togglePassword('passApotekerCreate', 'iconApotekerCreate')" 
                                  style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6b7280; z-index: 10;">
                                <i id="iconApotekerCreate" class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Apoteker</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function togglePassword(inputId, iconId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</x-app-layout>