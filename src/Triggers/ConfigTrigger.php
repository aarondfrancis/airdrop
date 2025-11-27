<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com>
 */

namespace AaronFrancis\Airdrop\Triggers;

use AaronFrancis\Airdrop\Contracts\TriggerContract;

class ConfigTrigger implements TriggerContract
{
    public function triggerBuildWhenChanged(array $config = []): array
    {
        return $config;
    }
}
