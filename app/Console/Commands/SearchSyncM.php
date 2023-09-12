<?php

namespace App\Console\Commands;

use App\Models\Bt;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SearchSyncM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:syncm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '搜索引擎同步(分钟)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $time = Carbon::now()->subSeconds(70);
//        dump($time);
        Bt::query()->where('lasttime','>',$time)->searchable();

        return Command::SUCCESS;
    }
}
