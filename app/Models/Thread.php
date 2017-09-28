<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $appends = ['isReward'];

    public function path()
    {
        return '/threads/' . $this->id;
    }

    public function onwer()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'thread_id');
    }

    public function addReply($reply)
    {
        return $this->replies()->create([
            'user_id' => auth()->id(),
            'favorites_count' => 0,
            'body' => $reply
        ]);
    }

    public function getIsRewardAttribute()
    {
        return $this->money !== 0;
    }
}
