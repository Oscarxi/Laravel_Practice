<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\BlogPost' => 'App\Policies\BlogPostPolicy'
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

        Gate::before(function($user, $ability){
            if ($user->is_admin && in_array($ability, ['update'])){
                return true;
            }
        });

        Gate::define('posts.update', [BlogPostPolicy::class, 'update']);
        Gate::define('posts.delete', [BlogPostPolicy::class, 'delete']);

        Gate::define('home.admin', function($user){
            return $user->is_admin;
        });
    }
}
