<?php


namespace Default64bit\RatechAdmin\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command

{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratech-admin:database-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database Backup Mysql';

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

        Spatie\DbDumper\Databases\MySql::create()
            ->setDbName(config('database.connections.mysql.database'))
            ->setUserName(config('database.connections.mysql.username'))
            ->setPassword(config('database.connections.mysql.password'))
            ->dumpToFile('dump.sql');

    }
}
