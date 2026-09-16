<?php

// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('index'); // index.blade.php is your login page
    }

    public function login(Request $request)
    {
        $remember = $request->has('remember'); // Check if "Remember Me" is checked
        $username = $request->input('username');
        $password = $request->input('password');
    
        // Case 1: If "Remember Me" is checked
        if ($remember) {
            // If only the username is provided
            if (!empty($username)) {
                $user = User::where('userName', $username)->first();
    
                if ($user && !empty($user->remember_token)) {
                    // Log in using remember token
                    Auth::login($user, true);
                    \Log::info('User authenticated via remember token (username-only):', ['user' => $user->toArray()]);
                    return $this->redirectBasedOnRole($user);
                }
            }
    
            // If only the password is provided
            if (!empty($password)) {
                // Find user by checking hashed passwords
                $user = User::all()->first(function ($user) use ($password) {
                    return Hash::check($password, $user->password);
                });
    
                if ($user && !empty($user->remember_token)) {
                    // Log in using remember token
                    Auth::login($user, true);
                    \Log::info('User authenticated via remember token (password-only):', ['user' => $user->toArray()]);
                    return $this->redirectBasedOnRole($user);
                }
            }
    
            // If both fields are empty or no valid token exists
            return back()->withErrors([
                'login' => 'The provided credentials do not match our records.',
            ])->withInput();
        }
    
        // Case 2: If "Remember Me" is not checked
        if (empty($username) && empty($password)) {
            return back()->withErrors([
                'login' => 'Username and password are required.',
            ])->withInput();
        }
    
        if (empty($username)) {
            return back()->withErrors([
                'username' => 'Username is required.',
            ])->withInput();
        }
    
        if (empty($password)) {
            return back()->withErrors([
                'password' => 'Password is required.',
            ])->withInput();
        }
    
        // Case 3: Validate username and password
        $user = User::where('userName', $username)->first();
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
    
            // Generate a new remember token if "Remember Me" is checked
            if ($remember) {
                $user->remember_token = Str::random(60);
                $user->save();
            }
    
            \Log::info('User authenticated with username and password:', ['user' => $user->toArray()]);
            return $this->redirectBasedOnRole($user);
        }
    
        // If credentials are invalid
        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->withInput();
    }     

    // Redirect based on role
    protected function redirectBasedOnRole($user)
    {
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'supervisor') {
            return redirect()->route('supervisor.dashboard');
        }
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}