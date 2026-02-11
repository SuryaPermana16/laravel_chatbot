<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Apoteker</h2>
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

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.apoteker.update', $apoteker->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $apoteker->nama_lengkap) }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">No Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $apoteker->no_telepon) }}" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full border rounded p-2">{{ old('alamat', $apoteker->alamat) }}</textarea>
                    </div>

                    <hr class="my-4 border-gray-300">
                    <p class="text-sm text-gray-500 mb-2">Akun untuk Login:</p>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $apoteker->user->email) }}" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Password Baru (Opsional)</label>
                        <p class="text-xs text-red-500 mb-1">*Kosongkan jika tidak ingin mengubah password.</p>
                        <div style="position: relative; width: 100%;">
                            <input type="password" name="password" id="passApotekerEdit" 
                                   class="w-full border rounded p-2" 
                                   style="padding-right: 40px;">
                            <span onclick="togglePassword('passApotekerEdit', 'iconApotekerEdit')" 
                                  style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6b7280; z-index: 10;">
                                <i id="iconApotekerEdit" class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Data Apoteker</button>
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