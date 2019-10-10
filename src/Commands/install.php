<?php

namespace Default64bit\RatechAdmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratech-admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and update settings';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('ratech-admin:update-routes');
        Artisan::call('ratech-admin:update-middleware-kernel');
        Artisan::call('ratech-admin:update-auth-service-provider');
    }


}
