<?php
/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace Hammerstone\Airdrop\Commands;

use Hammerstone\Airdrop\AirdropServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'airdrop:install';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Install the Airdrop config file into your app.';

    public function __construct()
    {
        parent::__construct();

        if (file_exists(config_path('airdrop'))) {
            $this->setHidden(true);
        }
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        Artisan::call("vendor:publish", [
            '--provider' => AirdropServiceProvider::class
        ]);

        $this->info('Config file published!');
    }

}
