<?php

/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace AaronFrancis\Airdrop\Drivers;

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

    public function output($line)
    {
        if (config('airdrop.verbose')) {
            echo "[Airdrop] $line\n";
        }
    }

    abstract public function download();

    abstract public function upload();
}
