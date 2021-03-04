<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com|https://twitter.com/aarondfrancis>
 */

namespace Hammerstone\Airdrop\Tests\Commands;

use Hammerstone\Airdrop\Tests\BaseTest;
use Hammerstone\Airdrop\Triggers\ConfigTrigger;
use Hammerstone\Airdrop\Triggers\FileTrigger;

class DebugCommandTest extends BaseTest
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
        $expected = <<<EOT
{
    "Hammerstone\\\Airdrop\\\Triggers\\\ConfigTrigger": {
        "env": "testing"
    },
    "Hammerstone\\\Airdrop\\\Triggers\\\FileTrigger": {
        "\/tests\/Support\/primary-webpack.mix.example": "62f6d1bfc836a1536c4869fe8f78249b"
    }
}
EOT;

        $this->artisan('airdrop:debug')
            ->expectsOutput($expected)
            ->assertExitCode(0);
    }


    /** @test */
    public function test_single_trigger()
    {
        $expected = <<<EOT
{
    "Hammerstone\\\Airdrop\\\Triggers\\\ConfigTrigger": {
        "env": "testing"
    }
}
EOT;

        $this->artisan('airdrop:debug --trigger=Hammerstone\\\Airdrop\\\Triggers\\\ConfigTrigger')
            ->expectsOutput($expected)
            ->assertExitCode(0);
    }


}