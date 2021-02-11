# Building A Custom Driver

If the [Filesystem](/drivers/filesystem) Driver isn't quite right for you, you can build your own quite easily.

Your custom driver must extend the Hammerstone `BaseDriver`.

CustomDriver.php{.filename}
```php
use Hammerstone\Airdrop\Drivers\BaseDriver;

class CustomDriver extends BaseDriver 
{
    /**
     * Called after building, to stash the files somewhere.
     */
    public function upload()
    {
        // @TODO
    }

    /**
     * Called before building files, to see if we can skip that
     * altogether and just download them.
     */
    public function download()
    {
        // @TODO
    }
}
```

The current hash will be available as a class property `$hash`, and the config for your driver will be available as `$config`.

## Enabling Your Custom Driver

To enable your driver, you'll need to add it to the `drivers` array in `airdrop.php`.

config/airdrop.php{.filename}
```php
'drivers' => [
    'custom' => [
        // Use our new custom class as the driver.
        'class' => CustomDriver::class,
        
        // Pass in any configuration you want.
        'key' => 'value' 
    ]
],
```