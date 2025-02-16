<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to register for authorization.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Aquí puedes agregar gates personalizados
        Gate::define('admin-only', function (User $user) {
            return $user->role === 'Administrador';
        });

        Gate::define('professor-only', function (User $user) {
            return $user->role === 'Profesor';
        });

        Gate::define('student-only', function (User $user) {
            return $user->role === 'Alumno';
        });
    }
}
