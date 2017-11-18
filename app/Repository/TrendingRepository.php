<?php

namespace App\Repository;

class TrendingRepository implements Repository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * 热门
     *
     * @param  [type] $num   [description]
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    public function trending($num, $where = null)
    {
        return $value = \Cache::remember($this->model->getTable() . '.treading', 60 * 60, function () use ($num, $where) {
            return $this->model->trending($num, $where);
        });
    }
}
