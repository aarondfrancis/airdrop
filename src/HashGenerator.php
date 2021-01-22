<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
 */

namespace Hammerstone\Airdrop;

use Exception;
use Hammerstone\Airdrop\Contracts\TriggerContract;

class HashGenerator
{
    protected $triggers = [];

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
     * @throws Exception
     */
    public function generate()
    {
        $contents = [];

        foreach ($this->triggers as $class => $config) {
            $this->ensureContractImplemented($class);

            $contents[$class] = app($class)->triggerWhenChanged($config);
        }

        return md5(json_encode($contents));
    }

    /**
     * @param $class
     * @throws Exception
     */
    protected function ensureContractImplemented($class)
    {
        if (!array_key_exists(TriggerContract::class, class_implements($class))) {
            throw new Exception('Airdrop triggers must implement contract ' . json_encode(TriggerContract::class));
        }
    }
}