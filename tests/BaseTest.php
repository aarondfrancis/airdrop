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
            AirdropServiceProvider::class,
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        File::deleteDirectory(base_path('storage/framework/testing'));
    }

    protected function getBasePath()
    {
        // By default base_path points to the TestBench directory,
        // we want it to point to the root of our package.
        return dirname(__DIR__);
    }
}
