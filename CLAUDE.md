# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Airdrop is a Laravel package that speeds up deployments by skipping asset compilation when possible. It calculates a hash of build inputs (packages, JS/CSS files, ENV vars, etc.) and reuses previously built assets if the configuration hasn't changed.

Full docs: https://wilbergroup.github.io/airdrop/ (built with Docsify from the `docs/` folder, served via GitHub Pages)

## Commands

```bash
# Run tests
vendor/bin/phpunit

# Run a single test
vendor/bin/phpunit --filter test_name

# Code formatting
vendor/bin/pint

# Check formatting without changes
vendor/bin/pint --test
```

## Architecture

**Drivers** (`src/Drivers/`) - Handle storage/retrieval of built assets:
- `BaseDriver` - Abstract base with `download()` and `upload()` methods
- `FilesystemDriver` - Uses Laravel's filesystem (local, S3, etc.)
- `GithubActionsDriver` - Uses GitHub Actions cache

**Triggers** (`src/Triggers/`) - Determine what affects the build hash:
- Implement `TriggerContract::triggerBuildWhenChanged($config)`
- `FileTrigger` - Hashes file contents
- `ConfigTrigger` - Hashes config values

**Commands** (`src/Commands/`):
- `airdrop:download` - Pull cached assets if hash matches
- `airdrop:upload` - Store built assets with current hash
- `airdrop:hash` - Output current hash
- `airdrop:debug` - Debug trigger outputs
- `airdrop:install` - Publish config file

## Code Style

Uses Laravel Pint with the Laravel preset. Key customizations in `pint.json`:
- `concat_space`: one space around concatenation operator
- `trailing_comma_in_multiline`: false
