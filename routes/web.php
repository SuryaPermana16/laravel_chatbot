<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Controller Admin
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\ObatController;
use App\Http\Controllers\Dashboard\DokterController;
use App\Http\Controllers\Dashboard\PasienController;
use App\Http\Controllers\Dashboard\JadwalDokterController;
use App\Http\Controllers\Dashboard\KelolaKunjunganController;
use App\Http\Controllers\Dashboard\LaporanController;

// Controller User (Pasien)
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\PendaftaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN PUBLIK
Route::get('/', function () {
    return view('welcome');
});

Route::get('/chatbot', function () {
    return view('chatbot');
});


// 2. "POLISI LALU LINTAS" (Traffic Police)
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('user.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// 3. GRUP KHUSUS PASIEN / USER
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Pasien
    Route::get('/user/dashboard', [UserDashboard::class, 'index'])->name('user.dashboard');

    // === TAMBAHAN 2: RUTE PENDAFTARAN / BOOKING ===
    // Menampilkan Form Pendaftaran
    Route::get('/user/daftar/{id_jadwal}', [PendaftaranController::class, 'showForm'])->name('user.daftar');
    
    // Memproses Data Pendaftaran (Simpan ke Database)
    Route::post('/user/daftar/{id_jadwal}', [PendaftaranController::class, 'store'])->name('user.daftar.store');

});


// 4. GRUP KHUSUS ADMIN
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // === MANAJEMEN OBAT ===
    Route::get('/admin/obat', [ObatController::class, 'index'])->name('admin.obat.index');
    Route::get('/admin/obat/tambah', [ObatController::class, 'create'])->name('admin.obat.create');
    Route::post('/admin/obat/simpan', [ObatController::class, 'store'])->name('admin.obat.store');
    Route::get('/admin/obat/edit/{id}', [ObatController::class, 'edit'])->name('admin.obat.edit');
    Route::put('/admin/obat/update/{id}', [ObatController::class, 'update'])->name('admin.obat.update');
    Route::delete('/admin/obat/hapus/{id}', [ObatController::class, 'destroy'])->name('admin.obat.destroy');

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

    // === MANAJEMEN JADWAL DOKTER ===
    Route::get('/admin/jadwal', [JadwalDokterController::class, 'index'])->name('admin.jadwal.index');
    Route::get('/admin/jadwal/tambah', [JadwalDokterController::class, 'create'])->name('admin.jadwal.create');
    Route::post('/admin/jadwal/simpan', [JadwalDokterController::class, 'store'])->name('admin.jadwal.store');
    Route::get('/admin/jadwal/edit/{id}', [JadwalDokterController::class, 'edit'])->name('admin.jadwal.edit');
    Route::put('/admin/jadwal/update/{id}', [JadwalDokterController::class, 'update'])->name('admin.jadwal.update');
    Route::delete('/admin/jadwal/hapus/{id}', [JadwalDokterController::class, 'destroy'])->name('admin.jadwal.destroy');

    // Route Kelola Antrean
    Route::get('/admin/kunjungan', [KelolaKunjunganController::class, 'index'])->name('admin.kunjungan.index');
    Route::patch('/admin/kunjungan/{id}/status', [KelolaKunjunganController::class, 'updateStatus'])->name('admin.kunjungan.updateStatus');

    // === ROUTE LAPORAN PDF ===
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::post('/admin/laporan/cetak', [LaporanController::class, 'cetak'])->name('admin.laporan.cetak');

});


// 5. GRUP PROFILE (Bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';