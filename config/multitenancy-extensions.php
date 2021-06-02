<?php

use RocketsLab\MultitenancyExtensions\Jobs;

return [
    'tenant_created_listeners' => [
        Jobs\CreateTenantDatabase::class,
//        Jobs\MigrateTenantDatabase::class,
//        Jobs\SeedTenantDatabase::class
    ]
];
