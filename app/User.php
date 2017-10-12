<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Filters\FavoriteFilters;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'openid', 'email'
    ];

    /**
     * 用户有很多的收藏
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(Models\Favorite::class, 'user_id');
    }

    /**
     * 查询用户收藏
     *
     * @param  FavoriteFilters $filters 过滤
     * @return Model
     */
    public function favorited(FavoriteFilters $filters)
    {
        return $this->favorites()
            ->with('favorited', 'favorited.onwer')
            ->latest()
            ->filter($filters)
            ->get();
    }

    /**
     * 用户有很多的问答
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Models\Thread::class, 'user_id');
    }

    /**
     * 用户有很多的回答
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Models\Reply::class, 'user_id');
    }
}
