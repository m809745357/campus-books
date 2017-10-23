<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function path()
    {
        return "/books/{$this->category->slug}/$this->id";
    }

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function onwer()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public static function hot($num, $where){
        $hots = \App\Models\Book::with('onwer')->latest('views_count')->take($num);
        if ($where) {
            $hots->where($where);
        }
        return $hots->get();
    }

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
