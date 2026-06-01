<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com|https://twitter.com/aarondfrancis>
 */

namespace WilberGroup\Airdrop\Tests\Drivers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use WilberGroup\Airdrop\Concerns\MakesDrivers;
use WilberGroup\Airdrop\Tests\BaseTest;
use WilberGroup\Airdrop\Triggers\FileTrigger;

class FileSystemDriverTest extends BaseTest
{
    use MakesDrivers;

    public function getEnvironmentSetUp($app)
    {
        Storage::fake('s3');

        config()->set('airdrop.triggers', [
            FileTrigger::class => [
                'trim' => base_path(),
                'include' => [
                    base_path('tests/Support/primary-webpack.mix.example'),
                ]
            ]
        ]);

        config()->set('airdrop.outputs.include', [
            base_path('tests/Support/public')
        ]);
    }

    #[Test]
    public function it_creates_and_uploads_a_zip()
    {
        Storage::fake('s3');

        $this->artisan('airdrop:upload');

        Storage::disk('s3')->assertExists('airdrop/airdrop-315da343a2b1c360838360c8b0f3576a.zip');
    }

    #[Test]
    public function names_get_excluded()
    {
        Storage::fake('s3');

        config()->set('airdrop.outputs.include', [
            base_path('tests/Support/public')
        ]);

        config()->set('airdrop.outputs.exclude_names', [
            'app.js'
        ]);

        $files = $this->makeDriver()->files();

        $this->assertCount(1, $files);
        $this->assertStringEndsWith('css/app.css', $files[0]);
    }

    #[Test]
    public function it_downloads_and_restores()
    {
        $this->artisan('airdrop:upload');

        // Back up the public directory.
        File::moveDirectory(base_path('tests/Support/public'), base_path('tests/Support/public_backup'));

        $this->artisan('airdrop:download');

        $this->assertEquals('/* app.css */', File::get(base_path('tests/Support/public/css/app.css')));

        $this->assertEquals('// app.js', File::get(base_path('tests/Support/public/js/app.js')));

        File::deleteDirectory(base_path('tests/Support/public_backup'));

        $this->assertFileExists(base_path('.airdrop_skip'));

        File::delete(base_path('.airdrop_skip'));
    }
}
