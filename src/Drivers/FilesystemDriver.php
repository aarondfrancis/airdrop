<?php
/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace Hammerstone\Airdrop\Drivers;

use Exception;
use Hammerstone\Airdrop\FileSelection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class FilesystemDriver extends BaseDriver
{
    /**
     * Called after building, to stash the files somewhere.
     */
    public function upload()
    {
        // Remove the skip file that `restore` might have created.
        File::delete($this->skipFilePath());

        if ($this->exists()) {
            // This exact configuration of assets is already stashed,
            // so we don't need to do it again.
            $this->output('Files already exist on remote storage, not uploading.');

            return;
        }

        $zipPath = $this->localStashPath() . $this->stashedPackageFilename();

        $this->output('Making zip file at ' . $zipPath);

        $this->makeZip($zipPath);

        $this->output('Uploading to remote disk at ' . $this->remoteStashPath() . $this->stashedPackageFilename());

        $this->disk()->putFileAs(
            $this->remoteStashPath(),
            $zipPath,
            $this->stashedPackageFilename()
        );

        // Clean up after ourselves once it's uploaded.
        File::delete($zipPath);
    }

    /**
     * @param $path
     * @throws Exception
     */
    public function makeZip($path)
    {
        $zip = new ZipArchive;

        // Open a zip file to put all the files in.
        $opened = $zip->open($path, ZipArchive::CREATE);

        if ($opened !== true) {
            throw new Exception('Airdrop is trying to stash assets, but was unable to open a zip at ' . json_encode($path));
        }

        $files = $this->files();

        foreach ($files as $file) {
            // We don't want fully qualified paths, so remove the base_path.
            $zip->addFile($file, Str::replaceFirst(base_path(), '', $file));
        }

        $zip->close();
    }

    /**
     * Called before building files, to see if we can skip that
     * altogether and just download them.
     */
    public function download()
    {
        if ($this->extract()) {
            $this->output('Assets downloaded and extracted.');
            // Touch a file that can be used to inform the deploy
            // process that building assets can be skipped.
            File::put($this->skipFilePath(), '');
        } else {
            $this->output('Assets did not exist.');
            // Remove the file if extraction did not succeed.
            File::delete($this->skipFilePath());
        }
    }

    public function extract()
    {
        if (!$this->exists()) {
            return false;
        }

        $zipPath = $this->localStashPath() . $this->stashedPackageFilename();

        // Download the file to local disk as a stream.
        File::put(
            $zipPath,
            $this->disk()->readStream($this->remoteStashPath() . $this->stashedPackageFilename())
        );

        $zip = new ZipArchive;

        $status = $zip->open($zipPath);

        if ($status !== true) {
            throw new Exception('Airdrop was trying to extract previously built assets, but could not open the zip file at ' . json_encode($zipPath));
        }

        // Put all the assets back where they should be.
        $extracted = $zip->extractTo(base_path());

        if (!$extracted) {
            throw new Exception('Zip not extracted');
        }

        $zip->close();

        // Remove the zip now that we're done.
        File::delete($zipPath);

        return true;
    }

    public function files()
    {
        $include = config('airdrop.outputs.include') ?? [];
        $exclude = config('airdrop.outputs.exclude') ?? [];

        return FileSelection::create($include, $exclude)->selected();
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function disk()
    {
        return Storage::disk($this->config['disk']);
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return $this->disk()->exists($this->remoteStashPath() . $this->stashedPackageFilename());
    }

    /**
     * @return string
     */
    protected function skipFilePath()
    {
        return Arr::get($this->config, 'skip_file');
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
        $dir = Arr::get($this->config, 'remote_directory');

        return $dir ? Str::finish($dir, '/') : $dir;
    }

    /**
     * @return string
     */
    protected function localStashPath()
    {
        $tmp = Arr::get($this->config, 'local_tmp_directory');

        return Str::finish($tmp, '/');
    }
}
