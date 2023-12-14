<?php

namespace App\Admin\Repositories;

use App\Helper\Search;
use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\EloquentRepository;

class SearchRepository extends EloquentRepository
{




    public function get(Grid\Model $model)
    {

        $this->setSort($model);
        $this->setPaginate($model);
        // 获取筛选参数
        $search = $model->filter()->input('search', '');
        /**
         * > 3712474
         * 1 => 1880046
         * 2 => 1997554
         * 3 => 2481351
         * 4 => 2310427
         * 5 => 3421267
         * 6 => 435672
         * 7 => 1947258
         * 8 => 2843356
         * 9 => 2833853
         * 10 => 3375574
         * 11 => 947040
         * 12 => 1223421
         * 13 => 1676783
         * 14 => 3247731
         * 15 => 3353140
         * 16 => 2700512
         * 17 => 2797618
         * 18 => 993035
         * 19 => 3358369
         * 20 => 967763
         * 21 => 3455610
         * 22 => 649859
         * 23 => 894675
         * 24 => 1952943
         * 25 => 2658116
         * 26 => 3194591
         */
//        dump($search,$this->eloquentClass);
        if($search){
            //            dd($ids);
            $ids= Search::queryIndex2Id($this->eloquentClass,$search);
            if(!$ids){
                $ids = [-1];
            }
            $query = $this->newQuery()->whereIn('id',$ids);
            $_sort = request('_sort');
            if (!$_sort){
//                dump("没有排序");
                $idsString = implode(',',$ids);
                $query->orderByRaw("FIELD( id, $idsString )");
            }
        }else{
            $query = $this->newQuery();

        }
        if ($this->relations) {
            $query->with($this->relations);
        }




        return $model->apply($query, true, $this->getGridColumns());

    }

}
