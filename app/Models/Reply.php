<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Favorites;

class Reply extends Model
{
    use Favorites;

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
}
