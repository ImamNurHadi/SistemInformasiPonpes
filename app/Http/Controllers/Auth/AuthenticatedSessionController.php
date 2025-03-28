<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Santri;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Coba login dengan email
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Jika gagal, coba cari user berdasarkan NIS
        $santri = Santri::where('nis', $credentials['email'])->first();
        
        if ($santri && $santri->user) {
            // Coba login dengan email yang terkait dengan NIS
            if (Auth::attempt([
                'email' => $santri->user->email,
                'password' => $credentials['password']
            ])) {
                $request->session()->regenerate();
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }

        // Jika gagal, coba cari berdasarkan username koperasi
        $koperasi = DB::table('data_koperasis')->where('username', $credentials['email'])->first();
        if ($koperasi && $koperasi->user_id) {
            $user = User::find($koperasi->user_id);
            if ($user) {
                if (Auth::attempt([
                    'email' => $user->email,
                    'password' => $credentials['password']
                ])) {
                    $request->session()->regenerate();
                    return redirect()->intended(RouteServiceProvider::HOME);
                }
            }
        }

        // Jika gagal, coba cari berdasarkan username supplier
        $supplier = DB::table('suppliers')->where('username', $credentials['email'])->first();
        if ($supplier && $supplier->user_id) {
            $user = User::find($supplier->user_id);
            if ($user) {
                if (Auth::attempt([
                    'email' => $user->email,
                    'password' => $credentials['password']
                ])) {
                    $request->session()->regenerate();
                    return redirect()->intended(RouteServiceProvider::HOME);
                }
            }
        }

        return back()->withErrors([
            'email' => 'Email/Username/NIS atau password salah.',
        ])->onlyInput('email');
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
