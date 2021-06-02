<?php

use RocketsLab\MultitenancyExtensions\Jobs;

return [
    'active_jobs' => [
        Jobs\CreateTenantDatabase::class,
//        Jobs\MigrateTenantDatabase::class,
//        Jobs\SeedTenantDatabase::class
    ]
];
