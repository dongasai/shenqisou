<?php

namespace App\Admin\Repositories;

use App\Models\Bt as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Bt extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;


    public function search(){
        dd(func_get_args());
    }
}
