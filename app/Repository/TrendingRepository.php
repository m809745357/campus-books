<?php

namespace App\Repository;

class TrendingRepository implements Repository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function trending($num, $where = null)
    {
        return $value = \Cache::remember(get_class($this->model), 60 * 60, function () use ($num, $where) {
            return $this->model->trending($num, $where);
        });
    }
}
