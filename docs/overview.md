
# Airdrop for Laravel

> View this package on Github [github.com/hammerstonehq/airdrop](https://github.com/hammerstonehq/airdrop).

Hammerstone Airdrop for Laravel is a package that speeds up your code deploys by skipping your asset build step whenever possible.

When you're deploying your code, Airdrop will calculate a hash of everything needed to build your assets: installed packages, JS/CSS files, ENV vars, etc. 

After Airdrop has calculated a hash for these inputs, it will check to see if it has ever built this exact configuration before. If it has, it will pull down the built assets and put them in place, letting you skip the expensive build step.

![Flowchart](/flowchart.png){style="width: 698px"}

This can reduce the time your deploys and CI runs take from minutes down to just a few seconds:

<div class='flex justify-center my-4'>
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">We&#39;ve sped up our <a href="https://twitter.com/ChipperCI?ref_src=twsrc%5Etfw">@ChipperCI</a> pipeline quite a bit by not building our assets if nothing on the frontend has changed, but instead downloading them from S3 already built.<br><br>Usually takes 1-3 minutes to build the assets, we can pull them off of S3 in seconds! <a href="https://t.co/owdZOEcJwP">pic.twitter.com/owdZOEcJwP</a></p>&mdash; Aaron Francis (@aarondfrancis) <a href="https://twitter.com/aarondfrancis/status/1180161402188771328?ref_src=twsrc%5Etfw">October 4, 2019</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>