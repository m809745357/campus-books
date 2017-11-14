<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['by', 'type'];

    /**
     * Filter the query by a given username.
     *
     * @param  integer $user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function by($user_id)
    {
        return $this->builder->where(['user_id' => $user_id]);
    }

    /**
     * 过滤type参数
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    protected function type($type)
    {
        if (method_exists($this, $type)) {
            return $this->$type();
        }
        return $this->builder;
    }

    /**
     * 查询悬赏
     * @return [type] [description]
     */
    protected function reward()
    {
        return $this->builder->where('money', '>', 0);
    }

    /**
     * 查询普通
     *
     * @return [type] [description]
     */
    protected function ordinary()
    {
        return $this->builder->where('money', '=', 0);
    }
}
