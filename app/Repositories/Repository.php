<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected $model;

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return Model
     */
    abstract protected function getModelClass();

    public function start()
    {
        return clone $this->model;
    }
}
