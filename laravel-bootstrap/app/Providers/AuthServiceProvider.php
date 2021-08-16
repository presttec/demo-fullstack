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
        'App\Models\Editora' => 'App\Policies\EditoraPolicy',
        'App\Models\Genero' => 'App\Policies\GeneroPolicy',
        'App\Models\Livro' => 'App\Policies\LivroPolicy',
        'App\Models\Autor' => 'App\Policies\AutorPolicy',
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

        //
    }
}
