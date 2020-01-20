<?php

namespace Default64bit\RatechAdmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class updateAppServiceProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratech-admin:update-app-service-provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update AppServiceProvider';

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
            'path' => '/app/Providers/AppServiceProvider.php',
            'search' => "/public function boot\(\)\n    {\n        \/\//",
            'orginal' => "public function boot()",
            'stub' => __DIR__.'/../../stubs/Providers/AppServiceProvider.stub',

            'search_imports' => 'use Illuminate\Support\ServiceProvider;',
            'stub_imports' => __DIR__.'/../../stubs/Providers/AppServiceProviderImports.stub',
        ];

        $fullPath = base_path() . $setting['path'];

        $originalContent = $this->files->get($fullPath);
        $content = $this->files->get($setting['stub']);
        $stub = $setting['orginal'].$content;
        $originalContent = preg_replace($setting['search'], $stub, $originalContent);

        $content_imports = $this->files->get($setting['stub_imports']);
        $stub_imports = $setting['search_imports'].$content_imports;
        $originalContent = str_replace($setting['search_imports'], $stub_imports, $originalContent);

        $this->files->put($fullPath,$originalContent);
    }


}
