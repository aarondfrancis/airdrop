# Airdrop for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wilbergroup/airdrop)](https://packagist.org/packages/wilbergroup/airdrop)
[![Total Downloads](https://img.shields.io/packagist/dt/wilbergroup/airdrop)](https://packagist.org/packages/wilbergroup/airdrop)
[![License](https://img.shields.io/packagist/l/wilbergroup/airdrop)](https://packagist.org/packages/wilbergroup/airdrop)

> Read the full docs at [hammerstone.dev/airdrop/docs](https://hammerstone.dev/airdrop/docs/main/overview).

Airdrop for Laravel is a package that speeds up your deploys by skipping your asset build step whenever possible.

When you're deploying your code, Airdrop will calculate a hash of everything needed to build your assets: installed packages, JS/CSS files, ENV vars, etc.

After Airdrop has calculated a hash for these inputs, it will check to see if it has ever built this exact configuration before. If it has, it will pull down the built assets and put them in place, letting you skip the expensive build step.


# Installation

You can install the package via Composer
```console
composer require wilbergroup/airdrop
```

Once the package is installed, you may optionally publish the config file by running 
```console
php artisan airdrop:install
```

You'll likely want to publish the config file so that you can set up your triggers and outputs.

Read the full docs at [hammerstone.dev/airdrop/docs](https://hammerstone.dev/airdrop/docs/main/overview).

## License

The MIT License (MIT).

## Credits

Airdrop was developed by Aaron Francis. If you like it, please let me know!

- Twitter: https://twitter.com/aarondfrancis
- Website: https://aaronfrancis.com
- YouTube: https://youtube.com/@aarondfrancis
- GitHub: https://github.com/aarondfrancis/solo
