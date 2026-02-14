<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    // 1. DAFTAR DOKTER
    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        return view('admin.dokter.create');
    }

    // 3. SIMPAN (USER + DOKTER + TARIF)
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
            'spesialis'    => 'required',
            'no_telepon'   => 'required',
            // [BARU] Validasi Harga Jasa
            'harga_jasa'   => 'required|numeric|min:0', 
        ]);

        DB::transaction(function () use ($request) {
            // Buat Akun User Login
            $user = User::create([
                'name'     => $request->nama_lengkap,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'dokter',
            ]);

            // Buat Data Dokter + Tarif
            Dokter::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'spesialis'    => $request->spesialis,
                'no_telepon'   => $request->no_telepon,
                'harga_jasa'   => $request->harga_jasa, // [BARU] Simpan Harga
            ]);
        });

        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        return view('admin.dokter.edit', compact('dokter'));
    }

    // 5. UPDATE DATABASE (USER + DOKTER + TARIF)
    public function update(Request $request, $id)
    {
        $dokter = Dokter::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'email'        => 'required|email|unique:users,email,' . $dokter->user_id,
            'spesialis'    => 'required',
            'no_telepon'   => 'required',
            // [BARU] Validasi Harga Jasa
            'harga_jasa'   => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $dokter) {
            // Update Data Akun Login
            if($dokter->user) {
                $userData = [
                    'name'  => $request->nama_lengkap,
                    'email' => $request->email,
                ];

                // Cek jika password diganti
                if($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                
                $dokter->user->update($userData);
            }

            // Update Data Profil Dokter + Tarif
            $dokter->update([
                'nama_lengkap' => $request->nama_lengkap,
                'spesialis'    => $request->spesialis,
                'no_telepon'   => $request->no_telepon,
                'harga_jasa'   => $request->harga_jasa, // [BARU] Update Harga
            ]);
        });

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil diperbarui!');
    }

    // 6. HAPUS
    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        
        if($dokter->user) {
            $dokter->user->delete();
        }
        $dokter->delete();

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter dihapus!');
    }
}