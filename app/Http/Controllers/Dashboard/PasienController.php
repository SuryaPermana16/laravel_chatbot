<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\User;
use App\Models\Kunjungan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class PasienController extends Controller
{
    // 1. DAFTAR PASIEN
    public function index()
    {
        $pasiens = Pasien::with('user')->latest()->get();
        return view('admin.pasien.index', compact('pasiens'));
    }

    // 2. DETAIL & RIWAYAT REKAM MEDIS
    public function show($id)
    {
        $pasien = Pasien::with('user')->findOrFail($id);
        $riwayat = Kunjungan::with(['dokter', 'obat'])
                    ->where('pasien_id', $id) 
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

    // 4. SIMPAN (DENGAN NOMOR RM OTOMATIS)
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|min:3',
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
                'no_rm' => Pasien::generateNoRM(), 
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
            'no_rm' => 'required|string|max:50|unique:pasiens,no_rm,' . $pasien->id,
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
                'no_rm' => $request->no_rm,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
            ]);
        });

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil diperbarui!');
    }

    /**
     * 7. HAPUS (DENGAN PROTEKSI DATA TERKAIT)
     */
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);

        try {
            DB::transaction(function () use ($pasien) {
                // Jika menghapus User, maka Pasien otomatis ikut terhapus 
                // karena Kakak sudah pakai onDelete('cascade') di migration.
                if ($pasien->user) {
                    $pasien->user->delete();
                } else {
                    $pasien->delete();
                }
            });

            return redirect()->route('admin.pasien.index')->with('success', 'Data pasien telah dihapus permanen!');

        } catch (Exception $e) {
            // Jika gagal (biasanya karena ada riwayat kunjungan/rekam medis yang mengunci)
            return redirect()->route('admin.pasien.index')->with('error', 'Gagal menghapus! Pasien ini masih memiliki data riwayat medis aktif.');
        }
    }
}