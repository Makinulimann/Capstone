<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            Log::info('Profile update started', [
                'user_id' => $request->user()->id,
                'has_file' => $request->hasFile('photo'),
                'request_data' => $request->all(),
            ]);

            $user = $request->user();
            $validated = $request->validated();

            Log::info('Validation passed', ['validated' => $validated]);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                
                Log::info('File details', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'is_valid' => $file->isValid(),
                ]);
                
                // Validate file is actually an image
                if (!$file->isValid()) {
                    Log::error('File is not valid');
                    return redirect()->route('profile.edit')->withErrors(['photo' => 'File upload gagal. Silakan coba lagi.']);
                }

                // Delete old photo if exists
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                    Log::info('Old photo deleted', ['old_photo' => $user->photo]);
                }

                // Create photos directory if it doesn't exist
                if (!Storage::disk('public')->exists('photos')) {
                    Storage::disk('public')->makeDirectory('photos');
                }

                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Store new photo
                $path = $file->storeAs('photos', $filename, 'public');
                
                if (!$path) {
                    Log::error('Failed to store file');
                    return redirect()->route('profile.edit')->withErrors(['photo' => 'Gagal menyimpan foto. Silakan coba lagi.']);
                }
                
                $user->photo = $path;
                Log::info('Photo stored successfully', ['path' => $path]);
            }

            // Save user
            $saved = $user->save();
            Log::info('User save result', ['saved' => $saved, 'user_photo' => $user->photo]);

            if ($saved) {
                return redirect()->route('profile.edit')->with('status', 'Profil berhasil diperbarui.');
            } else {
                Log::error('Failed to save user');
                return redirect()->route('profile.edit')->withErrors(['photo' => 'Gagal menyimpan perubahan.']);
            }

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Profile update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('profile.edit')->withErrors(['photo' => 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete user's photo if exists
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}