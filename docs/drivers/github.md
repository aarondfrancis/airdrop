# GitHub Actions Driver

The GitHub Actions driver works as a part of your GitHub Workflows to cache built assets from run to run, even across branches. 

When using the GitHub driver, there is _no need_ for a remote disk anywhere. Instead, we rely on the [Cache Action](https://docs.github.com/en/actions/guides/caching-dependencies-to-speed-up-workflows) to cache the built files for us.

## Configuration

The GitHub driver is an extension of the Filesystem driver so much of the configuration is the same, although fewer items are needed. 

config/airdrop.php {.filename}
```php
[
    'drivers' => [
         'github' => [
            // Use in conjunction with the Cache step in GitHub Actions.
            'class' => GithubActionsDriver::class,

            // Make sure this matches the `path` key in the
            // cache step of your GitHub Actions Workflow.
            'local_tmp_directory' => env('AIRDROP_LOCAL_TMP_DIR', '/tmp/'),

            // The skip file is an empty file that will be created to
            // indicate that asset building can be skipped.
            'skip_file' => env('AIRDROP_SKIP_FILE', base_path('.airdrop_skip')),
        ]
    ],
]

```

`local_tmp_directory` is a place that Airdrop can use to create the `.zip` file before it is uploaded. This needs to match that path that you put in your `[workflow].yml` file.

`skip_file` is the file we referenced in the [deploying](/deploying) section. It's used as a signal to other processes that the built files have been successfully restored, and they do not need to be built again.

## GitHub Workflow Configuration

There are a couple steps you'll need to add to your GitHub Workflow to take advantage of the asset caching.

The first step is to calculate the hash of the inputs and save it in the environment for the cache step to use:

.github/workflows/deploy.yml {.filename}
```yaml
- name: Generate Airdrop Hash
  run: echo "AIRDROP_HASH=$(php artisan airdrop:hash)" >> $GITHUB_ENV
```

This command is going to run `php artisan airdrop:hash` to calculate the hash of all the inputs, and then it is going to store it as an environment variable named `AIRDROP_HASH`. This allows the cache step to look for the right key.

The next step you'll need to add is the cache step:

.github/workflows/deploy.yml {.filename}
```yaml
- name: Generate Airdrop Hash
  run: echo "AIRDROP_HASH=$(php artisan airdrop:hash)" >> $GITHUB_ENV

- name: Cache Airdrop Assets # [tl! ~~]
  uses: actions/cache@v2 # [tl! ~~]
  with: # [tl! ~~]
    key: ${{ runner.os }}-airdrop-${{ env.AIRDROP_HASH }} # [tl! ~~]
    path: /tmp/airdrop-* # [tl! ~~]
```

This step will cache the built zip file from Airdrop, and save it for up to seven days, per GitHub's [usage limits](https://docs.github.com/en/actions/guides/caching-dependencies-to-speed-up-workflows#usage-limits-and-eviction-policy). (Remember that if a cache misses, your app will simply rebuild the assets!)
 