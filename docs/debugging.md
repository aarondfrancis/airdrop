
# Debugging

Not sure what's triggering a rebuild? You can use the `airdrop:debug` command to help you diagnose it.

The Debug command will simply print out the JSON object that will be hashed to calculate if a rebuild is needed. 

For example, let's imagine your triggers are very, very simple:

```php
ConfigTrigger::class => [
    'env' => env('APP_ENV')
],

FileTrigger::class => [
    'include' => [
        base_path('package-lock.json'),
    ],
]
```

When you call `aidrop:debug`, the following will be printed to your console:

```json
{
    "AaronFrancis\\Airdrop\\Triggers\\ConfigTrigger": {
        "env": "production"
    },
    "AaronFrancis\\Airdrop\\Triggers\\FileTrigger": {
        "package-lock.json": "62f6d1bfc836a1536c4869fe8f78249b"
    }
}
```

If you want to narrow it down to a single trigger, you can pass that through with the `--trigger` option:

```bash
php artisan airdrop:debug --trigger=AaronFrancis\\Airdrop\\Triggers\\ConfigTrigger
```

Then you'll _only_ get output for the config trigger:
```json
{
    "AaronFrancis\\Airdrop\\Triggers\\ConfigTrigger": {
        "env": "production"
    }
}
```

You can write this output to a file and store it somewhere for inspection

```bash
php artisan airdrop:debug > airdrop.json
```

Or you can run it before and after a command you expect is modifying files (as was the case with [this issue](https://github.com/hammerstonedev/airdrop/issues/2)) to see what the difference is:

```bash
php artisan airdrop:debug > before.json

npm run production

php artisan airdrop:debug > after.json

diff before.json after.json
```
