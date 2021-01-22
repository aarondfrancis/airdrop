<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
 */

namespace Hammerstone\Airdrop;

use Hammerstone\Airdrop\Commands\Restore;
use Hammerstone\Airdrop\Commands\Stash;
use Illuminate\Support\ServiceProvider;

class AirdropServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Restore::class,
                Stash::class
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