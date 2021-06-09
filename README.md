# Multitenancy Extensions
---

[Versão em português (Brasil)](README_pt-BR.md)

This package are created for use with [Spatie's Laravel Multitenancy](https://spatie.be/docs/laravel-multitenancy/v1/introduction).

### Installation

```shell
composer require rocketslab/laravel-multitenancy-extensions
```

### Configuration

Publish default configuration. 

```shell
php artisan vendor:publish --provider="RocketsLab\MultitenancyExtensions\MultitenancyExtensionsServiceProvider" --tag="config"
```

### Activating the default database to current Tenant

By default, the **multitenancy** package has a task to do
the database switching on each request. But by doing this in
background (when creating a new Tenant), the `default` database 
is not assigned. And so when trying to migrate the tables and populate the database
with initial data the new database is not found by Laravel.

To solve this add the `ActiveDefaultDatabase` task to the
task array in `multitenancy` config file as first from the list.

```php
    //...
    'switch_tenant_tasks' => [
        \RocketsLab\MultitenancyExtensions\Tasks\ActivateDeafultDatabase::class,
        \Spatie\Multitenancy\Tasks\SwitchTenantDatabaseTask::class,
        // ... other tasks
    ],
    //...
```

### Creating Tenants Databases

After configuring the `spatie/laravel-tenancy` Tenant model. You can
activate automatic database creation. To do this, include the `ShoudCreateDatabase` trait 
to Tenant model.

### Landlord Database Migration Helper

This package comes with a command to help migrate to landlord database.

```shell
php artisan landlord:migrate
```

This command run all migrations in the `database/migrations/landlord` folder by default.
If you can modify this, edit `landlord` configuration section in `multitenancy-extensions`
configuration file.

Optionally you can use `--fresh` flag to drop all tables and migrate.

----

Created by [@jjsquady - Jorge Gonçalves](https://github.com/jjsquady)

Thanks to [Spatie](https://spatie.be) team.

License MIT
