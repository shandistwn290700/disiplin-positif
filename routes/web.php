<?php

use App\Http\Controllers\ForcePasswordController;
use App\Http\Controllers\SummonLetterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DisciplineRecordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () { if (auth()->check()) { return redirect()->route('dashboard'); } return view('welcome'); });

// Route dashboard bawaan Breeze diganti agar langsung redirect ke halaman catatan
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'force-password'])->group(function () {

    Route::get('/ganti-password', [ForcePasswordController::class, 'edit'])->name('force-password.edit');
    Route::post('/ganti-password', [ForcePasswordController::class, 'update'])->name('force-password.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Formulir disiplin — admin & guru (data yang terlihat dibatasi di controller)
    Route::middleware('role:admin,guru')->group(function () {

        // Guru hanya boleh melihat antrian & riwayat surat (dibatasi ke kelasnya sendiri di controller)
        Route::get('/pemanggilan', [SummonLetterController::class, 'index'])->name('summon.index');
        Route::get('/pemanggilan/surat/{letter}', [SummonLetterController::class, 'pdf'])->name('summon.pdf');

        Route::get('/records', [DisciplineRecordController::class, 'index'])->name('records.index');
        Route::get('/records/export/excel', [DisciplineRecordController::class, 'exportExcel'])->name('records.export.excel');
        Route::get('/records/export/pdf', [DisciplineRecordController::class, 'exportPdf'])->name('records.export.pdf');
        Route::get('/records/create', [DisciplineRecordController::class, 'create'])->name('records.create');
        Route::post('/records', [DisciplineRecordController::class, 'store'])->name('records.store');
        Route::delete('/records/{record}', [DisciplineRecordController::class, 'destroy'])->name('records.destroy');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
        Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');

        // Data siswa: admin & guru boleh lihat & cari (dibatasi ke kelasnya untuk guru, lihat controller).
        // Aksi kelola (tambah/ubah/hapus/import) tetap khusus admin di grup middleware terpisah di bawah.
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    });

    // Manajemen data siswa — khusus admin
    Route::middleware('role:admin')->group(function () {

        // Generate surat pemanggilan — khusus admin
        Route::get('/pemanggilan/{student}/buat', [SummonLetterController::class, 'create'])->name('summon.create');
        Route::post('/pemanggilan/{student}/buat', [SummonLetterController::class, 'store'])->name('summon.store');

        Route::post('/settings/welcome-message', [SiteSettingController::class, 'updateWelcomeMessage'])->name('settings.welcome-message');        


        Route::post('/settings/identitas-sekolah', [SiteSettingController::class, 'updateSchoolIdentity'])->name('settings.school-identity');
        Route::get('/classes', [SchoolClassController::class, 'index'])->name('classes.index'); 
        Route::get('/classes/create', [SchoolClassController::class, 'create'])->name('classes.create'); 
        Route::post('/classes', [SchoolClassController::class, 'store'])->name('classes.store'); 
        Route::get('/classes/{class}/edit', [SchoolClassController::class, 'edit'])->name('classes.edit'); 
        Route::put('/classes/{class}', [SchoolClassController::class, 'update'])->name('classes.update'); 
        Route::delete('/classes/{class}', [SchoolClassController::class, 'destroy'])->name('classes.destroy');
        
        Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit'); 
        Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        
        Route::get('/students/import', [StudentController::class, 'importForm'])->name('students.import');
        Route::post('/students/import', [StudentController::class, 'import']);
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    });

    // Manajemen kategori — khusus admin
    Route::middleware('role:admin')->group(function () {

         Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit'); 
        Route::post('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); 
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update'); 

        Route::get('/users', [UserController::class, 'index'])->name('users.index'); 
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); 
        Route::post('/users', [UserController::class, 'store'])->name('users.store'); 
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); 
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        });
});

require __DIR__.'/auth.php';
