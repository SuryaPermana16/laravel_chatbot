<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KelolaAdminController extends Controller
{
    public function index()
    {
        // Ambil semua user yang rolenya 'admin'
        $admins = User::where('role', 'admin')->latest()->get();
        return view('admin.kelola_admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.kelola_admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Set role otomatis jadi admin
        ]);

        return redirect()->route('admin.kelola-admin.index')->with('success', 'Admin baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.kelola_admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.kelola-admin.index')->with('success', 'Data admin berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cegah admin menghapus dirinya sendiri
        if (Auth::id() == $id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.kelola-admin.index')->with('success', 'Admin berhasil dihapus!');
    }
}