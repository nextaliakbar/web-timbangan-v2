<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard('user')->check()) {
            return redirect()->route('login');
        }

        $userEsa = Auth::guard('user')->user();
        if ($userEsa->userEsaRole && !$userEsa->userEsaRole->status) {
            Auth::guard('admin')->logout();
            return redirect()->route('login')->with('error', 'Akun anda tidak aktif.');
        }

        return $next($request);
    }
}
