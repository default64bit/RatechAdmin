<?php

namespace default64bit\src;

use Illuminate\Support\ServiceProvider;

class ratechAdminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->mergeConfigFrom(
            __DIR__.'/../config/auth.php', 'auth'
        );

        $this->publishes([
            __DIR__.'/Controllers' => app_path('Http/Controllers'),
            __DIR__.'/Middlewares' => app_path('Http/Middleware'),
            __DIR__.'/Requsests' => app_path('Http/Requests'),
            __DIR__.'/Models' => app_path('/'),

            __DIR__.'/../database/migrations' => database_path('migrations'),
            __DIR__.'/../database/seeds' => database_path('seeds'),

            __DIR__.'/../resources/views' => resource_path('views'),
        ]);
    }
}
