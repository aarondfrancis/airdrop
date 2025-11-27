<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com>
 */

namespace AaronFrancis\Airdrop\Drivers;

abstract class BaseDriver
{
    protected array $config = [];

    protected string $hash = '';

    public function setConfig(array $config): static
    {
        $this->config = $config;

        return $this;
    }

    public function setCurrentHash(string $hash): static
    {
        $this->hash = $hash;

        return $this;
    }

    public function output(string $line): void
    {
        if (config('airdrop.verbose')) {
            echo "[Airdrop] $line\n";
        }
    }

    abstract public function download(): void;

    abstract public function upload(): void;
}
