<?php

namespace RocketsLab\MultitenancyExtensions\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use RocketsLab\MultitenancyExtensions\Events\DatabaseCreated;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Jobs\NotTenantAware;

class CreateTenantDatabase implements ShouldQueue, NotTenantAware
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        UsesMultitenancyConfig;

    protected $event;

    protected DatabaseManager $dbManager;

    public function __construct($event)
    {
        $this->dbManager = new DatabaseManager(app(), app('db.factory'));

        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->createDatabase($this->event->tenant);

            DatabaseCreated::dispatch($this->event->tenant);

        }catch (\Exception $exception) {

            Log::error($exception->getMessage());

        }
    }

    protected function createDatabase($tenant)
    {
        $database = $tenant->getDatabaseName();
        $tenantConnection = $this->tenantDatabaseConnectionName();
        $charset = config("database.{$tenantConnection}.charset") ?? 'utf8mb4';
        $collation = config("database.{$tenantConnection}.collation") ?? 'utf8mb4_unicode_ci';

        $landlordConnection = $this->landlordDatabaseConnectionName();

        $this->dbManager
            ->connection($landlordConnection)
            ->statement("CREATE DATABASE `{$database}` CHARACTER SET `$charset` COLLATE `$collation`");

        $this->dbManager->purge($landlordConnection);
    }
}
