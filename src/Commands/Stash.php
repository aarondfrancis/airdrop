<?php

namespace Hammerstone\Airdrop\Commands;

class Stash extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'airdrop:stash';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run as a part of deploying after assets are built.';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $this->makeDriver()->stash();
    }
}
