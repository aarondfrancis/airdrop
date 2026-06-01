<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com>
 */

namespace WilberGroup\Airdrop;

use Illuminate\Support\ServiceProvider;
use WilberGroup\Airdrop\Commands\Debug;
use WilberGroup\Airdrop\Commands\Download;
use WilberGroup\Airdrop\Commands\Hash;
use WilberGroup\Airdrop\Commands\Install;
use WilberGroup\Airdrop\Commands\Upload;

class AirdropServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
                Download::class,
                Upload::class,
                Debug::class,
                Hash::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../config/airdrop.php' => config_path('airdrop.php')
        ], 'config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/airdrop.php', 'airdrop');
    }
}
