<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        static::bootTraits();

        static::creating(function ($query) {
            $query->thread->increment('replies_count');
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
