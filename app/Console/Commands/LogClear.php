<?php

namespace App\Console\Commands;

use App\Models\Bt;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LogClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear {day : 天数}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清理日志';



    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $day = $this->argument('day');
        $timeString  = Carbon::now()->addDays(-$day)->format(Carbon::DEFAULT_TO_STRING_FORMAT);

        $delete = DB::delete("DELETE FROM hash_log WHERE `hash_log`.`time_at` < '$timeString' ");

        $this->info("delete $delete .");

        return Command::SUCCESS;
    }
}
