<?php

namespace App\Models\Traits;

use App\Models\Favorite;

trait Favorites
{
    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * [bills description]
     * @return Models
     */
    public function favorited()
    {
        if (! $this->isFavorited()) {
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
        return $this->favorites();
    }

    /**
     * [bills description]
     * @return boolean
     */
    public function isFavorited()
    {
        return $this->favorites()->where(['user_id' => auth()->id()])->exists();
    }

    /**
     * [bills description]
     * @return Models
     */
    public function getIsFavoritedAttribute()
    {
        return $this->favorites()->where(['user_id' => auth()->id()])->exists();
    }
}
