<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
 */

namespace Hammerstone\Airdrop\Drivers;

abstract class BaseDriver
{
    /**
     * Config for this specific driver.
     *
     * @var array
     */
    protected $config;

    /**
     * Current hash based on all inputs.
     *
     * @var string
     */
    protected $hash;

    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    public function setCurrentHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    abstract public function download();

    abstract public function upload();


}