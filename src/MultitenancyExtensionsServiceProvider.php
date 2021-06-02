<?php


namespace RocketsLab\MultitenancyExtensions;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use RocketsLab\MultitenancyExtensions\Events;

class MultitenancyExtensionsServiceProvider extends ServiceProvider
{
    public function events()
    {
        return [
            Events\TenantCreated::class => config('multitenancy-extensions.active_jobs')
        ];
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/config/multitenancy-extensions.php", "multitenancy-extensions");
    }

    public function boot()
    {
        $this->bootEvents();

        $this->publishes([__DIR__ . "/config/multitenancy-extensions.php"], "config");
    }

    protected function bootEvents()
    {
        foreach ($this->events() as $event => $listeners) {
            foreach (array_unique($listeners) as $listener) {
                Event::listen($event, $listener);
            }
        }
    }
}
