<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com>
 */

namespace AaronFrancis\Airdrop\Triggers;

use AaronFrancis\Airdrop\Contracts\TriggerContract;
use AaronFrancis\Airdrop\FileSelection;
use Generator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class FileTrigger implements TriggerContract
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
        $include = Arr::get($config, 'include', []);
        $exclude = Arr::get($config, 'exclude', []);
        $excludeNames = Arr::get($config, 'exclude_names', []);

        $files = $this->files($include, $exclude, $excludeNames);

        return collect($files)
            ->diff($exclude)
            ->unique()
            ->values()
            ->mapWithKeys(function ($file) {
                return [
                    // trim the base path off, making everything
                    // relative to the project root.
                    preg_replace('/^' . preg_quote(base_path(), '/') . '/i', '', $file) => File::hash($file)
                ];
            })
            ->sortKeys()
            ->toArray();
    }

    /**
     * @return Generator
     */
    protected function files($include, $exclude, $excludeNames)
    {
        return FileSelection::create($include, $exclude)
            ->excludeNames($excludeNames)
            ->selected();
    }
}
