# Laravel Multi Tenant

The term **multi-tenant** refers to a software architecture in which a single instance of software runs on a server and 
serves multiple tenants. A tenant is a group of users who share a common access with specific privileges to the software instance.
With a multi-tenant architecture, a software application is designed to provide every tenant a dedicated share of 
the instance - including its data, configuration, user management, tenant individual functionality and non-functional properties.

## Installation
```
$ composer require ringierimu/multi-tenant
```
Run migrations
```
$ php artisan migrate
```
## Configuration
1. Open `kernel.php` located inside your Http directory 
and add `Ringierimu\MultiTenant\Http\Middleware\TenantMiddleware\TenantMiddleware::class`
to your global http middleware `$middleware`.
```php
 /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        ...
        TenantMiddleware::class
    ];
```

2. Add `TenantDependableTrait` to your model class to support workflow
```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ringierimu\MultiTenant\Traits\TenantDependableTrait;

/**
 * Class Post
 * @package App
 */
class Post extends Model
{
    use TenantDependableTrait;
}
```
3. Create seeder for the **`domains`** table to populate table with data 
and run your seeder.<br>
eg.
```php
<?php
use Illuminate\Support\Facades\DB;

DB::table('domains')->insert([
    'title' => 'Ringier',
    'host' => 'ringier.test',
    'alieses' => 'rg',
    'country_id' => 1
]);
```

## Features
### Tenants Resolver
- The `TenantMiddleware::class` resolve the tenants through http request. It uses the request domain to query **`domains`** table.
- To get instance of the resolved Tenant, you can use dependency injection to inject **`TenantManager`** class or use laravel IOC to return existing instance of **`TenantManager`** class.
```php
<?php

$tenantManager = app(Ringierimu\MultiTenant\TenantManager::class);
echo $tenantManager->getDomain();
``` 

```php
<?php

use Ringierimu\MultiTenant\TenantManager;

public function login(TenantManager $tenantManager)
{
    echo $tenantManager->getDomain();
}

```
### Tenants App Config
- To add a custom configuration per per Tenants, add directory **`tenants`** inside the laravel default config directory with the tenant **`aliases`** key as a subdirectory.
eg. `config/tenants/rg/app.php`.<br>
**NB.`aliases` key must be the same as the Tenant aliases key set on `domains` table.**
- Any config keys found inside tenants directory will override any existing key of laravel default config.

