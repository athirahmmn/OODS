<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SessionTimeoutMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $timeout = config('session.lifetime') * 60; // Session lifetime in seconds
            $lastActivity = session('lastActivityTime');

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                Auth::logout(); // Log out the user
                session()->flush(); // Clear session data

                return redirect()->route('login')->with('message', 'Session expired due to inactivity.');
            }

            session(['lastActivityTime' => time()]); // Update last activity time
        }

        return $next($request);
    }
}