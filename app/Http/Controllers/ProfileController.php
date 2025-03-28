<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $qrData = $this->generateQRData($user);
        
        return view('profile.edit', [
            'user' => $user,
            'qrData' => $qrData
        ]);
    }

    public function editInfo(Request $request): View
    {
        return view('profile.edit-info', [
            'user' => $request->user(),
        ]);
    }

    public function editSecurity(Request $request): View
    {
        return view('profile.edit-security', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $request->user()->fill([
            'name' => $request->name,
        ]);

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Profile berhasil diperbarui');
    }

    /**
     * Update the user's email and password.
     */
    public function updateEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'current_password' => ['required', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        
        // Update email
        $user->email = $request->email;
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Email dan password berhasil diperbarui');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Generate QR code data untuk pengguna.
     *
     * @param  \App\Models\User  $user
     * @return string
     */
    private function generateQRData($user)
    {
        // Format sederhana: user:{user_id}
        return "user:{$user->id}";
    }
}
