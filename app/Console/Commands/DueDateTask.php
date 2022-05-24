<?php

namespace App\Console\Commands;

use App\Enums\TaskStatus;
use App\Enums\TimeZone;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DueDateTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:due-date-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Due Date Task';

    public function handle(): void
    {
        Task::where('status', TaskStatus::PENDING)
            ->where('due_date', '<', Carbon::now(TimeZone::VIE))
            ->update(['status' => TaskStatus::IN_COMPLETE]);
    }
}
