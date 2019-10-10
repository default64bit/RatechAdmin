<?php

namespace Default64bit\RatechAdmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class updateRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratech-admin:update-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update and add admin routes';

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
            'path' => '/routes/web.php',
            'stub' => __DIR__.'/../../stubs/routes/web.stub',
        ];

        $fullPath = base_path() . $setting['path'];

        $originalContent = $this->files->get($fullPath);
        $content = $this->files->get($setting['stub']);

        $this->files->put($fullPath,$content);
    }


}
