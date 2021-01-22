<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
 */

namespace Hammerstone\Airdrop\Tests\Triggers;

use Orchestra\Testbench\TestCase;
use Hammerstone\Airdrop\HashGenerator;
use Hammerstone\Airdrop\AirdropServiceProvider;
use Hammerstone\Airdrop\Triggers\InputFilesTrigger;

class InputFilesTriggerTest extends TestCase
{
    /** @test */
    public function the_hashes_are_stable()
    {
        $config = [
            'include' => [
                dirname(__DIR__) . '/Support/primary-webpack.mix.example'
            ]
        ];

        $hashes = (new InputFilesTrigger)->triggerBuildWhenChanged($config);

        $this->assertEquals('62f6d1bfc836a1536c4869fe8f78249b', array_values($hashes)[0]);
    }

    /** @test */
    public function different_files_give_different_hashes()
    {
        $config = [
            'include' => [
                dirname(__DIR__) . '/Support/secondary-webpack.mix.example'
            ]
        ];

        $hashes = (new InputFilesTrigger)->triggerBuildWhenChanged($config);

        $this->assertEquals('b8f3f6ee7bc704b0433540bb322423f0', array_values($hashes)[0]);
    }

    /** @test */
    public function multiple_files_get_hashed()
    {
        $config = [
            'include' => [
                dirname(__DIR__) . '/Support/primary-webpack.mix.example',
                dirname(__DIR__) . '/Support/secondary-webpack.mix.example'
            ]
        ];

        $hashes = (new InputFilesTrigger)->triggerBuildWhenChanged($config);

        $this->assertEquals('62f6d1bfc836a1536c4869fe8f78249b', array_values($hashes)[0]);
        $this->assertEquals('b8f3f6ee7bc704b0433540bb322423f0', array_values($hashes)[1]);
    }

    /** @test */
    public function files_get_excluded()
    {
        $config = [
            'include' => [
                dirname(__DIR__) . '/Support/primary-webpack.mix.example',
                dirname(__DIR__) . '/Support/secondary-webpack.mix.example'
            ],
            'exclude' => [
                dirname(__DIR__) . '/Support/secondary-webpack.mix.example'
            ]
        ];

        $hashes = (new InputFilesTrigger)->triggerBuildWhenChanged($config);

        $this->assertCount(1, $hashes);
        $this->assertEquals('62f6d1bfc836a1536c4869fe8f78249b', array_values($hashes)[0]);
    }

}