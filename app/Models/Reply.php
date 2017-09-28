<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    protected $appends = ['is_favorited'];

    public function path()
    {
        return '/replies/' . $this->id;
    }

    protected static function boot()
    {
        static::bootTraits();

        static::creating(function ($query) {
            $query->thread->increment('replies_count');
        });

        static::deleting(function ($query) {
            $query->thread->decrement('replies_count');
        });
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function onwer()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

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
