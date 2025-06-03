<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Show the email verification prompt page.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        // Jika user sudah verifikasi email, logout dan redirect ke login
        if ($request->user()->hasVerifiedEmail()) {
            Auth::logout();
            return redirect()->route('login')->with('status', 'Email sudah terverifikasi. Silakan login.');
        }

        // Tampilkan halaman verify email
        return Inertia::render('auth/VerifyEmail', [
            'status' => $request->session()->get('status')
        ]);
    }
}