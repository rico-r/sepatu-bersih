<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Karyawan;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('edit-employee', function (Karyawan $user) {
            return $user->role == 'admin';
        });
        Gate::define('edit-service', function (Karyawan $user) {
            return $user->role == 'admin';
        });
        Gate::define('edit-data', function (Karyawan $user) {
            return $user->role == 'admin';
        });
        Gate::define('manage-web', function (Karyawan $user) {
            return $user->role == 'admin';
        });
    }
}
