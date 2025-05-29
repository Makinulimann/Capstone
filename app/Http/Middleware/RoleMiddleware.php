<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        // Log unauthorized access attempt
        Log::warning('Unauthorized role access attempt', [
            'user_id' => $user?->id,
            'required_roles' => $roles,
            'user_role' => $user?->role ?? 'not set',
        ]);

        // Fallback redirect for unauthorized access
        return redirect()->route('welcome')->with('error', 'Unauthorized access.');
    }
}