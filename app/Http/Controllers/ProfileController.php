<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// Import semua model yang terkait dengan User
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Apoteker;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update data profil user dan sinkronisasi ke tabel terkait.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 1. Simpan perubahan ke tabel 'users'
        $user->save();

        // 2. Sinkronisasi nama ke tabel Biodata masing-masing Role
        if ($user->role === 'pasien') {
            Pasien::where('user_id', $user->id)->update([
                'nama_lengkap' => $user->name
            ]);
        } 
        elseif ($user->role === 'dokter') {
            Dokter::where('user_id', $user->id)->update([
                'nama_lengkap' => $user->name
            ]);
        }
        elseif ($user->role === 'apoteker') {
            Apoteker::where('user_id', $user->id)->update([
                'nama_lengkap' => $user->name
            ]);
        }
        

        // Menggunakan session 'success' agar muncul Popup SweetAlert2 yang keren!
        return Redirect::route('profile.edit')->with('success', 'Data Profil Berhasil Diperbarui!');
    }

    /**
     * Hapus akun user permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Ini akan otomatis menghapus biodata Pasien/Dokter juga 
        // asalkan di file migration-nya sudah pakai onDelete('cascade')
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}