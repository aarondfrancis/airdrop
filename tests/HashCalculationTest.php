<?php
/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace Hammerstone\Airdrop\Tests;

use Hammerstone\Airdrop\HashGenerator;
use Hammerstone\Airdrop\Triggers\ConfigTrigger;
use Hammerstone\Airdrop\Triggers\FileTrigger;

class HashCalculationTest extends BaseTest
{
    /** @test */
    public function it_tests_basic_file_hash()
    {
        config()->set('airdrop.triggers', [
            FileTrigger::class => [
                'include' => [
                    base_path('tests/Support/primary-webpack.mix.example'),
                ]
            ]
        ]);

        $array = (new HashGenerator)->asArray();

        $this->assertEquals([
            FileTrigger::class => [
                '/tests/Support/primary-webpack.mix.example' => '62f6d1bfc836a1536c4869fe8f78249b'
            ]
        ], $array);

        $hash = (new HashGenerator)->generate();

        $this->assertEquals('36eda7109ca99a5fb55cffefeca3c554', $hash);
    }

    /** @test */
    public function it_gets_sorted()
    {
        config()->set('airdrop.triggers', [
            ConfigTrigger::class => [
                'a_key' => 'test',
                'b_key' => 'test'
            ],
            FileTrigger::class => [
                'include' => [
                    base_path('tests/Support/primary-webpack.mix.example'),
                    base_path('tests/Support/secondary-webpack.mix.example'),
                ]
            ]
        ]);

        $hash1 = (new HashGenerator)->generate();

        config()->set('airdrop.triggers', [
            FileTrigger::class => [
                'include' => [
                    base_path('tests/Support/secondary-webpack.mix.example'),
                    base_path('tests/Support/primary-webpack.mix.example'),
                ]
            ],
            ConfigTrigger::class => [
                'b_key' => 'test',
                'a_key' => 'test',
            ],
        ]);

        $hash2 = (new HashGenerator)->generate();

        $this->assertEquals($hash1, $hash2);

    }
}
