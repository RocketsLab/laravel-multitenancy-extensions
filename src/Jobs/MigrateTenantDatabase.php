<?php

namespace RocketsLab\MultitenancyExtensions\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Spatie\Multitenancy\Jobs\NotTenantAware;

class MigrateTenantDatabase implements ShouldQueue, NotTenantAware
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($event)
    {
        $event->tenant->execute(fn() => Artisan::call("tenants:artisan", ["artisanCommand" => "migrate"]));
    }
}
