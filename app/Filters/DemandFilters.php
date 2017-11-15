<?php

namespace App\Filters;

use App\User;

class DemandFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['time', 'search'];

    /**
     * 全文搜索
     *
     * @param  [type] $search [description]
     * @return [type]         [description]
     */
    public function search($search)
    {
        return $this->builder->orWhere('title', 'like', "%$search%")->orWhere('body', 'like', "%$search%");
    }

    /**
     * [time description]
     * @return [type] [description]
     */
    public function time($time)
    {
        return $this->builder->orderBy('created_at', $time);
    }
}
