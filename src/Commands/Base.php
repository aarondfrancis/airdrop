<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
 */

namespace Hammerstone\Airdrop\Commands;

use Exception;
use Illuminate\Console\Command;
use Hammerstone\Airdrop\Contracts\StashAndRestoreDriverContract;
use Illuminate\Support\Arr;

abstract class Base extends Command
{
    /**
     * @return StashAndRestoreDriverContract
     * @throws Exception
     */
    public function makeDriver()
    {
        $driver = config('airdrop.driver') ?? 'DRIVER_NOT_SET';
        $drivers = config('airdrop.drivers');

        $class = Arr::get($drivers, $driver);
        $class = app($class);

        $this->ensureContractImplemented($class, StashAndRestoreDriverContract::class);

        return $class;
    }

    /**
     * @param $class
     * @param $contract
     * @throws Exception
     */
    protected function ensureContractImplemented($class, $contract)
    {
        if (!array_key_exists($contract, class_implements($class))) {
            throw new Exception('Airdrop drivers must implement contract ' . json_encode($contract));
        }
    }

}
