<?php

/**
 * @author Aaron Francis
 * @author Spatie bvba info@spatie.be
 * @license MIT
 *
 * @see https://github.com/spatie/laravel-backup/blob/master/src/Tasks/Backup/FileSelection.php
 */

namespace WilberGroup\Airdrop;

use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class FileSelection
{
    protected \Illuminate\Support\Collection $includeFilesAndDirectories;

    protected \Illuminate\Support\Collection $excludeFilesAndDirectories;

    protected array $excludeNames = [];

    protected bool $shouldFollowLinks = false;

    public static function create(array $include = [], array $exclude = []): static
    {
        return new static($include, $exclude);
    }

    public function __construct(array $include = [], array $exclude = [])
    {
        $this->includeFilesAndDirectories = collect($include);
        $this->excludeFilesAndDirectories = collect($exclude);
    }

    public function excludeNames(array $patterns): static
    {
        $this->excludeNames = $patterns;

        return $this;
    }

    public function excludeFilesFrom(array|string $excludeFilesAndDirectories): static
    {
        $this->excludeFilesAndDirectories = $this->excludeFilesAndDirectories->merge($this->sanitize($excludeFilesAndDirectories));

        return $this;
    }

    public function shouldFollowLinks(bool $shouldFollowLinks): static
    {
        $this->shouldFollowLinks = $shouldFollowLinks;

        return $this;
    }

    public function selected(): \Illuminate\Support\Collection
    {
        return collect($this->yieldSelectedFiles())->diff($this->excludeFilesAndDirectories);
    }

    protected function yieldSelectedFiles(): \Generator|array
    {
        if ($this->includeFilesAndDirectories->isEmpty()) {
            return [];
        }

        $finder = (new Finder)
            ->ignoreDotFiles(false)
            ->ignoreVCS(false)
            ->files()
            ->notName($this->excludeNames);

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
            if ($this->shouldExclude($file->getRealPath())) {
                continue;
            }

            yield $file->getPathname();
        }
    }

    protected function includedFiles(): array
    {
        return $this->includeFilesAndDirectories
            ->each(function ($path) {
                if (!is_file($path) && !is_dir($path)) {
                    throw new \Exception($path . ' is neither a file nor a directory.');
                }
            })
            ->filter(function ($path) {
                return is_file($path);
            })
            ->toArray();
    }

    protected function includedDirectories(): array
    {
        return $this->includeFilesAndDirectories
            ->each(function ($path) {
                if (!is_file($path) && !is_dir($path)) {
                    throw new \Exception($path . ' is neither a file nor a directory.');
                }
            })
            ->reject(function ($path) {
                return is_file($path);
            })
            ->toArray();
    }

    protected function shouldExclude(string $path): bool
    {
        foreach ($this->excludeFilesAndDirectories as $excludedPath) {
            if (Str::startsWith($path, $excludedPath)) {
                return true;
            }
        }

        return false;
    }

    protected function sanitize(array|string $paths): \Illuminate\Support\Collection
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
