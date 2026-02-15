<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Admin Baru</h2>
    </x-slot>

    <style>
        input::-ms-reveal, input::-ms-clear { display: none; }
    </style>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.kelola-admin.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Nama Lengkap Admin</label>
                        <input type="text" name="name" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Email Login</label>
                        <input type="email" name="email" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Password</label>
                        
                        <div style="position: relative; width: 100%;">
                            <input type="password" name="password" id="passAdminCreate" 
                                   class="w-full border rounded p-2" 
                                   style="padding-right: 40px;" 
                                   required>
                            
                            <span onclick="togglePassword('passAdminCreate', 'iconAdminCreate')" 
                                  style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6b7280; z-index: 10;">
                                <i id="iconAdminCreate" class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <a href="{{ route('admin.kelola-admin.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 font-bold">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-bold">
                            <i class="fas fa-save mr-1"></i> Simpan Admin
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