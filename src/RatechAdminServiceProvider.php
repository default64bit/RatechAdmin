<?php

namespace Default64bit\RatechAdmin;

use Illuminate\Support\ServiceProvider;

class RatechAdminServiceProvider extends ServiceProvider
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

        $this->commands([
            \Default64bit\RatechAdmin\Commands\install::class,
            \Default64bit\RatechAdmin\Commands\updateAuthServiceProvider::class,
            \Default64bit\RatechAdmin\Commands\updateMiddlewareKernel::class,
            \Default64bit\RatechAdmin\Commands\updateRoutes::class,
            \Default64bit\RatechAdmin\Commands\updateConfigAuth::class,
	        \Default64bit\RatechAdmin\Commands\updateDatabaseSeeder::class,

        ]);

        $this->publishes([
            __DIR__.'/Controllers' => app_path('Http/Controllers'),
            __DIR__.'/Middlewares' => app_path('Http/Middleware'),
            __DIR__.'/Requests' => app_path('Http/Requests'),
            __DIR__.'/Models' => app_path('/'),

            __DIR__.'/../database/migrations' => database_path('migrations'),
            __DIR__.'/../database/seeds' => database_path('seeds'),

            __DIR__.'/../resources/views' => resource_path('views'),

            __DIR__.'/../storage' => storage_path('/'),
        ]);
    }
}
