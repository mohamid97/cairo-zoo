<?php

namespace App\Console\Commands;

use App\Models\Admin\Log;
use Illuminate\Console\Command;
use Carbon\Carbon;
class DeleteOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete logs older than 1 month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $deleted = Log::where('created_at', '<', Carbon::now()->subMonth())->delete();

        $this->info("Deleted $deleted old log records.");
    }
}
