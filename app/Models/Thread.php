<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\Favorites;
use App\Filters\ThreadFilters;
use App\Repository\Repository;
use Laravel\Scout\Searchable;

class Thread extends Model implements Repository
{
    use Favorites; //, Searchable

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'body' => $this->body
        ];
    }

    protected $mappingProperties = array(
       'title' => array(
            'type' => 'string',
            'analyzer' => 'ik_max_word'
        ),
       'body' => array(
            'type' => 'string',
            'analyzer' => 'ik_max_word'
        )
    );

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

    /**
     * 添加回复
     *
     * @param [type] $reply [description]
     */
    public function addReply($reply)
    {
        return $this->replies()->create([
            'user_id' => auth()->id(),
            'favorites_count' => 0,
            'body' => $reply
        ]);
    }

    /**
     * 获取是否悬赏
     *
     * @return [type] [description]
     */
    public function getIsRewardAttribute()
    {
        return $this->money !== 0;
    }

    /**
     * 获取是否喜欢
     *
     * @return Models
     */
    public function getIsFavoritedAttribute()
    {
        return $this->favorites->count();
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

    /**
     * 热门提问
     *
     * @param  [type] $num   [description]
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    public function trending($num, $where)
    {
        return $this->with('onwer', 'channel')->latest('replies_count')->take($num)->get();
    }

    /**
     * 提问详情
     *
     * @return [type] [description]
     */
    public function detail()
    {
        return $this->load([
            'onwer',
            'replies.favorites' => function ($query) {
                return $query->where(['user_id' => auth()->id()]);
            },
            'replies.onwer',
            'favorites' => function ($query) {
                return $query->where(['user_id' => auth()->id()]);
            }
        ])->append('is_favorited');
    }

    /**
     * 获取金额
     *
     * @return [type] [description]
     */
    public function price()
    {
        return $this->money;
    }

    /**
     * 判断是否有金额支付悬赏
     *
     * @return [type] [description]
     */
    public function ifHasEnoughMoney()
    {
        return $this->onwer->balances > $this->price();
    }
}
