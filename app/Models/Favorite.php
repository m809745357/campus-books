<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\FavoriteFilters;

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

    /**
     * Apply all relevant thread filters.
     *
     * @param  Builder       $query
     * @param  FavoriteFilters $filters
     * @return Builder
     */
    public function scopeFilter(Builder $query, FavoriteFilters $filters)
    {
        return $filters->apply($query);
    }
}
