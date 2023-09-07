<?php

namespace App\Helper;


use Illuminate\Support\Facades\Log;

class Cache
{

    /**
     * 回调函数的缓存
     *
     * @param $key
     * @param callable $callable
     * @param $param_arr
     * @param $exp
     * @return mixed
     */
    static public function cacheCall($key, callable $callable, $param_arr, $exp = 60)
    {
        $key = md5(serialize($key));
        $old = \Illuminate\Support\Facades\Cache::get($key);
        if (!is_null($old)) {
            return $old;
        }
        $new = call_user_func_array($callable, $param_arr);
        \Illuminate\Support\Facades\Cache::put($key, $new, $exp);

        return $new;
    }


}
