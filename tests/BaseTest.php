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
        exec('ln -sf ' . __DIR__ . ' ' . base_path());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        File::deleteDirectory(base_path('storage/framework/testing'));
    }

}