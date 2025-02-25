<?php

/**
 * @author Aaron Francis <aaron@hammerstone.dev|https://twitter.com/aarondfrancis>
 */

namespace Hammerstone\Airdrop\Tests;

use Hammerstone\Airdrop\AirdropServiceProvider;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;

abstract class BaseTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            AirdropServiceProvider::class
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // By default base_path points to the TestBench directory,
        // but we need it to reference our app. Adding this link
        // will make it transparent.
        if (!File::exists(base_path() . '/tests/Support')) {
            // Support for older versions of testbench that don't have a tests directory.
            File::ensureDirectoryExists(base_path() . '/tests');
            exec('ln -sf ' . __DIR__ . '/Support ' . base_path() . '/tests/Support');
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        File::deleteDirectory(base_path('storage/framework/testing'));
    }
}
