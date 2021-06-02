<?php
namespace RocketsLab\MultitenancyExtensions\Concerns;

use RocketsLab\MultitenancyExtensions\Events\TenantCreated;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;

trait ShouldCreateDatabase
{
    use UsesMultitenancyConfig;

    public static function booted()
    {
        static::created(fn($tenant) => TenantCreated::broadcast($tenant));
    }

    public function createDatabase()
    {
        $database = $this->getDatabaseName();
        $tenantConnection = $this->tenantDatabaseConnectionName();
        $charset = config("database.{$tenantConnection}.charset") ?? 'utf8mb4';
        $collation = config("database.{$tenantConnection}.collation") ?? 'utf8mb4_unicode_ci';

        $landlordConnection = $this->landlordDatabaseConnectionName();
        $connection = DB::connection($landlordConnection);
        $connection->statement("CREATE DATABASE `{$database}` CHARACTER SET `$charset` COLLATE `$collation`");
        DB::purge($landlordConnection);
    }
}
