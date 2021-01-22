<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
 */

namespace Hammerstone\Airdrop;


use Hammerstone\Airdrop\Contracts\StashAndRestoreDriverContract;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class FilesystemDriver implements StashAndRestoreDriverContract
{
    /**
     * Config for this specific driver.
     *
     * @var array
     */
    protected $config;

    /**
     * Current hash based on all inputs.
     *
     * @var string
     */
    protected $hash;

    /**
     * @param string $config
     * @param string $hash
     */
    public function __construct($config, $hash)
    {
        $this->config = $config;
        $this->hash = $hash;
    }

    /**
     * Called after building, to stash the files somewhere.
     */
    public function stash()
    {
        if ($this->exists()) {
            // This exact configuration of assets is already stashed,
            // so we don't need to do it again.
            return;
        }

        $zip = new ZipArchive;

        // Open a zip file to add all these files to.
        $zip->open($this->localStashPath(), ZipArchive::CREATE);

        // @TODO get the files

        foreach ($files as $file) {
            // We don't want fully qualified paths, so remove the base_path.
            $zip->addFile($file, Str::replaceFirst(base_path(), '', $file));
        }

        $zip->close();

        $this->disk()->putFileAs($this->remoteStashPath(), new File($this->localStashPath()));

        // Clean up after ourselves once it's uploaded.
        @unlink($this->localStashPath());
    }

    /**
     * Called before building files, to see if we can skip that
     * altogether and just download them.
     */
    public function restore()
    {
        $this->extract()
            // Touch a file that can be used to inform the deploy
            // process that building assets can be skipped.
            ? touch($this->skipFilePath())
            // Remove the file is extraction did not succeed.
            : @unlink($this->skipFilePath());
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function disk()
    {
        return Storage::disk($this->config->disk);
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return $this->disk()->exists($this->hash);
    }

    /**
     * @return string
     */
    protected function skipFilePath()
    {
        return base_path('.airdrop_skip');
    }

    /**
     * @return string
     */
    protected function stashedPackageFilename()
    {
        return "airdrop-{$this->hash}.zip";
    }

    /**
     * @return string
     */
    protected function remoteStashPath()
    {
        $tmp = Arr::get($this->config, 'remote_directory');

        return Str::finish($tmp, '/') . $this->stashedPackageFilename();
    }

    /**
     * @return string
     */
    protected function localStashPath()
    {
        $tmp = Arr::get($this->config, 'local_tmp_directory');

        return Str::finish($tmp, '/') . $this->stashedPackageFilename();
    }

    public function downloadAssets($hash)
    {
        $root = Storage::disk('root');
        $s3 = Storage::disk('s3');
        $s3basepath = Filesystem::registerStreamWrapper($s3);

        $root->put(
            'storage/tmp/assets.zip',
            file_get_contents("$s3basepath/artifacts/assets/$hash.zip")
        );

        try {
            $this->extract();
        } catch (Exception $e) {
            return false;
        } finally {
            $root->delete('storage/tmp/assets.zip');
        }

        foreach ((new Finder)->in(storage_path($this->tmp))->files() as $file) {
            /** @var $file SplFileInfo */
            $source = $file->getRealPath();

            $dest = Str::replaceFirst(storage_path("{$this->tmp}/"), '', $file);

            // Recursively make directories that might not be there.
            $root->makeDirectory(dirname('public/' . $dest));

            // Make it absolute so we can use the `copy` function.
            $dest = public_path($dest);

            if (!copy($source, $dest)) {
                return false;
            }
        }

        return true;
    }

    public function extract()
    {
        if (!$this->exists($this->hash)) {
            return false;
        }

        $zip = new ZipArchive;

        $status = $zip->open(storage_path('tmp/assets.zip'));

        if ($status !== true) {
            throw new Exception('Zip not opened');
        }

        $extracted = $zip->extractTo(storage_path($this->tmp));

        if (!$extracted) {
            throw new Exception('Zip not extracted');
        }

        $zip->close();
    }
}