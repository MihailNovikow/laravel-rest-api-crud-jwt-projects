<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanUpTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:delete {date_lte}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Tasks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date_lte = $this->argument('date_lte') ? $this->argument('date_lte') : date('Y-m-d', strtotime("-30 day"));

        $list = DB::table('tasks')->where('status', 'backlog')->whereDate('created_at','<', $date_lte /*now()->sub(1,'day')*/)->get();

        if ($list === null) {
            $this->error("Invalid or non-existent List.");
            return 1;
        }

        if ($this->confirm("Confirm deleting the list '$list->title'? Tasks will be reassigned to the default list.")) {
            $default_list = Task::firstWhere('slug', 'default');
            if (!$default_list) {
                $default_list = new Task();
                $default_list->title = 'default';
                $default_list->slug = 'default';
                $default_list->save();
            }

            $this->info("Reassigning Tasks to default list...");

            Task::where('Task_list_id', $list->id)->update(['Task_list_id' => $default_list->id]);

            $list->delete();
            $this->info("List Deleted.");


        }

        return 0;
    }
}
