# Config Trigger

The Config Trigger is extremely straightforward: it tells Airdrop to rebuild assets anytime _any_ value in the configuration array changes.

By default we populate it with your `APP_ENV` which will keep your development, testing, and production asset builds separate.

config/airdrop.php{.filename}
```php
    /*
     * Trigger a rebuild when anything in this configuration array
     * changes. We've started you off with your app's APP_ENV
     * variable, but you are free to add anything else.
     */
    ConfigTrigger::class => [
        // This will keep your dev, test, and prod assets distinct
        // since they are usually built with different settings.
        'env' => env('APP_ENV')
    ],
```

You're free to add as many other values as you like.

You can inspect the `ConfigTrigger.php` class to see how simple it really is, it just returns the config from your `airdrop.php`. 

ConfigTrigger.php{.filename}
```php
class ConfigTrigger implements TriggerContract
{
    public function triggerBuildWhenChanged($config = [])
    {
        return $config;
    }
}
```