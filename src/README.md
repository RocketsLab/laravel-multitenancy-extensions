# Multitenancy Extensions
---
This package are created for use with [Spatie's Laravel Multitenancy](https://spatie.be/docs/laravel-multitenancy/v1/introduction).

### Installation

```shell
composer require rocketslab/multitenancy-extensions
```

### Configuration

You can publish default configuration. 

```shell
php artisan vendor:publish --provider="RocketsLab\MultitenancyExtensions\MultitenancyExtensionsServiceProvider" --tag="config"
```

### Creating Tenants Databases

After configuring the `spatie/laravel-tenancy` Tenant model. You can
activate automatic database creation. To do this, include the `ShoudCreateDatabase` trait 
to Tenant model.

### 
