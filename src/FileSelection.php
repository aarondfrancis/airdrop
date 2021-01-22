<?php

/**
 * @author Spatie bvba info@spatie.be
 * @license MIT
 * @see https://github.com/spatie/laravel-backup/blob/master/src/Tasks/Backup/FileSelection.php
 */

namespace Hammerstone\Airdrop;

use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class FileSelection
{
    /** @var \Illuminate\Support\Collection */
    protected $includeFilesAndDirectories;

    /** @var \Illuminate\Support\Collection */
    protected $excludeFilesAndDirectories;

    /** @var bool */
    protected $shouldFollowLinks = false;

    /**
     * @param array|string $includeFilesAndDirectories
     *
     * @return FileSelection
     */
    public static function create($includeFilesAndDirectories = [])
    {
        return new static($includeFilesAndDirectories);
    }

    /**
     * @param array|string $includeFilesAndDirectories
     */
    public function __construct($includeFilesAndDirectories = [])
    {
        $this->includeFilesAndDirectories = collect($includeFilesAndDirectories);

        $this->excludeFilesAndDirectories = collect();
    }

    /**
     * Do not included the given files and directories.
     *
     * @param array|string $excludeFilesAndDirectories
     *
     * @return FileSelection
     */
    public function excludeFilesFrom($excludeFilesAndDirectories)
    {
        $this->excludeFilesAndDirectories = $this->excludeFilesAndDirectories->merge($this->sanitize($excludeFilesAndDirectories));

        return $this;
    }

    public function shouldFollowLinks(bool $shouldFollowLinks)
    {
        $this->shouldFollowLinks = $shouldFollowLinks;

        return $this;
    }

    /**
     * @return \Generator|string[]
     */
    public function selectedFiles()
    {
        if ($this->includeFilesAndDirectories->isEmpty()) {
            return [];
        }

        $finder = (new Finder())
            ->ignoreDotFiles(false)
            ->ignoreVCS(false)
            ->files();

        if ($this->shouldFollowLinks) {
            $finder->followLinks();
        }

        foreach ($this->includedFiles() as $includedFile) {
            yield $includedFile;
        }

        if (!count($this->includedDirectories())) {
            return;
        }

        $finder->in($this->includedDirectories());

        foreach ($finder->getIterator() as $file) {
            if ($this->shouldExclude($file)) {
                continue;
            }

            yield $file->getPathname();
        }
    }

    protected function includedFiles()
    {
        return $this->includeFilesAndDirectories->filter(function ($path) {
            return is_file($path);
        })->toArray();
    }

    protected function includedDirectories()
    {
        return $this->includeFilesAndDirectories->reject(function ($path) {
            return is_file($path);
        })->toArray();
    }

    protected function shouldExclude(string $path): bool
    {
        foreach ($this->excludeFilesAndDirectories as $excludedPath) {
            if (Str::startsWith(realpath($path), $excludedPath)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string|array $paths
     *
     * @return \Illuminate\Support\Collection
     */
    protected function sanitize($paths)
    {
        return collect($paths)
            ->reject(function ($path) {
                return $path === '';
            })
            ->flatMap(function ($path) {
                return glob($path);
            })
            ->map(function ($path) {
                return realpath($path);
            })
            ->reject(function ($path) {
                return $path === false;
            });
    }
}
