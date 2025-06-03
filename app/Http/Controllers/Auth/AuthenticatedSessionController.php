<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user || !isset($user->role)) {
            Log::error('User authentication failed or role not set', [
                'user_id' => $user?->id,
                'role' => $user?->role ?? 'not set',
            ]);
            return redirect()->route('welcome')->with('error', 'Unable to authenticate user.');
        }

        // Cek apakah email sudah diverifikasi
        if (!$user->hasVerifiedEmail()) {
            Auth::logout(); // Logout user
            return redirect()->route('login')->with('error', 'Silakan verifikasi email Anda terlebih dahulu sebelum login.');
        }

        Log::info('Login redirect decision', [
            'user_id' => $user->id,
            'role' => $user->role,
            'email_verified' => $user->hasVerifiedEmail(),
            'redirect_to' => $user->role === 'dosen' ? 'dashboard' : 'dashboardAdmin',
        ]);

        if ($user->role === 'dosen') {
            return redirect()->route('dashboard');
        } elseif (in_array($user->role, ['admin', 'kepala_unit', 'wakil_dekan'])) {
            return redirect()->route('dashboardAdmin');
        }

        Log::warning('Unexpected user role', [
            'user_id' => $user->id,
            'role' => $user->role,
        ]);
        return redirect()->route('welcome')->with('error', 'Invalid user role.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}