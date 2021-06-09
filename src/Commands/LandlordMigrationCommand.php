<?php


namespace RocketsLab\MultitenancyExtensions\Commands;


use Illuminate\Console\Command;

class LandlordMigrationCommand extends Command
{
    /**
     * Command signature
     * @var string
     */
    protected $signature = 'landlord:migrate {--fresh : Drop all tables and migrate}';

    /**
     * Command description.
     *
     * @var string
     */
    protected $description = 'Migrate landlord tables';

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
     * @return int
     */
    public function handle()
    {
        $landlordConnection = config('multitenancy-extensions.landlord.migrations.connection');

        $landlordMigrationsPath = config('multitenancy-extensions.landlord.migrations.path');

        $command = $this->option('fresh') ? 'migrate:fresh' : 'migrate';

        $this->call($command, [
            '--database' => $landlordConnection,
            '--path' => $landlordMigrationsPath,
        ]);
    }
}
