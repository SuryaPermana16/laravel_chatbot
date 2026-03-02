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
    /**
     * Menampilkan halaman registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Menangani permintaan registrasi masuk.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input dengan pesan yang jelas
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'no_telepon'    => ['required', 'string', 'min:10', 'max:15'],
            'alamat'        => ['required', 'string', 'min:3'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Jalankan transaksi database agar data User & Pasien tersimpan sekaligus (aman)
        DB::transaction(function () use ($request) {
            
            // A. Buat Akun Login (Role otomatis Pasien)
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'pasien',
            ]);

            // B. Buat Data Biodata Pasien & Generate No RM Otomatis
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

        // 3. Redirect ke login dengan sinyal "success" untuk memicu popup SweetAlert2
        return redirect()->route('login')->with('success', 'Akun Anda berhasil dibuat! Silakan masuk menggunakan Email dan Password.');
    }
}