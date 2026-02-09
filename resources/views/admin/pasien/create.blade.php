<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Pendaftaran Pasien Baru</h2></x-slot>

    <style>
        input::-ms-reveal, input::-ms-clear { display: none; }
    </style>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.pasien.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold mb-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block font-bold mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full border rounded p-2">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block font-bold mb-1">No HP (WhatsApp)</label>
                            <input type="number" name="no_telepon" class="w-full border rounded p-2" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" class="w-full border rounded p-2" rows="2" required></textarea>
                    </div>

                    <hr class="my-4">
                    <p class="text-sm font-bold text-blue-600 mb-2">Akun Login Pasien</p>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Email</label>
                        <input type="email" name="email" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Password</label>
                        <div style="position: relative; width: 100%;">
                            <input type="password" name="password" id="passPasienCreate" 
                                   class="w-full border rounded p-2" 
                                   style="padding-right: 40px;" 
                                   required>
                            
                            <span onclick="togglePassword('passPasienCreate', 'iconPasienCreate')" 
                                  style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6b7280; z-index: 10;">
                                <i id="iconPasienCreate" class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.pasien.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>