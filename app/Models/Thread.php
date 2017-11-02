<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\Favorites;
use App\Repository\Repository;

class Thread extends Model implements Repository
{
    use Favorites;

    protected $guarded = [];

    protected $appends = ['is_reward'];//, 'is_favorited'

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function onwer()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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

    public function trending($num, $where)
    {
        return $this->with('onwer', 'channel')->latest('replies_count')->take($num)->get();
    }
}
