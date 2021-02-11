# Building a Custom Trigger

If the [File](/triggers/file) and [Config](triggers/config) triggers don't meet your needs, you are free to make your own.

Let's imagine we want to trigger an asset rebuild any time the week of the year changes. This will force assets to be built at least once a week, provided we deploy at least once a week.

## Creating the Class

Your custom trigger class must implement the Hammerstone `TriggerContract`.

WeekTrigger.php{.filename}
```php
use Hammerstone\Airdrop\Contracts\TriggerContract;

class WeekTrigger implements TriggerContract
{
    /**
     * Return any state that should be considered when determining
     * whether or not your build process needs to run again.
     *
     * @param array $config
     * @return array
     */
    public function triggerBuildWhenChanged($config = [])
    {
        // @TODO
    }
}
``` 

With that contract, you'll be forced to implement a method `triggerBuildWhenChanged`. This method will receive the config for this particular trigger, if there is any.

In our case, we just want to return the week of the year, so we'll ignore that config.

WeekTrigger.php{.filename}
```php
use Hammerstone\Airdrop\Contracts\TriggerContract;

class WeekTrigger implements TriggerContract
{
    /**
     * Return any state that should be considered when determining
     * whether or not your build process needs to run again.
     *
     * @param array $config
     * @return array
     */
    public function triggerBuildWhenChanged($config = [])
    {
        return now()->weekOfYear;
    }
}
```

## Enabling Your Custom Trigger

To enable your trigger, you'll need to add it to `airdrop.php`. Since no config is required in this example you don't need to pass an empty array, you can just use the class name.

config/airdrop.php{.filename}
```php
'triggers' => [
    ConfigTrigger::class => [
        // ...
    ],

    FileTrigger::class => [
        // ...
    ],
    
    // Our custom trigger, no config required.
    WeekTrigger::class,
],
```

If you wanted to have configuration for your custom trigger, you could do so by setting the key to the class and the value to an array:

config/airdrop.php{.filename}
```php
'triggers' => [
    ConfigTrigger::class => [
        // ...
    ],

    FileTrigger::class => [
        // ...
    ],
    
    // Our custom trigger, with some configuration
    WeekTrigger::class => [
        'key' => 'value'
    ],
],
```