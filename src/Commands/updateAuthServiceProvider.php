<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class updateAuthServiceProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratech-admin:update-auth-service-provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update authServiceProvider and add SuperAdmin';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $setting = [
            'path' => '/app/Providers/AuthServiceProvider.php',
            'search' => '$this->registerPolicies();',
            'stub' => __DIR__.'/../stubs/Providers/AuthServiceProvider.stub',
        ];

        $fullPath = base_path() . $setting['path'];

        $originalContent = $this->files->get($fullPath);
        $content = $this->files->get($setting['stub']);
        $stub = $setting['search'].$content;

        $originalContent = str_replace($setting['search'], $stub, $originalContent);

        $this->files->put($fullPath,$originalContent);
    }


}
