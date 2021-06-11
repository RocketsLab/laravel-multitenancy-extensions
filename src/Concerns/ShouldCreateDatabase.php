<?php
namespace RocketsLab\MultitenancyExtensions\Concerns;

use RocketsLab\MultitenancyExtensions\Events\TenantCreated;

trait ShouldCreateDatabase
{
    public static function booted()
    {
        static::created(fn($tenant) => TenantCreated::broadcast($tenant));
    }
}
