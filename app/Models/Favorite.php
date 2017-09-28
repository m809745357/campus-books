<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::bootTraits();

        static::creating(function ($query) {
            $query->favorited->increment('favorites_count');
        });

        static::deleting(function ($query) {
            $query->favorited->decrement('favorites_count');
        });
    }

    public function favorited()
    {
        return $this->morphTo();
    }
}
