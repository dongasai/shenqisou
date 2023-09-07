<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $name
 *
 *
 * php artisan scout:import "App\Models\Bt"
 *
 */
class Bt extends Model
{
    use HasFactory;

    protected $table = 'bt';
    use \Laravel\Scout\Searchable;


    public function tag()
    {
        return $this->hasOne(BtTags::class,'bid','id');
    }

    /**
     * 获取与模型关联的索引的名称。
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'ttt_index';
    }


    /**
     * 获取模型的可索引的数据。
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // 自定义数据数组...

        return [
            'name' => $this->name,
            'id'   => $this->id
        ];
    }


    /**
     * 获取用于索引模型的值
     *
     * @return mixed
     */
    public function getScoutKey()
    {
        return $this->id;
    }

    /**
     * 获取用于索引模型的键名
     *
     * @return mixed
     */
    public function getScoutKeyName()
    {
        return 'id';
    }

    /**
     * 确定模型是否可搜索
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        return true;
    }


}
