# File Trigger

The File Trigger keeps track of specific files and instructs Airdrop to rebuild assets when any of them change.

config/airdrop.php{.filename}
```php
/*
 * Trigger a rebuild when files change.
 */
FileTrigger::class => [
    /*
     * Files or folders that should be included.
     */
    'include' => [
        // By default we include every file in your resource path. Usually
        // this makes the most sense and doesn't need to be changed.
        resource_path(),

        // Any time the webpack.mix.js file is changed, it could affect the
        // the build steps, and therefore the built files.
        base_path('webpack.mix.js'),

        // Depending on your package manager, you'll want to uncomment one
        // of the following lines. Whenever JS packages are updated or
        // removed, the assets will need to be rebuilt.
        // base_path('yarn.lock'),
        // base_path('package-lock.json'),

        // If you use NVM to manage your node versions, you'll want to
        // rebuild your assets anytime the node version changes.
        // base_path('.nvmrc'),

        // If you use Tailwind, uncomment the following line. Changing your
        // Tailwind config will change the CSS files that are generated.
        // base_path('tailwind.config.js'),
    ],

    /*
     * Files or folders that should be excluded or ignored.
     */
    'exclude' => [
        //
    ],
]
``` 

## Including & Excluding

The File Trigger allows both an `include` and `exclude` key, so if you want to include a whole directory and exclude a particular file, you can do that:

config/airdrop.php{.filename}
```php
FileTrigger::class => [
    'include' => [
        resource_path(),
    ],

    'exclude' => [
        resource_path('file-to-be-ignored.blade.php'),
    ],
]
``` 

## Asset Package Managers

If you're using NPM to manage your frontend packages, you'll want to include `package-lock.json` so that whenever you add, remove, or upgrade packages then Airdrop will rebuild your assets.

config/airdrop.php{.filename}
```php
FileTrigger::class => [
    'include' => [
        resource_path(),
        'package-lock.json'
    ],
]
```

In the same way, if you're using Yarn, add `yarn.lock`.

config/airdrop.php{.filename}
```php
FileTrigger::class => [
    'include' => [
        resource_path(),
        'yarn.lock'
    ],
]
``` 

## Tailwind CSS

If you're using Tailwind CSS, make sure you include that as well, as any changes to the Tailwind config will affect the resulting assets.

config/airdrop.php{.filename}
```php
FileTrigger::class => [
    'include' => [
        resource_path(),
        'tailwind.config.js'
    ],
]
``` 
