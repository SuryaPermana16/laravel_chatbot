<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pasien;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'no_telepon'    => ['required', 'string', 'min:10', 'max:15'],
            'alamat'        => ['required', 'string', 'min:3'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'pasien',
            ]);

            Pasien::create([
                'user_id'       => $user->id,
                'no_rm'         => Pasien::generateNoRM(),
                'nama_lengkap'  => $request->name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat'        => $request->alamat,
                'no_telepon'    => $request->no_telepon,
            ]);

            event(new Registered($user));
        });

        return redirect()->route('login')
            ->with('success', 'Akun Anda berhasil dibuat! Silakan masuk menggunakan Email dan Password.');
    }
}