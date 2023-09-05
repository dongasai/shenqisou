<?php

namespace App\Admin\Repositories;

use App\Models\Bt as Model;

class BtSearch extends SearchRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;



}
