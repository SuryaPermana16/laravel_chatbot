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
    public function index()
    {
        $apotekers = Apoteker::with('user')->latest()->get();

        return view('admin.apoteker.index', compact('apotekers'));
    }

    public function create()
    {
        return view('admin.apoteker.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:8',
            'no_telepon'   => 'nullable|string|max:20',
            'alamat'       => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->nama_lengkap,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'apoteker',
            ]);

            Apoteker::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'alamat'       => $request->alamat,
                'no_telepon'   => $request->no_telepon,
            ]);
        });

        return redirect()->route('admin.apoteker.index')
            ->with('success', 'Apoteker berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $apoteker = Apoteker::with('user')->findOrFail($id);

        return view('admin.apoteker.edit', compact('apoteker'));
    }

    public function update(Request $request, $id)
    {
        $apoteker = Apoteker::findOrFail($id);
        $user = $apoteker->user;

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_telepon'   => 'nullable|string|max:20',
            'alamat'       => 'nullable|string',
            'password'     => 'nullable|string|min:8',
        ]);

        DB::transaction(function () use ($request, $apoteker, $user) {
            $user->name = $request->nama_lengkap;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            $apoteker->update([
                'nama_lengkap' => $request->nama_lengkap,
                'no_telepon'   => $request->no_telepon,
                'alamat'       => $request->alamat,
            ]);
        });

        return redirect()->route('admin.apoteker.index')
            ->with('success', 'Data Apoteker berhasil diupdate!');
    }

    public function destroy($id)
    {
        $apoteker = Apoteker::findOrFail($id);
        $user_id = $apoteker->user_id;

        DB::transaction(function () use ($apoteker, $user_id) {
            $apoteker->delete();

            if ($user_id) {
                User::destroy($user_id);
            }
        });

        return redirect()->route('admin.apoteker.index')
            ->with('success', 'Data Apoteker beserta akun loginnya berhasil dihapus!');
    }
}