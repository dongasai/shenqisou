<?php

namespace App\Helper;

class Search
{
    /**
     * 搜索关键词
     *
     * @param $q
     * @return array
     */
    static public function query($model, $q)
    {
        return Cache::cacheCall([__CLASS__, __FILE__, $model, $q], function ($model, $search) {
            return $model::search($search)->paginate(9999, 'a', 1)->pluck('id');
        }, [$model, $q], 60);
    }

}
