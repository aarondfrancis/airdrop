# Filesystem Driver

The Filesystem Driver is the default driver that we ship with. It stores all of your built assets as a `.zip` on a filesystem of your choosing. 


## Configuration

If you'd like to change the configuration, you can do so in `airdrop.php`.

config/airdrop.php{.filename}
```php
[
    'drivers' => [
        'default' => [
            // The class responsible for implementing the stash and restore
            // logic. Must extend BaseDriver.
            'class' => FilesystemDriver::class,
        
            // The disk on which to store the built files.
            'disk' => env('AIRDROP_REMOTE_DISK', 's3'),
        
            // The folder (if any) where you'd like your stashed assets to reside.
            'remote_directory' => env('AIRDROP_REMOTE_DIR', 'airdrop'),
        
            // A writeable directory on the machine that builds the assets.
            // Used to build up the ZIP file before stashing it.
            'local_tmp_directory' => env('AIRDROP_LOCAL_TMP_DIR', storage_path('framework')),
        
            // The skip file is an empty file that will be created to
            // indicate that asset building can be skipped.
            'skip_file' => env('AIRDROP_SKIP_FILE', base_path('.airdrop_skip')),
        ]
    ],
]

```


`disk` controls which disk your built files are stored on.

`remote_directory` allows you to place all of your built assets in a subdirectory on your remote disk, to avoid cluttering up the root directory.

`local_tmp_directory` is a place that Airdrop can use to create the `.zip` file before it is uploaded. Airdrop will clean up after itself, so nothing will be left behind once it's done.

`skip_file` is the file we referenced in the [deploying](/deploying) section. It's used as a signal to other processes that the built files have been successfully restored, and they do not need to be built again.

