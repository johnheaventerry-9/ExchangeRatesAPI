<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command for scheduler';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dd('TestCommand is running');
        Log::info('TestCommand executed.');
        return Command::SUCCESS;
    }
    
}
