<?php
/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace Hammerstone\Airdrop\Contracts;

interface TriggerContract
{
    /**
     * Return any state that should be considered when determining
     * whether or not your build process needs to run again.
     *
     * @param  array  $config
     * @return array
     */
    public function triggerBuildWhenChanged($config = []);
}
