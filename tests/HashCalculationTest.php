<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
 */

namespace Hammerstone\Airdrop\Tests;

use Orchestra\Testbench\TestCase;
use Hammerstone\Airdrop\HashGenerator;
use Hammerstone\Airdrop\AirdropServiceProvider;
use Hammerstone\Airdrop\Triggers\InputFilesTrigger;

class HashCalculationTest extends BaseTest
{
    protected function getPackageProviders($app)
    {
        return [
            AirdropServiceProvider::class
        ];
    }

    /** @test */
    public function it_tests_basic_file_hash()
    {
        config()->set('airdrop.triggers', [
            InputFilesTrigger::class => [
                'trim' => $this->basePath(),
                'include' => [
                    $this->basePath('tests/Support/primary-webpack.mix.example'),
                ]
            ]
        ]);

        $array = (new HashGenerator)->asArray();

        $this->assertEquals([
            InputFilesTrigger::class => [
                "/tests/Support/primary-webpack.mix.example" => "62f6d1bfc836a1536c4869fe8f78249b"
            ]
        ], $array);

        $hash = (new HashGenerator)->generate();

        $this->assertEquals('bf3e492980dd286b875ea06ce67de948', $hash);
    }
}