<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('LandingPage'); 
})->name('LandingPage');

Route::get('/login', function () {
    return Inertia::render('Login'); 
})->name('Login');

Route::get('/register', function () {
    return Inertia::render('Register'); 
})->name('Register');

Route::get('/forgotpassword', function () {
    return Inertia::render('ForgotPassword'); 
})->name('ForgotPassword');

Route::get('/verifyemail', function () {
    return Inertia::render('VerifyEmail'); 
})->name('VerifyEmail');

Route::get('/profile', function () {
    return Inertia::render('Profile'); 
})->name('Profile');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard'); 
})->name('Dashboard');

Route::get('/sertifikasi', function () {
    return Inertia::render('Sertifikasi'); 
})->name('Sertifikasi');

Route::get('/pengajuan', function () {
    return Inertia::render('Pengajuan'); 
})->name('Pengajuan');

Route::get('/profileadm', function () {
    return Inertia::render('ProfileAdm'); 
})->name('ProfileAdm');

Route::get('/permohonan', function () {
    return Inertia::render('Permohonan'); 
})->name('Permohonan');

Route::get('/dashboardadm', function () {
    return Inertia::render('DashboardAdm'); 
})->name('DashboardAdm');

Route::get('/persetujuan', function () {
    return Inertia::render('Persetujuan'); 
})->name('Persetujuan');

Route::get('/statistik', function () {
    return Inertia::render('Statistik'); 
})->name('Statistik');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
