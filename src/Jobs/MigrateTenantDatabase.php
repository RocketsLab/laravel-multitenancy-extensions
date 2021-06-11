<?php

namespace RocketsLab\MultitenancyExtensions\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use RocketsLab\MultitenancyExtensions\Events\DatabaseMigrated;
use RocketsLab\MultitenancyExtensions\Events\TenantCreated;
use Spatie\Multitenancy\Jobs\NotTenantAware;

class MigrateTenantDatabase implements ShouldQueue, NotTenantAware
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;

    public function __construct(TenantCreated $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->event->tenant->execute(function () {
            try {
                Artisan::call("tenants:artisan", ["artisanCommand" => "migrate"]);

                DatabaseMigrated::dispatch($this->event->tenant);

            }catch (\Exception $exception) {

                Log::error($exception->getMessage());

            }
        });
    }
}
