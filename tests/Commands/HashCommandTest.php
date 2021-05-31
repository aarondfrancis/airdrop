<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com|https://twitter.com/aarondfrancis>
 */

namespace Hammerstone\Airdrop\Tests\Commands;

use Hammerstone\Airdrop\Tests\BaseTest;
use Hammerstone\Airdrop\Triggers\ConfigTrigger;
use Hammerstone\Airdrop\Triggers\FileTrigger;

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

    /** @test */
    public function test_all_triggers_output()
    {
        $this->artisan('airdrop:hash')
            ->expectsOutput('acf41088634d35afb8351a0839745f2a')
            ->assertExitCode(0);
    }

    /** @test */
    public function test_all_triggers_output_w_prefix()
    {
        $this->artisan('airdrop:hash --prefix=foobar-')
            ->expectsOutput('foobar-acf41088634d35afb8351a0839745f2a')
            ->assertExitCode(0);
    }

    /** @test */
    public function test_all_triggers_output_set_env()
    {
        $this->assertEquals('', getenv('AIRDROP_HASH'));

        $this->artisan('airdrop:hash --prefix=foobar- --putenv=AIRDROP_HASH')
            ->expectsOutput('foobar-acf41088634d35afb8351a0839745f2a')
            ->assertExitCode(0);

        $this->assertEquals('foobar-acf41088634d35afb8351a0839745f2a', getenv('AIRDROP_HASH'));
    }
}
