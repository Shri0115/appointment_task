<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;


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
    public function store(Request $request)
    {
        // Validate the user's credentials and log them in.
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();

            // Check user's role and redirect accordingly
            $role = Auth::user()->role;

            if ($role == 'doctor') {
                return redirect()->route('doctor.dashboard');
            } elseif ($role == 'patient') {
                return redirect()->route('patient.book');
            }

            // Default fallback, just in case
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // If authentication fails
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/welcome');
    }
}
