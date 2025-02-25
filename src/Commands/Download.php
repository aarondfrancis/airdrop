<?php

/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace Hammerstone\Airdrop\Commands;

use Hammerstone\Airdrop\Concerns\MakesDrivers;
use Illuminate\Console\Command;

class Download extends Command
{
    use MakesDrivers;

    protected $signature = 'airdrop:download';

    protected $description = 'Run as a part of your deploy pipeline *before* assets are built.';

    public function handle()
    {
        config([
            'airdrop.verbose' => $this->option('verbose')
        ]);

        $this->makeDriver()->download();
    }
}
