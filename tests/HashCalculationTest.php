<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
 */

namespace Hammerstone\Airdrop\Tests;

use Orchestra\Testbench\TestCase;
use Hammerstone\Airdrop\HashGenerator;
use Hammerstone\Airdrop\AirdropServiceProvider;
use Hammerstone\Airdrop\Triggers\InputFilesTrigger;

class HashCalculationTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            AirdropServiceProvider::class
        ];
    }

    /** @test */
    public function it_tests()
    {
        $filesTrigger = InputFilesTrigger::class;

        config()->set("airdrop.triggers.$filesTrigger.include", [
            __DIR__,
            __DIR__ . '/Support/webpack.mix.example'
        ]);

        dump((new HashGenerator(config('airdrop')))->hash());
    }

}