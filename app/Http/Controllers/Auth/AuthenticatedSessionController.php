<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $role = $request->user()->role; 
        $name = $request->user()->name;

        // Tambahkan pesan sukses login di setiap redirect
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('login_success', "Selamat Datang Kembali, Admin $name! 👋");
        } elseif ($role === 'dokter') {
            return redirect()->route('dokter.dashboard')
                ->with('login_success', "Selamat Datang Kembali, Dr. $name! 👨‍⚕️");
        } elseif ($role === 'apoteker') {
            return redirect()->route('apoteker.dashboard')
                ->with('login_success', "Selamat Datang Kembali, Apoteker $name! 💊");
        }

        return redirect()->route('user.dashboard')
            ->with('login_success', "Halo $name, selamat datang di portal kesehatan Anda! ✨"); 
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}