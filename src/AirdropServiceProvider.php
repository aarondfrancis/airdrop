<?php

/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace AaronFrancis\Airdrop;

use AaronFrancis\Airdrop\Commands\Debug;
use AaronFrancis\Airdrop\Commands\Download;
use AaronFrancis\Airdrop\Commands\Hash;
use AaronFrancis\Airdrop\Commands\Install;
use AaronFrancis\Airdrop\Commands\Upload;
use Illuminate\Support\ServiceProvider;

class AirdropServiceProvider extends ServiceProvider
{
    public function boot()
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

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/airdrop.php', 'airdrop');
    }
}
