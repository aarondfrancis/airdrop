<?php

/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace Hammerstone\Airdrop\Commands;

use Hammerstone\Airdrop\HashGenerator;
use Illuminate\Console\Command;

class Hash extends Command
{
    protected $signature = 'airdrop:hash {--prefix=} {--putenv=}';

    protected $description = 'Output the calculated hash.';

    public function handle()
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
