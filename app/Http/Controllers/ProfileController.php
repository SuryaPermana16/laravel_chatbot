<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Apoteker;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($user->role === 'pasien') {
            Pasien::where('user_id', $user->id)->update([
                'nama_lengkap' => $user->name
            ]);
        } elseif ($user->role === 'dokter') {
            Dokter::where('user_id', $user->id)->update([
                'nama_lengkap' => $user->name
            ]);
        } elseif ($user->role === 'apoteker') {
            Apoteker::where('user_id', $user->id)->update([
                'nama_lengkap' => $user->name
            ]);
        }

        return Redirect::route('profile.edit')
            ->with('success', 'Data Profil Berhasil Diperbarui!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}