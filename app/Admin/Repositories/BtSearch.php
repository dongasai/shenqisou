<?php

namespace App\Admin\Repositories;

use App\Models\Bt as Model;
use App\Models\SearchRepository;
use Dcat\Admin\Repositories\EloquentRepository;

class BtSearch extends SearchRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;



}
