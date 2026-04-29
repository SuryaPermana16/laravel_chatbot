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
    public function index()
    {
        $dokters = Dokter::with('user')->get();

        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        return view('admin.dokter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
            'spesialis'    => 'required',
            'no_telepon'   => 'required',
            'harga_jasa'   => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->nama_lengkap,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'dokter',
            ]);

            Dokter::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'spesialis'    => $request->spesialis,
                'no_telepon'   => $request->no_telepon,
                'harga_jasa'   => $request->harga_jasa,
            ]);
        });

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Dokter berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);

        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, $id)
    {
        $dokter = Dokter::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'email'        => 'required|email|unique:users,email,' . $dokter->user_id,
            'spesialis'    => 'required',
            'no_telepon'   => 'required',
            'harga_jasa'   => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $dokter) {
            if ($dokter->user) {
                $userData = [
                    'name'  => $request->nama_lengkap,
                    'email' => $request->email,
                ];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $dokter->user->update($userData);
            }

            $dokter->update([
                'nama_lengkap' => $request->nama_lengkap,
                'spesialis'    => $request->spesialis,
                'no_telepon'   => $request->no_telepon,
                'harga_jasa'   => $request->harga_jasa,
            ]);
        });

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);

        if ($dokter->user) {
            $dokter->user->delete();
        }

        $dokter->delete();

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter dihapus!');
    }
}