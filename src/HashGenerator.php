<?php

/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace Hammerstone\Airdrop;

use Exception;
use Hammerstone\Airdrop\Contracts\TriggerContract;

class HashGenerator
{
    protected $triggers = [];

    public static function make()
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

    /**
     * @return string
     *
     * @throws Exception
     */
    public function generate()
    {
        return md5(json_encode($this->asArray()));
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    public function asArray()
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

    /**
     * @throws Exception
     */
    protected function ensureContractImplemented($class)
    {
        if (!array_key_exists(TriggerContract::class, class_implements($class))) {
            throw new Exception('Airdrop triggers must implement contract ' . json_encode(TriggerContract::class));
        }
    }
}
