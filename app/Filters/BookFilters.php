<?php

namespace App\Filters;

use App\User;

class BookFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['time', 'search', 'price', 'view'];

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

    /**
     * [time description]
     * @return [type] [description]
     */
    public function price($price)
    {
        return $this->builder->orderBy('money', $price);
    }

    /**
     * [time description]
     * @return [type] [description]
     */
    public function view($view)
    {
        return $this->builder->orderBy('views_count', $view);
    }
}
