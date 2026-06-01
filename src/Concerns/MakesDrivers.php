<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com|https://twitter.com/aarondfrancis>
 */

namespace WilberGroup\Airdrop\Concerns;

use Exception;
use Illuminate\Support\Arr;
use WilberGroup\Airdrop\Drivers\BaseDriver;
use WilberGroup\Airdrop\HashGenerator;

trait MakesDrivers
{
    public function makeDriver(): BaseDriver
    {
        $config = $this->getDriverConfig();

        /** @var BaseDriver $class */
        $class = app(Arr::get($config, 'class'), $config);

        $this->ensureDriverExtendsBase($class);

        return $class->setConfig($config)->setCurrentHash(HashGenerator::make()->generate());
    }

    public function getDriverConfig(): ?array
    {
        $driver = config('airdrop.driver') ?? 'DRIVER_NOT_SET';
        $drivers = config('airdrop.drivers');

        return Arr::get($drivers, $driver);
    }

    protected function ensureDriverExtendsBase(mixed $driver): void
    {
        if (!is_subclass_of($driver, BaseDriver::class)) {
            throw new Exception('Airdrop drivers must extend ' . json_encode(BaseDriver::class));
        }
    }
}
