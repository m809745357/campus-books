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

    public function favorites()
    {
        return $this->hasMany(Models\Favorite::class, 'user_id');
    }

    public function favorited(FavoriteFilters $filters)
    {
        return $this->favorites()
            ->with('favorited', 'favorited.onwer', 'favorited.channel')
            ->latest()
            ->filter($filters)
            ->get();
    }
}
