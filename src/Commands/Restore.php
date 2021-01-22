<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
 */

namespace Hammerstone\Airdrop\Commands;

use Exception;

class Restore extends Base
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'airdrop:restore';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Run as a part of deploying before assets are built.';

    /**
     * @throws Exception
     */
    public function handle()
    {
        $this->makeDriver()->restore();
    }

}
