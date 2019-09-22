<?php

namespace App\Providers;
use App\Models\ { Image, User, Album };
use App\Policies\{ AlbumPolicy, ImagePolicy, UserPolicy };


use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Image::class => ImagePolicy::class,
        User::class => UserPolicy::class,
        Album::class => AlbumPolicy::class,

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
