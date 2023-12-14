<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use DcatAdmin\Echart\Lazy\EchatLine;

class DevController extends Controller
{
    public function config(Content $content)
    {
        return $content
            ->header('Dashboard')
            ->description('Description...')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
//                    $column->row(Dashboard::title());
                    $column->row(view('admin/dump',['dump_var'=>config()]));
                });
                $row->column(6, function (Column $column) {
//                    $column->row(Dashboard::title());
                    $column->row(view('admin/dump',['dump_var'=>date('Y-m-d H:i:s',config('build.time'))]));
                });
            });
    }
}
