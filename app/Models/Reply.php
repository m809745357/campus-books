<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Favorites;
use App\Models\Traits\Bills;

class Reply extends Model
{
    use Favorites, Bills;

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

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
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
     * 打赏
     *
     * @return [type] [description]
     */
    public function best()
    {
        $this->billed(array('change_type' => 'decrement', 'remark' => '打赏'));
        $this->bills()->create([
            'user_id' => $this->user_id,
            'change_type' => 'increment',
            'remark' => '打赏'
        ]);

        $this->thread->update(['best_reply_id' => $this->id]);

        return $this;
    }

    /**
     * 获取打赏金额
     *
     * @return [type] [description]
     */
    public function money()
    {
        return $this->thread->money;
    }

    /**
     * [bills description]
     * @return Models
     */
    public function getIsFavoritedAttribute()
    {
        return $this->favorites->count();
    }
}
