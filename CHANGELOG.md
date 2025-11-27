# Changelog

## Unreleased

### Added
- PHP 8.4 support in CI test matrix

### Changed
- Default config now uses Vite instead of Laravel Mix (`vite.config.js`, `build/manifest.json`, `build/assets`)
- Modernized codebase with strict PHP typing (return types, parameter types, property types)
- Updated minimum dev dependency versions for PHPUnit 10+ compatibility
- CI workflow now uses local Pint instead of global installation

### Removed
- Support for PHPUnit 8 and 9
- Support for Orchestra Testbench < 8.21 and < 9.2
- Unused MySQL service from CI workflow
- Legacy test script

## 0.2.3 - 2022-02-15
- Added: Support for Laravel 9

## 0.2.2 - 2021-08-04
- Fixed: Triggers are now sorted to provide more stability across machines.

## 0.2.1 - 2021-07-22
- Added `exclude_names` to both the FileTrigger and output config. This will let you ignore filenames, regardless of what folder they show up in. E.g. `.DS_Store`

## 0.2.0 - 2021-05-31

- Added `airdrop:hash` command.
- Added GitHub Actions driver.

## 0.1.0 - 2021-05-16

- No changes, just moving to 0.1.0 release.

## 0.0.3 - 2021-03-05

- Added `airdrop:debug` command.

## 0.0.2 - 2021-02-23

- Added support for `--verbose` flag on commands.

## 0.0.1 - 2021-02-22

Initial Release