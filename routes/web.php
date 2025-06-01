<?php

<<<<<<< HEAD
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('LandingPage'); 
})->name('LandingPage');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
=======
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PengajuanMasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

// Guest Routes
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Dosen Routes
Route::middleware(['auth', 'verified', 'role:dosen'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/track', [DashboardController::class, 'track'])->name('dashboard.track');
    Route::get('/pengajuan', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/sertifikasi', [PengajuanController::class, 'index'])->name('sertifikasi.index');
});

// Admin, Kepala Unit, Wakil Dekan Routes
Route::middleware(['auth', 'verified', 'role:admin,kepala_unit,wakil_dekan'])->group(function () {
    Route::get('/admin/dashboardadmin', [AdminController::class, 'index'])->name('dashboardAdmin');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/pengajuan', [PengajuanMasukController::class, 'index'])->name('admin.pengajuan');
    Route::get('/admin/pengajuan/{id}', [PengajuanMasukController::class, 'show'])->name('admin.pengajuan.show');
    Route::post('/admin/pengajuan/{id}/update', [PengajuanMasukController::class, 'update'])->name('admin.pengajuan.update');
    Route::post('/admin/pengajuan/{id}/note', [PengajuanMasukController::class, 'addNote'])->name('admin.pengajuan.note');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
>>>>>>> Back-End
