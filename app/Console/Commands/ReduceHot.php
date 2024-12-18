<?php

namespace App\Console\Commands;

use App\Models\Bt;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Log\Logger;

/**
 * 降低热度
 * php artisan  btcall:reduce_hot
 */
class ReduceHot extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'btcall:reduce_hot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '降低热度';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $level = [
            [
                'max' => '100',
                'dec' => '1',
            ],
            [
                'max' => '500',
                'dec' => '7',
            ],
            [
                'max' => '1000',
                'dec' => '20',
            ],
            [
                'max' => '5000',
                'dec' => '70',
            ],
            [
                'max' => '10000',
                'dec' => '200',
            ],

        ];

        foreach ($level as $k => $item) {
            if ($level[$k + 1] ?? []) {
                $re = Bt::query()->whereBetween('hot', [
                    $item['max'], $level[$k + 1]['max']
                ])->decrement('hot', $item['dec']);
//                Logger::info("");

            } else {
                $re = Bt::query()->where('hot', '>', $item['max'])
                    ->decrement('hot', $item['dec']);

            }


        }


        return Command::SUCCESS;
    }

}
