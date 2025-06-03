<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        $credentials = $request->only('email', 'password');
    
        // Hapus session redirect sebelumnya
        $request->session()->forget('url.intended');
    
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect('/admin/dashboard');
        }
    
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect('/user/dashboard');
        }
    
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
    


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
    
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('url.intended');
    
        return redirect('/login');
    }

}
