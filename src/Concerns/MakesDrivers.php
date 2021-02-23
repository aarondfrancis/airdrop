<?php
/**
 * @author Aaron Francis <aaron@hammerstone.dev|https://twitter.com/aarondfrancis>
 */

namespace Hammerstone\Airdrop\Concerns;


use Exception;
use Hammerstone\Airdrop\Drivers\BaseDriver;
use Hammerstone\Airdrop\HashGenerator;
use Illuminate\Support\Arr;

trait MakesDrivers
{
    /**
     * @return BaseDriver
     * @throws Exception
     */
    public function makeDriver()
    {
        $config = $this->getDriverConfig();

        /** @var BaseDriver $class */
        $class = app(Arr::get($config, 'class'), $config);

        $this->ensureDriverExtendsBase($class);

        return $class->setConfig($config)->setCurrentHash(HashGenerator::make()->generate());
    }

    /**
     * @return string|null
     */
    public function getDriverConfig()
    {
        $driver = config('airdrop.driver') ?? 'DRIVER_NOT_SET';
        $drivers = config('airdrop.drivers');

        return Arr::get($drivers, $driver);
    }

    /**
     * @param $driver
     * @throws Exception
     */
    protected function ensureDriverExtendsBase($driver)
    {
        if (!is_subclass_of($driver, BaseDriver::class)) {
            throw new Exception('Airdrop drivers must extend ' . json_encode(BaseDriver::class));
        }
    }
}