<?php

/**
 * @author Aaron Francis <aaron@tryhardstudios.com>
 */

namespace WilberGroup\Airdrop\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use WilberGroup\Airdrop\HashGenerator;

class Debug extends Command
{
    protected $signature = 'airdrop:debug {--trigger=}';

    protected $description = 'Output the array of all triggers, or a specific trigger.';

    public function handle(): void
    {
        $output = HashGenerator::make()->asArray();

        if ($trigger = $this->option('trigger')) {
            $output = Arr::only($output, $trigger);
        }

        // Pretty print it to make diffing easier.
        $this->line(
            json_encode($output, JSON_PRETTY_PRINT)
        );
    }
}
