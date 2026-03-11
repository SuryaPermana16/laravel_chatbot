<?php

use Illuminate\Support\Facades\Route;
use App\Models\Dokter;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\ChatbotController;
use App\Models\KnowledgeBase;
use Illuminate\Support\Facades\Http;

// Import Controller Dashboard per Role
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\ObatController;
use App\Http\Controllers\Dashboard\DokterController;
use App\Http\Controllers\Dashboard\PasienController;
use App\Http\Controllers\Dashboard\JadwalDokterController;
use App\Http\Controllers\Dashboard\KelolaKunjunganController;
use App\Http\Controllers\Dashboard\LaporanController;
use App\Http\Controllers\Dashboard\KnowledgeBaseController;
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
Route::get('/', function () {
    // 1. Ambil maksimal 4 dokter terbaru BESERTA JADWALNYA (tambah ->with('jadwals'))
    $dokters = Dokter::with('jadwals')->latest()->take(4)->get();

    // 2. Ambil daftar layanan (mengambil daftar 'spesialis' unik dari tabel dokter)
    $layanans = Dokter::select('spesialis')->distinct()->get();

    return view('welcome', compact('dokters', 'layanans'));
});

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
        
        // [PERBAIKAN DISINI] ------------------------------
        // Cukup tulis '/detail/{id}' dan name('show')
        Route::get('/detail/{id}', 'show')->name('show'); 
        // -------------------------------------------------

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
    // --- LAPORAN (UPDATE INI) ---
    Route::controller(LaporanController::class)->prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', 'index')->name('index');           // Halaman Utama Laporan
        Route::get('/pdf', 'exportPdf')->name('pdf');      // Cetak PDF
        Route::get('/excel', 'exportExcel')->name('excel'); // Download Excel
    });

    // Kelola Admin (SESAMA ADMIN)
    Route::resource('kelola-admin', \App\Http\Controllers\Dashboard\KelolaAdminController::class);

   // ==========================================================
    // Kelola Knowledge Base (FAQ Manual & Upload PDF AI)
    // ==========================================================
    Route::controller(KnowledgeBaseController::class)->prefix('knowledge-base')->name('kb.')->group(function () {
        // Route untuk PDF harus di atas route resource agar tidak tertimpa parameter {id}
        Route::get('/upload-pdf', 'createPdf')->name('create_pdf');
        Route::post('/store-pdf', 'storePdf')->name('store_pdf');
    });
    // Route resource untuk fitur CRUD manual FAQ
    Route::resource('knowledge-base', \App\Http\Controllers\Dashboard\KnowledgeBaseController::class)->names('kb');
});

/*
|--------------------------------------------------------------------------
| 4. GRUP KHUSUS DOKTER
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
    Route::post('/chat-ai/send', [\App\Http\Controllers\User\UserChatbotController::class, 'sendMessage'])->name('chat-ai.send');
});

/*
|--------------------------------------------------------------------------
| 7. PROFILE & AUTH BREEZE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/chatbot/send', [ChatbotController::class, 'handleChat'])->name('chatbot.send');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/update-vektor', function () {
    // VERSI PINTAR: Hanya ambil data yang 'embedding'-nya masih kosong
    $kbs = KnowledgeBase::whereNull('embedding')->orWhere('embedding', '')->get(); 
    $apiKey = env('GEMINI_API_KEY');
    
    if (!$apiKey) return "Error: API Key kosong!";
    if ($kbs->isEmpty()) return "<h3>Aman, Kak! Tidak ada data baru yang butuh di-vektor. Semua data sudah siap tempur. 🚀</h3>";

    $jumlahBerhasil = 0;
    
    foreach ($kbs as $kb) {
        $textToEmbed = "Kategori: " . $kb->kategori . " | Pertanyaan: " . $kb->pertanyaan . " | Jawaban: " . $kb->jawaban;
        
        // Tetap pakai v1beta untuk embedding
        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}", [
            'model' => 'models/gemini-embedding-001',
            'content' => ['parts' => [['text' => $textToEmbed]]]
        ]);

        if ($response->successful()) {
            $vector = $response->json()['embedding']['values'];
            $kb->update(['embedding' => json_encode($vector)]);
            $jumlahBerhasil++;
        } else {
            return "Gagal di ID " . $kb->id . ". Pesan: " . $response->body();
        }
    }
    
    return "<h3>MANTAP! Berhasil mencetak vektor untuk {$jumlahBerhasil} data baru! 🎉</h3>";
});

// Rute untuk mereset ingatan bot (Clear Session)
Route::get('/reset-chat', function () {
    session()->forget('chatbot_memory');
    return "<h1>Ingatan Chatbot berhasil dihapus! 🧹</h1><p>Silakan kembali ke halaman klinik untuk memulai obrolan baru.</p>";
});