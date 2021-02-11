
# Deploying

To integrate Airdrop into your build process, you'll need to do a few things.

## Adding the Airdrop Commands

The first thing you'll need to do is run `php artisan airdrop:download` _before_ you build your assets. This is the command that will download and place your built assets, if they are available.

The next thing you'll need to do is run `php artisan airdrop:upload` _after_ you build your assets. This command will store the built assets, if they aren't already stored.

This will take care of downloading and uploading your assets, should that be required.

Once you're done, your asset step will look something like this:

```bash
php artisan airdop:download
npm run production
php artisan airdrop:upload
```

## Skipping Asset Compilation

The next (and last!) thing we need to change is the skipping of the compilation of assets if it isn't required.

The FilesystemDriver creates a flag file called `.airdrop_skip` if the asset building step can be skipped, so we need to check for the existence of that file.

### Laravel Mix
If you're using Laravel Mix you can modify your `webpack.mix.js` file to see if that file exists, and return early if it does:

```js
// Exit early if assets don't need to be built.
if (require('fs').existsSync('.airdrop_skip')) {
    console.log("Assets already exist. Skipping compilation.");
    process.exit(0);
}

// Rest of the file...
``` 
{data-filename="webpack.mix.js"}

### Bash

If you're not using Laravel Mix, or you want to skip several steps based on the existence of that file, you can do so using bash.

```bash
php artisan airdrop:download

# Skip several steps if we can.
if [ ! -f ".airdrop_skip" ]; then
    nvm install
    nvm use
    yarn install --frozen-lockfile
    npm run production
fi

php artisan airdrop:upload
```

Now we're skipping multiple potentially expensive commands based on the presence of the Airdrop skip file. 

> Remember: If you change the path of the skip file in your configuration, you'll need to change it in your Mix / Bash file as well.



