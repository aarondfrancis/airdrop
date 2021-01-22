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

        config()->set('airdrop.triggers', [
            $filesTrigger => [
                'trim' => realpath(__DIR__ . '/../'),
                'include' => [
                    __DIR__ . '/Support/primary-webpack.mix.example',
                ]
            ]
        ]);

        $array = (new HashGenerator)->asArray();

        $this->assertEquals([
            "Hammerstone\Airdrop\Triggers\InputFilesTrigger" => [
                "/tests/Support/primary-webpack.mix.example" => "62f6d1bfc836a1536c4869fe8f78249b"
            ]
        ], $array);

        $hash = (new HashGenerator)->generate();

        $this->assertEquals('bf3e492980dd286b875ea06ce67de948', $hash);
    }
}