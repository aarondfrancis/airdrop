<?php

/**
 * @author Aaron Francis <aarondfrancis@gmail.com|https://twitter.com/aarondfrancis>
 */

namespace AaronFrancis\Airdrop\Tests\Commands;

use AaronFrancis\Airdrop\Tests\BaseTest;
use AaronFrancis\Airdrop\Triggers\ConfigTrigger;
use AaronFrancis\Airdrop\Triggers\FileTrigger;
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
            ->expectsOutput('52b0daab48aded4aab3fc7e03af2d128')
            ->assertExitCode(0);
    }

    #[Test]
    public function test_all_triggers_output_w_prefix()
    {
        $this->artisan('airdrop:hash --prefix=foobar-')
            ->expectsOutput('foobar-52b0daab48aded4aab3fc7e03af2d128')
            ->assertExitCode(0);
    }

    #[Test]
    public function test_all_triggers_output_set_env()
    {
        $this->assertEquals('', getenv('AIRDROP_HASH'));

        $this->artisan('airdrop:hash --prefix=foobar- --putenv=AIRDROP_HASH')
            ->expectsOutput('foobar-52b0daab48aded4aab3fc7e03af2d128')
            ->assertExitCode(0);

        $this->assertEquals('foobar-52b0daab48aded4aab3fc7e03af2d128', getenv('AIRDROP_HASH'));
    }
}
