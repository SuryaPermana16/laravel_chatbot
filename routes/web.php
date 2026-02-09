<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\ObatController;
use App\Http\Controllers\Dashboard\DokterController;
use App\Http\Controllers\Dashboard\PasienController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// GRUP ROUTE PROFILE (Bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ROUTE CHATBOT (DITUTUP DISINI DENGAN BENAR)
Route::get('/chatbot', function () {
    return view('chatbot');
}); // <--- PERHATIKAN: Tanda kurung kurawal & titik koma ini PENTING!

// ==========================================
// GRUP KHUSUS ADMIN (Sekarang sudah di luar Chatbot)
// ==========================================
// Catatan: Saya ubah middleware jadi ['auth'] dulu biar tidak error 
// karena kita belum buat middleware 'role:admin'.
Route::middleware(['auth'])->group(function () {
    
    // Halaman Utama Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // === MANAJEMEN OBAT ===
    Route::get('/admin/obat', [ObatController::class, 'index'])->name('admin.obat.index');
    Route::get('/admin/obat/tambah', [ObatController::class, 'create'])->name('admin.obat.create');
    Route::post('/admin/obat/simpan', [ObatController::class, 'store'])->name('admin.obat.store');
    
    Route::get('/admin/obat/edit/{id}', [ObatController::class, 'edit'])->name('admin.obat.edit');
    Route::put('/admin/obat/update/{id}', [ObatController::class, 'update'])->name('admin.obat.update');
    Route::delete('/admin/obat/hapus/{id}', [ObatController::class, 'destroy'])->name('admin.obat.destroy');
});
// === MANAJEMEN DOKTER ===
Route::get('/admin/dokter', [DokterController::class, 'index'])->name('admin.dokter.index');
Route::get('/admin/dokter/tambah', [DokterController::class, 'create'])->name('admin.dokter.create');
Route::post('/admin/dokter/simpan', [DokterController::class, 'store'])->name('admin.dokter.store');
Route::get('/admin/dokter/edit/{id}', [DokterController::class, 'edit'])->name('admin.dokter.edit');
Route::put('/admin/dokter/update/{id}', [DokterController::class, 'update'])->name('admin.dokter.update');
Route::delete('/admin/dokter/hapus/{id}', [DokterController::class, 'destroy'])->name('admin.dokter.destroy');

// === MANAJEMEN PASIEN ===
Route::get('/admin/pasien', [PasienController::class, 'index'])->name('admin.pasien.index');
Route::get('/admin/pasien/tambah', [PasienController::class, 'create'])->name('admin.pasien.create');
Route::post('/admin/pasien/simpan', [PasienController::class, 'store'])->name('admin.pasien.store');
Route::get('/admin/pasien/edit/{id}', [PasienController::class, 'edit'])->name('admin.pasien.edit');
Route::put('/admin/pasien/update/{id}', [PasienController::class, 'update'])->name('admin.pasien.update');
Route::delete('/admin/pasien/hapus/{id}', [PasienController::class, 'destroy'])->name('admin.pasien.destroy');

require __DIR__.'/auth.php';