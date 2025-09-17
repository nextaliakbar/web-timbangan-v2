<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $moduleName): Response
    {
        if(Gate::denies('access-module', $moduleName)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses modul tersebut.');
        }

        return $next($request);
    }
}
