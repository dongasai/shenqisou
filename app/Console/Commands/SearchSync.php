<?php

namespace App\Console\Commands;

use App\Models\Bt;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SearchSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '搜索引擎同步';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $time = Carbon::now()->addMinutes(-70);
//        dump($time);
        Bt::query()->where('time','>',$time)->searchable();

        return Command::SUCCESS;
    }
}
