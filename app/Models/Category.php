<?php

namespace App\Models;

use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ModelTree, AdminBuilder;

    protected $fillable = ['parent_id', 'order', 'name'];

    // /**
    //  * Create a new Eloquent model instance.
    //  *
    //  * @param array $attributes
    //  */
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
    //
    // /**
    //  * A Menu belongs to many roles.
    //  *
    //  * @return BelongsToMany
    //  */
    // public function roles() : BelongsToMany
    // {
    //     $pivotTable = config('admin.database.role_menu_table');
    //
    //     $relatedModel = config('admin.database.roles_model');
    //
    //     return $this->belongsToMany($relatedModel, $pivotTable, 'menu_id', 'role_id');
    // }
    //
    // /**
    //  * @return array
    //  */
    // public function allNodes() : array
    // {
    //     $orderColumn = DB::getQueryGrammar()->wrap($this->orderColumn);
    //     $byOrder = $orderColumn.' = 0,'.$orderColumn;
    //
    //     return static::with('roles')->orderByRaw($byOrder)->get()->toArray();
    // }

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
