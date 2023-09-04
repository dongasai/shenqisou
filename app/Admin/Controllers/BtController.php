<?php

namespace App\Admin\Controllers;





use App\Admin\Repositories\Bt;


use App\Admin\Repositories\BtSearch;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;

use function Clue\StreamFilter\fun;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
class BtController extends AdminController
{
    public function grid()
    {


        return Grid::make(new BtSearch(), function (Grid $grid) {

            $search = $grid->getRequestInput('search');


            if($search){
//                $grid->model();
               $grid->model()->search($search);
            }
            $grid->column('id');

            $grid->column('name');

            $grid->filter(function (Grid\Filter $filter){

                $filter->panel();
                $filter->expand();
                $filter->where('search',function (Builder $q){
//                    dump(func_get_args());

                });
            });

        });

    }
}
