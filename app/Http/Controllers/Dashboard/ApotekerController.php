<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Apoteker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ApotekerController extends Controller
{
    // 1. Tampilkan Daftar Apoteker
    public function index()
    {
        $apotekers = Apoteker::with('user')->latest()->get();
        return view('admin.apoteker.index', compact('apotekers'));
    }

    // 2. Tampilkan Form Tambah
    public function create()
    {
        return view('admin.apoteker.create');
    }

    // 3. Simpan Data Apoteker Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // A. Buat Akun Login (User)
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'apoteker',
            ]);

            // B. Buat Profil Apoteker
            Apoteker::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
            ]);
        });

        return redirect()->route('admin.apoteker.index')->with('success', 'Apoteker berhasil ditambahkan!');
    }

    // 4. Tampilkan Form Edit
    public function edit($id)
    {
        $apoteker = Apoteker::with('user')->findOrFail($id);
        return view('admin.apoteker.edit', compact('apoteker'));
    }

    // 5. Simpan Perubahan (Update)
    public function update(Request $request, $id)
    {
        $apoteker = Apoteker::findOrFail($id);
        $user = $apoteker->user;

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            // Pastikan email unik, KECUALI untuk user ini sendiri
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, 
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'nullable|string|min:8', // Boleh kosong
        ]);

        DB::transaction(function () use ($request, $apoteker, $user) {
            // Update akun user
            $user->name = $request->nama_lengkap;
            $user->email = $request->email;
            
            // Jika kolom password diisi, maka update passwordnya
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Update profil apoteker
            $apoteker->update([
                'nama_lengkap' => $request->nama_lengkap,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
            ]);
        });

        return redirect()->route('admin.apoteker.index')->with('success', 'Data Apoteker berhasil diupdate!');
    }

    // 6. Hapus Data Apoteker
    public function destroy($id)
    {
        // Cari data apoteker yang mau dihapus
        $apoteker = Apoteker::findOrFail($id);
        
        // Simpan ID User-nya sebelum apotekernya dihapus
        $user_id = $apoteker->user_id;

        // Gunakan DB Transaction agar aman
        DB::transaction(function () use ($apoteker, $user_id) {
            // Hapus profil apotekernya
            $apoteker->delete();

            // Hapus juga akun login (User) nya agar tidak jadi data sampah
            if ($user_id) {
                User::destroy($user_id);
            }
        });

        // Kembalikan ke halaman index dengan pesan sukses
        return redirect()->route('admin.apoteker.index')->with('success', 'Data Apoteker beserta akun loginnya berhasil dihapus!');
    }
}