<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the 'admin' role
        if (Auth::check() && Auth::user()->role !== 'admin') {
            // Redirect to a different page if not an admin
            return redirect()->route('posts')->with('error', 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}
