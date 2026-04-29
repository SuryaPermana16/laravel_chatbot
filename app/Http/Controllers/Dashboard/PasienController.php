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
    public function index(Request $request)
    {
        $search = $request->search;

        $pasiens = Pasien::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('no_rm', 'like', '%' . $search . '%')
                    ->orWhere('no_telepon', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('email', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        return view('admin.pasien.index', compact('pasiens', 'search'));
    }

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

    public function create()
    {
        return view('admin.pasien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string|min:3',
            'no_telepon'    => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->nama_lengkap,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'pasien',
            ]);

            Pasien::create([
                'user_id'       => $user->id,
                'no_rm'         => Pasien::generateNoRM(),
                'nama_lengkap'  => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat'        => $request->alamat,
                'no_telepon'    => $request->no_telepon,
            ]);
        });

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Pasien baru berhasil didaftarkan!');
    }

    public function edit($id)
    {
        $pasien = Pasien::with('user')->findOrFail($id);

        return view('admin.pasien.edit', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $request->validate([
            'no_rm'         => 'required|string|max:50|unique:pasiens,no_rm,' . $pasien->id,
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $pasien->user_id,
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'no_telepon'    => 'required|numeric',
            'berat_badan'   => 'nullable|numeric|min:1|max:300',
            'tinggi_badan'  => 'nullable|numeric|min:30|max:250',
            'tensi_darah'   => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($request, $pasien) {
            if ($pasien->user) {
                $userData = [
                    'name'  => $request->nama_lengkap,
                    'email' => $request->email,
                ];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $pasien->user->update($userData);
            }

            $pasien->update([
                'no_rm'         => $request->no_rm,
                'nama_lengkap'  => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat'        => $request->alamat,
                'no_telepon'    => $request->no_telepon,
                'berat_badan'   => $request->berat_badan,
                'tinggi_badan'  => $request->tinggi_badan,
                'tensi_darah'   => $request->tensi_darah,
            ]);
        });

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);

        try {
            DB::transaction(function () use ($pasien) {
                if ($pasien->user) {
                    $pasien->user->delete();
                } else {
                    $pasien->delete();
                }
            });

            return redirect()->route('admin.pasien.index')
                ->with('success', 'Data pasien telah dihapus permanen!');
        } catch (Exception $e) {
            return redirect()->route('admin.pasien.index')
                ->with('error', 'Gagal menghapus! Pasien ini masih memiliki data riwayat medis aktif.');
        }
    }
}