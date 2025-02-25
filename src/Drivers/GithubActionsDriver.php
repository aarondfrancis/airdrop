<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com|https://twitter.com/aarondfrancis>
 */

namespace AaronFrancis\Airdrop\Drivers;

class GithubActionsDriver extends FilesystemDriver
{
    public function exists()
    {
        return file_exists($this->localStashPath() . $this->stashedPackageFilename());
    }

    protected function downloadFromRemoteStorage($zipPath)
    {
        // For GitHub actions there is no downloading required.
        // The file will be placed in the appropriate location
        // by the Cache step of the workflow.
    }

    protected function uploadToRemoteStorage($zipPath)
    {
        // No upload is required  either. GitHub will take the
        // zip from the tmp directory and cache it for us for
        // later use.
    }
}
