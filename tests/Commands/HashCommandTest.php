<?php

/**
 * @author Aaron Francis <aarondfrancis@gmail.com|https://twitter.com/aarondfrancis>
 */

namespace WilberGroup\Airdrop\Tests\Commands;

use WilberGroup\Airdrop\Tests\BaseTest;
use WilberGroup\Airdrop\Triggers\ConfigTrigger;
use WilberGroup\Airdrop\Triggers\FileTrigger;
use PHPUnit\Framework\Attributes\Test;

class HashCommandTest extends BaseTest
{
    public function getEnvironmentSetUp($app)
    {
        config()->set('airdrop.triggers', [
            ConfigTrigger::class => [
                'env' => 'testing'
            ],
            FileTrigger::class => [
                'trim' => base_path(),
                'include' => [
                    base_path('tests/Support/primary-webpack.mix.example'),
                ]
            ]
        ]);
    }

    #[Test]
    public function test_all_triggers_output()
    {
        $this->artisan('airdrop:hash')
            ->expectsOutput('7781a12dacd61e881f3be5b39b0161cb')
            ->assertExitCode(0);
    }

    #[Test]
    public function test_all_triggers_output_w_prefix()
    {
        $this->artisan('airdrop:hash --prefix=foobar-')
            ->expectsOutput('foobar-7781a12dacd61e881f3be5b39b0161cb')
            ->assertExitCode(0);
    }

    #[Test]
    public function test_all_triggers_output_set_env()
    {
        $this->assertEquals('', getenv('AIRDROP_HASH'));

        $this->artisan('airdrop:hash --prefix=foobar- --putenv=AIRDROP_HASH')
            ->expectsOutput('foobar-7781a12dacd61e881f3be5b39b0161cb')
            ->assertExitCode(0);

        $this->assertEquals('foobar-7781a12dacd61e881f3be5b39b0161cb', getenv('AIRDROP_HASH'));
    }
}
