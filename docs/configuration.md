
# Configuration

The Airdrop configuration file contains a reasonable starting point for most Laravel applications, but you'll want to customize it for your particular app.

To publish this file, run `php artisan airdrop:install`  

## Drivers

The driver you choose determines how your built assets will be stashed and restored.

We offer two drivers out of the box: 

- the [Filesystem Driver](/drivers/filesystem), which stores built assets as `.zip` on a disk of your choosing, usually a cloud provider.
- the [GitHub Actions Driver](/drivers/github), which stores the built assets using GitHub's [Cache Action](https://docs.github.com/en/actions/guides/caching-dependencies-to-speed-up-workflows).

If neither of these meet your needs, you are free to [make your own](/drivers/custom).

## Triggers

The `triggers` section tells Airdrop how to calculate if your assets need to be rebuilt. We offer two different triggers out of the box: 
- [Config Trigger](/triggers/config) than can trigger a build based on ENV vars (or any other config).
- [File Trigger](/triggers/file) that triggers a build whenever a file changes.

Each trigger has its own configuration that you can use to fine-tune your settings, but both come with reasonable defaults.

You can have as many triggers as you want. You can also [build your own](/triggers/custom).

## Outputs

The `outputs` section of the config file defines which files are generated as the result of your build process.

**Anything that is generated as a result of your build process should be included here.**

config/airdrop.php {.filename}
```php
[
    // ...
   'outputs' => [
    /*
     * Files or folders that should be included.
     */
    'include' => [
        // The mix-manifest file tells Laravel how to get your versioned assets.
        public_path('mix-manifest.json'),

        // Compiled CSS.
        public_path('css'),

        // Compiled JS.
        public_path('js'),
    ],

    /*
     * Files or folders that should be excluded or ignored.
     */
    'exclude' => [
        //
    ],
];
```


By default Airdrop will store your compiled CSS, JS, and your mix-manifest file. If Airdrop determines that a build is not necessary on the next deploy, these files will be pulled down and put in place as if they had just been built.