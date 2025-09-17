<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = session('guest', 'admin');
        switch($guard) {
            case 'admin':
                if(Auth::guard($guard)->check()) {
                    $user = Auth::guard($guard)->user();
                    if($user->HAK == 'ADMIN') {
                        return redirect()->route('admin.peran-user');
                    } else {
                        $modules = $user->userEsaRole->modules ?? [];

                        if($modules[0] == 'User Timbangan') {
                            return redirect()->route('admin.user-timbangan');
                        } elseif($modules[0] == 'Ganti JO') {
                            return redirect()->route('admin.ganti-jo');
                        }

                        $routeName = match($modules[0]) {
                            'Serah Terima' => 'admin.serah-terima',
                            'Timbangan' => 'admin.timbangan',
                            'Formula' => 'admin.formula',
                            'Kartu Stok' => 'admin.kartu-stok',
                        };
                        return redirect()->route($routeName, ['plant' => 'unimos']);
                    }
                }
                
            break;

            case 'user':
                if(Auth::guard($guard)->check()) {
                    return redirect()->route('main-app.index');
                }
            break;

            default:
                if(Auth::guard($guard)->check()) {
                    return response()->json([], 404);
                }
        }

        return $next($request);
    }
}
