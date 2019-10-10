<?php

namespace Default64bit\RatechAdmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class updateDatabaseSeeder extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'ratech-admin:update-database-seeder';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'update database seeder';

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
			'path' => '/database/seeds/DatabaseSeeder.php',
			'search' => '// $this->call(UsersTableSeeder::class);',
			'stub' => __DIR__.'/../../stubs/database/seeds/DatabaseSeeder.stub',
		];

		$fullPath = base_path() . $setting['path'];

		$originalContent = $this->files->get($fullPath);
		$content = $this->files->get($setting['stub']);

		$originalContent = str_replace($setting['search'], $content, $originalContent);

		$this->files->put($fullPath,$originalContent);
	}


}
