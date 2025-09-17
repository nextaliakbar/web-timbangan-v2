<?php

namespace App\Providers;

use App\Models\UserEsa;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-module', function(UserEsa $userEsa, $moduleName) {
            $userModules = $userEsa->userEsaRole->modules ?? [];
            return in_array($moduleName, $userModules);
        });
    }
}
