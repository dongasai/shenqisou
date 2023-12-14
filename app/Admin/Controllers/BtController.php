<?php

namespace App\Admin\Controllers;





use App\Admin\Actions\bt\Open;
use App\Admin\Actions\Grid\EditTag;
use App\Admin\Repositories\Bt;


use App\Admin\Repositories\BtSearch;
use App\Helper\File;
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
//            $grid-
            $grid->model()->with(['tag']);
            $grid->column('id');

            $grid->column('name')->width(400);
            $grid->column('tag.tags')->label()->width(200);

            $grid->column('infohash')
                ->style('display: block;overflow: hidden;text-overflow: ellipsis;width: 150px;')
                ->width(150)->copyable();
            $grid->column('length')->display(function ($filesize){
                return File::sizecount($filesize);
            })->sortable();
            $grid->column('hot')->sortable();
//            $grid->column('keywords');
            $grid->column('hits');

            $grid->filter(function (Grid\Filter $filter){

                $filter->panel();
                $filter->expand();
                $filter->equal('id');
                $filter->where('length',function (Builder $q){
                    $min = $this->input * 1024*1024;
                    $max = ($this->input + 1) * 1024*1024;
//                    dd(func_get_args(),$min);
                        return  $q->whereBetween('length',[$min,$max]);
                },'大小MB');

                $filter->where('length2',function (Builder $q){
                    $min = ($this->input-0.1) * 1024*1024*1024;
                    $max = ($this->input + 0.1) * 1024*1024*1024;
//                    dd(func_get_args(),$min);
                    return  $q->whereBetween('length',[$min,$max]);
                },'大小GB');

                $filter->where('search',function (Builder $q){
//                    dump(func_get_args());
                });
            });
            $grid->actions(function (Grid\Displayers\Actions $actions){
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
                $actions->append(new EditTag());
                $actions->append(new Open());

            });

        });

    }
}
