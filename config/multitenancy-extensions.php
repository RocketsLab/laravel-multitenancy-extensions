<?php

use RocketsLab\MultitenancyExtensions\Jobs;

return [
    /*
     * Listeners to resolve actions after a new Tenant was created
     *
     * You can add new Jobs here or modify like u want ;)
     */
    'tenant_created_listeners' => [
        Jobs\CreateTenantDatabase::class,
//        Jobs\MigrateTenantDatabase::class,
//        Jobs\SeedTenantDatabase::class
    ],

    /*
     * This section configures the landlord:migrate command
     */
    'landlord' => [
        'migrations' => [
            'connection' => env('DB_CONNECTION', null),
            'path' => env('LANDLORD_MIGRATIONS_PATH', null)
        ]
    ]
];
