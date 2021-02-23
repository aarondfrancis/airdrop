<?php
/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace Hammerstone\Airdrop;

use Hammerstone\Airdrop\Commands\Install;
use Hammerstone\Airdrop\Commands\Download;
use Hammerstone\Airdrop\Commands\Upload;
use Illuminate\Support\ServiceProvider;

class AirdropServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
                Download::class,
                Upload::class
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