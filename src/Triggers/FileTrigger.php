<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com>
 */

namespace WilberGroup\Airdrop\Triggers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use WilberGroup\Airdrop\Contracts\TriggerContract;
use WilberGroup\Airdrop\FileSelection;

class FileTrigger implements TriggerContract
{
    public function triggerBuildWhenChanged(array $config = []): array
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

    protected function files(array $include, array $exclude, array $excludeNames): Collection
    {
        return FileSelection::create($include, $exclude)
            ->excludeNames($excludeNames)
            ->selected();
    }
}
