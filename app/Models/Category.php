<?php

namespace App\Models;

use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ModelTree, AdminBuilder;

    // protected $fillable = ['parent_id', 'order', 'name'];
    protected $guarded = [];

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
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        // $connection = config('admin.database.connection') ?: config('database.default');
        // $this->setConnection($connection);
        // $this->setTable(config('admin.database.menu_table'));

        parent::__construct($attributes);
        $this->setParentColumn('parent_id');
        $this->setOrderColumn('order');
        $this->setTitleColumn('name');
    }

    /**
     * 获取子分类
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childCategories()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->select('id', 'name', 'parent_id');
    }

    /**
     * 获取子分类
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}
