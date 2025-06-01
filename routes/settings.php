<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
<<<<<<< HEAD
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
=======
    // Support both PATCH and POST for file uploads
    Route::match(['patch', 'post'], 'settings/profile', [ProfileController::class, 'update'])->name('profile.update');
>>>>>>> Back-End
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance');
<<<<<<< HEAD
});
=======
});
>>>>>>> Back-End
