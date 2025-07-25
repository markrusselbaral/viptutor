<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Log;

class DeleteOldTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete tasks older than 30 days and log the deletions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleted = Task::where('created_at', '<', now()->subDays(30))->delete();

        Log::info("Deleted {$deleted} tasks older than 30 days.");

        $this->info("Deleted {$deleted} tasks older than 30 days.");
    }
}
