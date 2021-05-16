<?php
/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace Hammerstone\Airdrop\Tests\Triggers;

use Hammerstone\Airdrop\Tests\BaseTest;
use Hammerstone\Airdrop\Triggers\FileTrigger;

class InputFilesTriggerTest extends BaseTest
{
    /** @test */
    public function the_hashes_are_stable()
    {
        $config = [
            'include' => [
                base_path('tests/Support/primary-webpack.mix.example'),
            ],
        ];

        $hashes = (new FileTrigger())->triggerBuildWhenChanged($config);

        $this->assertEquals('62f6d1bfc836a1536c4869fe8f78249b', array_values($hashes)[0]);
    }

    /** @test */
    public function different_files_give_different_hashes()
    {
        $config = [
            'include' => [
                base_path('tests/Support/secondary-webpack.mix.example'),
            ],
        ];

        $hashes = (new FileTrigger())->triggerBuildWhenChanged($config);

        $this->assertEquals('b8f3f6ee7bc704b0433540bb322423f0', array_values($hashes)[0]);
    }

    /** @test */
    public function multiple_files_get_hashed()
    {
        $config = [
            'include' => [
                base_path('tests/Support/primary-webpack.mix.example'),
                base_path('tests/Support/secondary-webpack.mix.example'),
            ],
        ];

        $hashes = (new FileTrigger())->triggerBuildWhenChanged($config);

        $this->assertEquals('62f6d1bfc836a1536c4869fe8f78249b', array_values($hashes)[0]);
        $this->assertEquals('b8f3f6ee7bc704b0433540bb322423f0', array_values($hashes)[1]);
    }

    /** @test */
    public function files_get_excluded()
    {
        $config = [
            'include' => [
                base_path('tests/Support/primary-webpack.mix.example'),
                base_path('tests/Support/secondary-webpack.mix.example'),
            ],
            'exclude' => [
                base_path('tests/Support/secondary-webpack.mix.example'),
            ],
        ];

        $hashes = (new FileTrigger())->triggerBuildWhenChanged($config);

        $this->assertCount(1, $hashes);
        $this->assertEquals('62f6d1bfc836a1536c4869fe8f78249b', array_values($hashes)[0]);
    }
}
