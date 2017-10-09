<?php

namespace App\Models\Traits;

use App\Models\Favorite;

trait Favorites
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorited()
    {
        if (! $this->isFavorited()) {
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
        return $this->favorites();
    }

    public function isFavorited()
    {
        return $this->favorites()->where(['user_id' => auth()->id()])->exists();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->favorites()->where(['user_id' => auth()->id()])->exists();
    }
}
