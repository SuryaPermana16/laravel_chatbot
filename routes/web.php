<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Import Controller Dashboard per Role
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\ObatController;
use App\Http\Controllers\Dashboard\DokterController;
use App\Http\Controllers\Dashboard\PasienController;
use App\Http\Controllers\Dashboard\JadwalDokterController;
use App\Http\Controllers\Dashboard\KelolaKunjunganController;
use App\Http\Controllers\Dashboard\LaporanController;
use App\Http\Controllers\Dashboard\ApotekerController as AdminKelolaApoteker;

// Import Controller User/Dokter/Apoteker
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\PendaftaranController;
use App\Http\Controllers\Dokter\DashboardController as DokterDashboard;
use App\Http\Controllers\Dokter\PeriksaController;
use App\Http\Controllers\Apoteker\DashboardController as ApotekerDashboard;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('welcome'); });
Route::get('/chatbot', function () { return view('chatbot'); });

/*
|--------------------------------------------------------------------------
| 2. PENGATUR LALU LINTAS (Dashboard Redirector)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'dokter') return redirect()->route('dokter.dashboard');
    if ($role === 'apoteker') return redirect()->route('apoteker.dashboard');
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| 3. GRUP KHUSUS ADMIN (Manajemen Data)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Kelola Obat
    Route::controller(ObatController::class)->prefix('obat')->name('obat.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/tambah', 'create')->name('create');
        Route::post('/simpan', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/hapus/{id}', 'destroy')->name('destroy');
    });

    // Kelola Dokter
    Route::controller(DokterController::class)->prefix('dokter')->name('dokter.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/tambah', 'create')->name('create');
        Route::post('/simpan', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/hapus/{id}', 'destroy')->name('destroy');
    });

    // Kelola Apoteker
    Route::controller(AdminKelolaApoteker::class)->prefix('apoteker')->name('apoteker.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // Kelola Pasien
    Route::controller(PasienController::class)->prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/tambah', 'create')->name('create');
        Route::post('/simpan', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/hapus/{id}', 'destroy')->name('destroy');
    });

    // Kelola Jadwal Dokter
    Route::controller(JadwalDokterController::class)->prefix('jadwal')->name('jadwal.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/tambah', 'create')->name('create');
        Route::post('/simpan', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/hapus/{id}', 'destroy')->name('destroy');
    });

    // Antrean & Laporan
    Route::get('/kunjungan', [KelolaKunjunganController::class, 'index'])->name('kunjungan.index');
    Route::patch('/kunjungan/{id}/status', [KelolaKunjunganController::class, 'updateStatus'])->name('kunjungan.updateStatus');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
});

/*
|--------------------------------------------------------------------------
| 4. GRUP KHUSUS DOKTER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterDashboard::class, 'index'])->name('dashboard');
    Route::get('/periksa/{id}', [PeriksaController::class, 'periksa'])->name('periksa');
    Route::post('/periksa/{id}', [PeriksaController::class, 'simpanPeriksa'])->name('periksa.simpan');
});

/*
|--------------------------------------------------------------------------
| 5. GRUP KHUSUS APOTEKER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::get('/dashboard', [ApotekerDashboard::class, 'index'])->name('dashboard');
    // Proses Serahkan Obat (Mengubah status menjadi 'diambil')
    Route::patch('/dashboard/{id}/selesai', [ApotekerDashboard::class, 'selesai'])->name('selesai');
    // 1. ROUTE TAMBAHAN UNTUK UPDATE STOK CEPAT DI DASHBOARD (WAJIB ADA)
    Route::patch('/obat/{id}/update-stok', [App\Http\Controllers\Apoteker\ObatController::class, 'updateStok'])->name('obat.updateStok');

    // 2. Resource Controller untuk Halaman Kelola Obat Lengkap
    Route::resource('obat', App\Http\Controllers\Apoteker\ObatController::class);
});

/*
|--------------------------------------------------------------------------
| 6. GRUP KHUSUS PASIEN / USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
    Route::get('/daftar/{id_jadwal}', [PendaftaranController::class, 'showForm'])->name('daftar');
    Route::post('/daftar/{id_jadwal}', [PendaftaranController::class, 'store'])->name('daftar.store');
});

/*
|--------------------------------------------------------------------------
| 7. PROFILE & AUTH BREEZE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';