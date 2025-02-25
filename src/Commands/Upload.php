<?php

namespace AaronFrancis\Airdrop\Commands;

use AaronFrancis\Airdrop\Concerns\MakesDrivers;
use Illuminate\Console\Command;

class Upload extends Command
{
    use MakesDrivers;

    protected $signature = 'airdrop:upload';

    protected $description = 'Run as a part of your deploy pipeline *after* assets are built.';

    public function handle()
    {
        config([
            'airdrop.verbose' => $this->option('verbose')
        ]);

        $this->makeDriver()->upload();
    }
}
