<?php


namespace RocketsLab\MultitenancyExtensions;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use RocketsLab\MultitenancyExtensions\Commands\LandlordMigrationCommand;
use RocketsLab\MultitenancyExtensions\Events;

class MultitenancyExtensionsServiceProvider extends ServiceProvider
{
    public function events()
    {
        return [
            Events\TenantCreated::class => config('multitenancy-extensions.tenant_created_listeners')
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
