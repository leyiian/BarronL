<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Gate::define('menuEsp', function (User $user) {
            return $user->rol == "A";
        });

        Gate::define('menuDoc', function (User $user) {
            return $user->rol == "A";
        });

        Gate::define('menuCon', function (User $user) {
            return $user->rol == "A";
        });

        Gate::define('menuPac', function (User $user) {
            return $user->rol == "A";
        });

        Gate::define('menuMed', function (User $user) {
            return $user->rol == "A";
        });

        Gate::define('menuMat', function (User $user) {
            return $user->rol == "A";
        });

        Gate::define('menuCit', function (User $user) {
            return $user->rol == "A" || $user->rol == "D";
        });

        Gate::define('viewLogs', function (?User $user) {
            return $user->rol == "A";
        });
    }
}
