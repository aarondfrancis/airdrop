<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com>
 */

namespace WilberGroup\Airdrop\Triggers;

use WilberGroup\Airdrop\Contracts\TriggerContract;

class ConfigTrigger implements TriggerContract
{
    public function triggerBuildWhenChanged(array $config = []): array
    {
        return $config;
    }
}
