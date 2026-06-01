<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com>
 */

namespace WilberGroup\Airdrop\Commands;

use Illuminate\Console\Command;
use WilberGroup\Airdrop\HashGenerator;

class Hash extends Command
{
    protected $signature = 'airdrop:hash {--prefix=} {--putenv=}';

    protected $description = 'Output the calculated hash.';

    public function handle(): void
    {
        $hash = HashGenerator::make()->generate();

        if ($prefix = $this->option('prefix')) {
            $hash = "{$prefix}{$hash}";
        }

        $this->line($hash);

        if ($env = $this->option('putenv')) {
            putenv("$env=$hash");
        }
    }
}
