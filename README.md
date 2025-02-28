# Airdrop for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aaronfrancis/airdrop)](https://packagist.org/packages/aaronfrancis/airdrop)
[![Total Downloads](https://img.shields.io/packagist/dt/aaronfrancis/airdrop)](https://packagist.org/packages/aaronfrancis/airdrop)
[![License](https://img.shields.io/packagist/l/aaronfrancis/airdrop)](https://packagist.org/packages/aaronfrancis/airdrop)

> Read the full docs at [hammerstone.dev/airdrop/docs](https://hammerstone.dev/airdrop/docs/main/overview).

Airdrop for Laravel is a package that speeds up your deploys by skipping your asset build step whenever possible.

When you're deploying your code, Airdrop will calculate a hash of everything needed to build your assets: installed packages, JS/CSS files, ENV vars, etc.

After Airdrop has calculated a hash for these inputs, it will check to see if it has ever built this exact configuration before. If it has, it will pull down the built assets and put them in place, letting you skip the expensive build step.


# Installation

You can install the package via Composer
```console
composer require aaronfrancis/airdrop
```

Once the package is installed, you may optionally publish the config file by running 
```console
php artisan airdrop:install
```

You'll likely want to publish the config file so that you can set up your triggers and outputs.

Read the full docs at [hammerstone.dev/airdrop/docs](https://hammerstone.dev/airdrop/docs/main/overview).

## License

The MIT License (MIT).

## Support

This is free! If you want to support me:

- Sponsor my open source work: [aaronfrancis.com/backstage](https://aaronfrancis.com/backstage)
- Check out my courses:
    - [Mastering Postgres](https://masteringpostgres.com)
    - [High Performance SQLite](https://highperformancesqlite.com)
    - [Screencasting](https://screencasting.com)
- Help spread the word about things I make

## Credits

Airdrop was developed by Aaron Francis. If you like it, please let me know!

- Twitter: https://twitter.com/aarondfrancis
- Website: https://aaronfrancis.com
- YouTube: https://youtube.com/@aarondfrancis
- GitHub: https://github.com/aarondfrancis/solo
