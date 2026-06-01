<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com>
 */

namespace WilberGroup\Airdrop\Tests;

use PHPUnit\Framework\Attributes\Test;
use WilberGroup\Airdrop\HashGenerator;
use WilberGroup\Airdrop\Triggers\ConfigTrigger;
use WilberGroup\Airdrop\Triggers\FileTrigger;

class HashCalculationTest extends BaseTest
{
    #[Test]
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

        $this->assertEquals('315da343a2b1c360838360c8b0f3576a', $hash);
    }

    #[Test]
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
