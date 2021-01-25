<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
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
        $this->makeDriver()->download();
    }

}
