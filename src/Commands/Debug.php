<?php
/**
 * @author Aaron Francis <aaron@hammerstone.dev>
 */

namespace Hammerstone\Airdrop\Commands;

use Arr;
use Hammerstone\Airdrop\HashGenerator;
use Illuminate\Console\Command;

class Debug extends Command
{
    protected $signature = 'airdrop:debug {--trigger=}';

    protected $description = 'Output the array of all triggers, or a specific trigger.';

    public function handle()
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
