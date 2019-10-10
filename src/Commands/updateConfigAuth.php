<?php

namespace Default64bit\RatechAdmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class updateConfigAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratech-admin:update-config-auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update config\'s auth';

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
            'path' => '/config/auth.php',

            'search-guard' => "'guards' => [",
            'stub-guard' => __DIR__.'/../../stubs/config/auth-guard.stub',

            'search-provider' => "'providers' => [",
            'stub-provider' => __DIR__.'/../../stubs/config/auth-provider.stub',

            'search-password' => "'passwords' => [",
            'stub-password' => __DIR__.'/../../stubs/config/auth-password.stub',
        ];

        $fullPath = base_path() . $setting['path'];

        $originalContent = $this->files->get($fullPath);

        $content_guard = $this->files->get($setting['stub-guard']);
        $content_provider = $this->files->get($setting['stub-provider']);
        $content_password = $this->files->get($setting['stub-password']);

        $stub_guard = $setting['search-guard'].$content_guard;
        $stub_provider = $setting['search-provider'].$content_provider;
        $stub_password = $setting['search-password'].$content_password;

        $originalContent = str_replace($setting['search-guard'], $stub_guard, $originalContent);
        $originalContent = str_replace($setting['search-provider'], $stub_provider, $originalContent);
        $originalContent = str_replace($setting['search-password'], $stub_password, $originalContent);

        $this->files->put($fullPath,$originalContent);
    }


}
