<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Builder;


class Thread extends Model
{
    protected $guarded = [];

    protected $appends = ['isReward'];

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
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

    /**
     * Apply all relevant thread filters.
     *
     * @param  Builder       $query
     * @param  ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter(Builder $query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }
}
