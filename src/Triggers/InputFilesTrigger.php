<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
 */

namespace Hammerstone\Airdrop\Triggers;

use Generator;
use Illuminate\Support\Arr;
use Hammerstone\Airdrop\FileSelection;
use Hammerstone\Airdrop\Contracts\TriggerContract;

class InputFilesTrigger implements TriggerContract
{
    /**
     * Return any state that should be considered when determining
     * whether or not your build process needs to run again.
     *
     * @param array $config
     * @return array
     */
    public function triggerBuildWhenChanged($config = [])
    {
        $include = Arr::get($config, 'include', []);
        $exclude = Arr::get($config, 'exclude', []);
        $trim = Arr::get($config, 'trim', '__nonexistent');

        return collect($this->files($include, $exclude))
            ->diff($exclude)
            ->unique()
            ->values()
            ->mapWithKeys(function ($file) use ($trim) {
                return [
                    // Trim the first part of the path off if the user has requested it.
                    preg_replace('/^' . preg_quote($trim, '/') . '/i', '', $file) => md5_file($file)
                ];
            })
            ->toArray();
    }

    /**
     * @param $include
     * @param $exclude
     * @return Generator
     */
    protected function files($include, $exclude)
    {
        return FileSelection::create($include)
            ->excludeFilesFrom($exclude)
            ->selectedFiles();
    }

}