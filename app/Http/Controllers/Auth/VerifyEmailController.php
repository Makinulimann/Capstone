<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Jika sudah terverifikasi, logout dan redirect ke login
            Auth::logout();
            return redirect()->route('login')->with('status', 'Email sudah terverifikasi. Silakan login.');
        }

        if ($request->user()->markEmailAsVerified()) {
            /** @var \Illuminate\Contracts\Auth\MustVerifyEmail $user */
            $user = $request->user();
            event(new Verified($user));
        }

        // Logout user setelah verifikasi
        Auth::logout();
        
        // Regenerate session untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Email berhasil diverifikasi! Silakan login untuk melanjutkan.');
    }
}