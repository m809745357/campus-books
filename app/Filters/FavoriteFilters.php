<?php

namespace App\Filters;

use App\User;

class FavoriteFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['type'];

    /**
     * Filter the query by a given username.
     *
     * @param  string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type($type)
    {
        if (method_exists($this, $type)) {
            return $this->$type();
        }
        return $this->builder;
    }

    protected function thread()
    {
        return $this->builder->where('favorited_type', '=', 'App\\Models\\Thread')->with('favorited.channel');
    }
}
