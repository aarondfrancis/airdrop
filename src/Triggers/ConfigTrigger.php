<?php
/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace AaronFrancis\Airdrop\Triggers;

use AaronFrancis\Airdrop\Contracts\TriggerContract;

class ConfigTrigger implements TriggerContract
{
    /**
     * Return any state that should be considered when determining
     * whether or not your build process needs to run again.
     *
     * @param  array  $config
     * @return array
     */
    public function triggerBuildWhenChanged($config = [])
    {
        return $config;
    }
}
