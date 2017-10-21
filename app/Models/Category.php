<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
    * Get the route key name for Laravel.
    *
    * @return string
    */
    public function getRouteKeyName()
    {
       return 'slug';
    }

    public function childCategories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
