<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run composer dump-autoload and clear all Laravel caches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info('Running composer dump-autoload...');
        exec('composer dump-autoload');

        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('optimize:clear');

        $this->info('Framework refreshed successfully.');
    }
}
