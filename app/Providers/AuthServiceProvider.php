<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 系統後台管理 Gate 規則
        Gate::define('superadmin', function ($user) {
            return $user->role === User::ROLE_SUPERADMIN;
        });

        // 行政 Gate 規則
        Gate::define('admin', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        // 行政 Gate 規則
        Gate::define('housemaster', function ($user) {
            return $user->role === User::ROLE_HOUSEMASTER;
        });

        // 總樓長 Gate 規則
        Gate::define('chief', function ($user) {
            return $user->role === User::ROLE_CHIEF;
        });

        // 樓長 Gate 規則
        Gate::define('floorhead', function ($user) {
            return $user->role === User::ROLE_FLOORHEAD;
        });

        // 住宿生 Gate 規則
        Gate::define('user', function ($user) {
            return $user->role === User::ROLE_USER;
        });
        //
    }
}
