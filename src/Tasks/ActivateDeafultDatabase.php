<?php


namespace RocketsLab\MultitenancyExtensions\Tasks;

use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantDatabaseTask;

class ActivateDeafultDatabase extends SwitchTenantDatabaseTask
{
    public function makeCurrent(Tenant $tenant): void
    {
        $tenantConnectionName = $this->tenantDatabaseConnectionName();
        config(["database.default" => $tenantConnectionName]);
    }

    public function forgetCurrent(): void
    {
        //
    }
}
