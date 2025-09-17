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
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        
        $userEsa = Auth::guard('admin')->user();

        if ($userEsa->userEsaRole && !$userEsa->userEsaRole->status) {
            Auth::guard('admin')->logout();
            return redirect()->route('login')->with('error', 'Akun anda tidak aktif.');
        }
        
        // dd("3");

        return $next($request);
    }
}
