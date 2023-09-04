<?php

namespace App\Models;

use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\EloquentRepository;

class SearchRepository extends EloquentRepository
{

    public function get(Grid\Model $model)
    {

        $this->setSort($model);
        $this->setPaginate($model);

        $query = $this->newQuery();

        if ($this->relations) {
            $query->with($this->relations);
        }
//       ;
        foreach ($model->getQueries() as $index => $query1){

            if($query1['method'] =='search'){
                $query->getModel()->search($query1['arguments'][0]);
            }
//            $model->getQueries();
            unset($model->getQueries()[$index]);

        }

        return $model->apply($query, true, $this->getGridColumns());

    }

}
