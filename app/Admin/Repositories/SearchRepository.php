<?php

namespace App\Admin\Repositories;

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

//        dump($search,$this->eloquentClass);
        if($search){
            $ids = $this->eloquentClass::search($search)->paginate(9999,'a',1)->pluck('id');
//            dd($ids);
            if(!$ids){
                $ids = [-1];
            }
            $query = $this->newQuery()->whereIn('id',$ids);

        }else{
            $query = $this->newQuery();

        }
        if ($this->relations) {
            $query->with($this->relations);
        }




        return $model->apply($query, true, $this->getGridColumns());

    }

}
