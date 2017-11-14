<?php

namespace App\Models;

use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ModelTree, AdminBuilder;
    /**
    * Get the route key name for Laravel.
    *
    * @return string
    */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * 获取子分类
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childCategories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
