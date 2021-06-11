<?php


namespace RocketsLab\MultitenancyExtensions;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use RocketsLab\MultitenancyExtensions\Events;
use RocketsLab\MultitenancyExtensions\Commands\LandlordMigrationCommand;
use RocketsLab\MultitenancyExtensions\Jobs\ProcessTenantCreation;

class MultitenancyExtensionsServiceProvider extends ServiceProvider
{
    public function events()
    {
        return [
            Events\TenantCreated::class => [
                ProcessTenantCreation::make(config('multitenancy-extensions.tenant_created_listeners'))
                    ->send(function (Events\TenantCreated $event) {
                        return $event;
                    })
                    ->shouldBeQueued(config('multitenancy-extensions.jobs.should_queue'))
                    ->toListener()
            ],
            Events\DatabaseCreated::class => [],
        ];
    }

    public function register()
    {
        $path = realpath(__DIR__ . '/../config/multitenancy-extensions.php');
        $this->mergeConfigFrom($path, "multitenancy-extensions");
    }

    public function boot()
    {
        $this->bootEvents();

        $path = realpath(__DIR__ . '/../config/multitenancy-extensions.php');

        $this->publishes([$path => config_path('multitenancy-extensions.php')], "config");

        $this->bootCommands();
    }

    protected function bootCommands()
    {
        if(! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            LandlordMigrationCommand::class
        ]);
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
