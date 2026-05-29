<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com>
 */

namespace WilberGroup\Airdrop;

use WilberGroup\Airdrop\Contracts\TriggerContract;
use Exception;

class HashGenerator
{
    protected array $triggers = [];

    public static function make(): static
    {
        return new static;
    }

    public function __construct()
    {
        foreach (config('airdrop.triggers') as $class => $config) {
            // Support a bare class that requires no further configuration.
            if (is_int($class) && class_exists($config)) {
                $class = $config;
                $config = [];
            }

            $this->triggers[$class] = $config;
        }
    }

    public function generate(): string
    {
        return md5(json_encode($this->asArray()));
    }

    public function asArray(): array
    {
        $contents = [];

        foreach ($this->triggers as $class => $config) {
            $this->ensureContractImplemented($class);

            $values = app($class)->triggerBuildWhenChanged($config);
            ksort($values);

            $contents[$class] = $values;
        }

        ksort($contents);

        return $contents;
    }

    protected function ensureContractImplemented(string $class): void
    {
        if (!array_key_exists(TriggerContract::class, class_implements($class))) {
            throw new Exception('Airdrop triggers must implement contract ' . json_encode(TriggerContract::class));
        }
    }
}
