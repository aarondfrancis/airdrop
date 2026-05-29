# Changelog

## 2.0.0 - Unreleased

This release migrates the package to the Wilber Group organization. **It contains breaking changes** — see the upgrade guide below.

### Changed
- **Package renamed** from `aaronfrancis/airdrop` to `wilbergroup/airdrop`.
- **Namespace renamed** from `AaronFrancis\Airdrop` to `WilberGroup\Airdrop`.

### Added
- Laravel 13 support (`illuminate/*` `^13.0`, `orchestra/testbench` `^11.0`).
- PHP 8.5 added to the CI test matrix.

### Upgrading from `aaronfrancis/airdrop`

1. Update your dependency:
   ```bash
   composer remove aaronfrancis/airdrop
   composer require wilbergroup/airdrop
   ```
   (The new package `replace`s the old one, so a transitional period where both are required resolves cleanly.)
2. Update references to the old namespace in your application — most commonly in `config/airdrop.php`, where triggers are referenced by class name:
   ```diff
   - AaronFrancis\Airdrop\Triggers\FileTrigger::class
   + WilberGroup\Airdrop\Triggers\FileTrigger::class
   ```
3. Update any custom drivers or triggers that extend the package's base classes (`use WilberGroup\Airdrop\...`).
4. If you pass a fully-qualified trigger class to `airdrop:debug --trigger=`, update that namespace too.

> **Note:** Because trigger class names are part of the build hash, your computed hash changes after upgrading. The first deploy on this version rebuilds assets once, then resumes skipping as normal.

## 1.1.0 - 2025-11-27

### Added
- PHP 8.4 support

### Changed
- Default config now uses Vite instead of Laravel Mix (`vite.config.js`, `build/manifest.json`, `build/assets`)
- Modernized codebase with strict PHP typing (return types, parameter types, property types)

### Removed
- PHP 8.1 support (EOL November 2024)

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