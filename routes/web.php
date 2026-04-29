<?php

use Illuminate\Support\Facades\Route;
use App\Models\Dokter;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\ChatbotController;
use App\Models\KnowledgeBase;
use Illuminate\Support\Facades\Http;

// Controller Admin
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\ObatController;
use App\Http\Controllers\Dashboard\DokterController;
use App\Http\Controllers\Dashboard\PasienController;
use App\Http\Controllers\Dashboard\JadwalDokterController;
use App\Http\Controllers\Dashboard\KelolaKunjunganController;
use App\Http\Controllers\Dashboard\LaporanController;
use App\Http\Controllers\Dashboard\KnowledgeBaseController;
use App\Http\Controllers\Dashboard\ApotekerController as AdminKelolaApoteker;

// Controller Role
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\PendaftaranController;
use App\Http\Controllers\Dokter\DashboardController as DokterDashboard;
use App\Http\Controllers\Dokter\PeriksaController;
use App\Http\Controllers\Apoteker\DashboardController as ApotekerDashboard;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $dokters = Dokter::with('jadwals')->latest()->take(10)->get();
    $layanans = Dokter::select('spesialis')->distinct()->get();

    return view('welcome', compact('dokters', 'layanans'));
});

/*
|--------------------------------------------------------------------------
| REDIRECT DASHBOARD SESUAI ROLE
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
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Obat
    Route::controller(ObatController::class)->prefix('obat')->name('obat.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/tambah', 'create')->name('create');
        Route::post('/simpan', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/hapus/{id}', 'destroy')->name('destroy');
    });

    // Dokter
    Route::controller(DokterController::class)->prefix('dokter')->name('dokter.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/tambah', 'create')->name('create');
        Route::post('/simpan', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/hapus/{id}', 'destroy')->name('destroy');
    });

    // Apoteker
    Route::controller(AdminKelolaApoteker::class)->prefix('apoteker')->name('apoteker.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // Pasien
    Route::controller(PasienController::class)->prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/tambah', 'create')->name('create');
        Route::post('/simpan', 'store')->name('store');
        Route::get('/detail/{id}', 'show')->name('show');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/hapus/{id}', 'destroy')->name('destroy');
    });

    // Jadwal Dokter
    Route::controller(JadwalDokterController::class)->prefix('jadwal')->name('jadwal.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/tambah', 'create')->name('create');
        Route::post('/simpan', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/hapus/{id}', 'destroy')->name('destroy');
    });

    // Kunjungan
    Route::get('/kunjungan', [KelolaKunjunganController::class, 'index'])->name('kunjungan.index');
    Route::patch('/kunjungan/{id}/status', [KelolaKunjunganController::class, 'updateStatus'])->name('kunjungan.updateStatus');

    // Laporan
    Route::controller(LaporanController::class)->prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/pdf', 'exportPdf')->name('pdf');
        Route::get('/excel', 'exportExcel')->name('excel');
    });

    // Admin
    Route::resource('kelola-admin', \App\Http\Controllers\Dashboard\KelolaAdminController::class);

    // Knowledge Base
    Route::controller(KnowledgeBaseController::class)->prefix('knowledge-base')->name('kb.')->group(function () {
        Route::get('/upload-pdf', 'createPdf')->name('create_pdf');
        Route::post('/store-pdf', 'storePdf')->name('store_pdf');
        Route::post('/sync-database', 'syncDatabaseToAI')->name('sync_database');
    });

    Route::resource('knowledge-base', KnowledgeBaseController::class)->names('kb');
});

/*
|--------------------------------------------------------------------------
| DOKTER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterDashboard::class, 'index'])->name('dashboard');
    Route::get('/api/count-pasien', [DokterDashboard::class, 'getCountPasien'])->name('api.count');
    Route::get('/periksa/{id}', [PeriksaController::class, 'periksa'])->name('periksa');
    Route::post('/periksa/{id}', [PeriksaController::class, 'simpanPeriksa'])->name('periksa.simpan');
});

/*
|--------------------------------------------------------------------------
| APOTEKER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::get('/dashboard', [ApotekerDashboard::class, 'index'])->name('dashboard');
    Route::patch('/dashboard/{id}/selesai', [ApotekerDashboard::class, 'selesai'])->name('selesai');
    Route::patch('/obat/{id}/update-stok', [App\Http\Controllers\Apoteker\ObatController::class, 'updateStok'])->name('obat.updateStok');
    Route::resource('obat', App\Http\Controllers\Apoteker\ObatController::class);
});

/*
|--------------------------------------------------------------------------
| USER / PASIEN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
    Route::get('/daftar/{id_jadwal}', [PendaftaranController::class, 'showForm'])->name('daftar');
    Route::post('/daftar/{id_jadwal}', [PendaftaranController::class, 'store'])->name('daftar.store');
    Route::post('/chat-ai/send', [\App\Http\Controllers\User\UserChatbotController::class, 'sendMessage'])->name('chat-ai.send');
});

/*
|--------------------------------------------------------------------------
| PROFILE & AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/chatbot/send', [ChatbotController::class, 'handleChat'])->name('chatbot.send');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| TOOL DEBUG (VEKTOR AI)
|--------------------------------------------------------------------------
*/
Route::get('/update-vektor', function () {
    $kbs = KnowledgeBase::whereNull('embedding')->orWhere('embedding', '')->get();
    $apiKey = env('GEMINI_API_KEY');

    if (!$apiKey) return "API Key kosong";
    if ($kbs->isEmpty()) return "Tidak ada data baru";

    foreach ($kbs as $kb) {
        $text = "Kategori: {$kb->kategori} | Pertanyaan: {$kb->pertanyaan} | Jawaban: {$kb->jawaban}";

        $res = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}", [
            'model' => 'models/gemini-embedding-001',
            'content' => ['parts' => [['text' => $text]]]
        ]);

        if ($res->successful()) {
            $kb->update(['embedding' => json_encode($res->json()['embedding']['values'])]);
        }
    }

    return "Update selesai";
});

/*
|--------------------------------------------------------------------------
| RESET CHAT
|--------------------------------------------------------------------------
*/
Route::get('/reset-chat', function () {
    session()->forget('chatbot_memory');
    return "Chat reset";
});