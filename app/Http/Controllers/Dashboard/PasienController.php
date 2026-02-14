<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\User;
use App\Models\Kunjungan; // Import Model Kunjungan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    // 1. DAFTAR PASIEN
    public function index()
    {
        $pasiens = Pasien::with('user')->latest()->get();
        return view('admin.pasien.index', compact('pasiens'));
    }

    // [BARU] 2. DETAIL & RIWAYAT REKAM MEDIS
    public function show($id)
    {
        // Ambil data pasien
        $pasien = Pasien::with('user')->findOrFail($id);

        // Ambil Riwayat Kunjungan (Status Selesai/Diambil)
        $riwayat = Kunjungan::with(['dokter', 'obat'])
                    ->where('pasien_id', $id) // <--- PERBAIKAN DISINI (Ganti id_pasien jadi pasien_id)
                    ->whereIn('status', ['selesai', 'diambil']) 
                    ->latest()
                    ->get();

        return view('admin.pasien.show', compact('pasien', 'riwayat'));
    }

    // 3. FORM TAMBAH
    public function create()
    {
        return view('admin.pasien.create');
    }

    // 4. SIMPAN
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
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien',
            ]);

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

    // 5. FORM EDIT
    public function edit($id)
    {
        $pasien = Pasien::with('user')->findOrFail($id);
        return view('admin.pasien.edit', compact('pasien'));
    }

    // 6. UPDATE
    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pasien->user_id,
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_telepon' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request, $pasien) {
            if ($pasien->user) {
                $userData = [
                    'name' => $request->nama_lengkap,
                    'email' => $request->email,
                ];
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                $pasien->user->update($userData);
            }

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

    // 7. HAPUS
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        if ($pasien->user) {
            $pasien->user->delete();
        }
        $pasien->delete();

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien dihapus!');
    }
}