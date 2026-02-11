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
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // 1. Cek role user yang baru login
        $role = $request->user()->role; 

        // 2. Arahkan ke dashboard masing-masing sesuai role
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'dokter') {
            return redirect()->route('dokter.dashboard');
        } elseif ($role === 'apoteker') {
            return redirect()->route('apoteker.dashboard'); 
        }

        // 3. Default redirect untuk pasien/user biasa
        // (Jika terjadi error Route [user.dashboard] not defined, 
        // ubah menjadi return redirect()->route('dashboard'); sesuai bawaan awal)
        return redirect()->route('user.dashboard'); 
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}