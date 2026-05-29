<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com>
 */

namespace WilberGroup\Airdrop\Contracts;

interface TriggerContract
{
    /**
     * Return any state that should be considered when determining
     * whether or not your build process needs to run again.
     */
    public function triggerBuildWhenChanged(array $config = []): array;
}
