<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    // 1. DAFTAR PASIEN
    public function index()
    {
        // Ambil data pasien + akun loginnya
        $pasiens = Pasien::with('user')->latest()->get();
        return view('admin.pasien.index', compact('pasiens'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        return view('admin.pasien.create');
    }

    // 3. SIMPAN (USER + PASIEN)
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_telepon' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            // A. Buat Akun Login
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien', // Role penting!
            ]);

            // B. Buat Profil Pasien
            Pasien::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
            ]);
        });

        return redirect()->route('admin.pasien.index')->with('success', 'Pasien baru berhasil didaftarkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $pasien = Pasien::with('user')->findOrFail($id);
        return view('admin.pasien.edit', compact('pasien'));
    }

    // 5. UPDATE
    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            // Email unik kecuali punya sendiri
            'email' => 'required|email|unique:users,email,' . $pasien->user_id,
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_telepon' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request, $pasien) {
            // Update User
            if ($pasien->user) {
                $pasien->user->update([
                    'name' => $request->nama_lengkap,
                    'email' => $request->email,
                ]);
                
                // Cek password baru
                if ($request->filled('password')) {
                    $pasien->user->update(['password' => Hash::make($request->password)]);
                }
            }

            // Update Profil Pasien
            $pasien->update([
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
            ]);
        });

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil diperbarui!');
    }

    // 6. HAPUS
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        if ($pasien->user) {
            $pasien->user->delete(); // Hapus akun login juga
        }
        $pasien->delete();

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien dihapus!');
    }
}