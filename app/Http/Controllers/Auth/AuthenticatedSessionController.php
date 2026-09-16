<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('index');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Debugging statement
        \Log::info('User Role: ' . $user->role);

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->intended('admin/dashboard');
        } elseif ($user->role === 'supervisor') {
            return redirect()->intended('supervisor/dashboard');
        }

        return redirect()->intended('dashboard'); // Default redirection
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}