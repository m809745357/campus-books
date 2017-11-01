<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Filters\FavoriteFilters;
use App\Notifications\UserChatNotifications;
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
     * @return Model
     */
    public function favorited($type)
    {
        if ($type == 'App\\Models\\Thread') {
            return $this->favorites()
                ->with('favorited', 'favorited.onwer', 'favorited.channel')
                ->where('favorited_type', $type)
                ->latest()
                ->get();
        }
        if ($type == 'App\\Models\\Book') {
            return $this->favorites()
                ->with('favorited', 'favorited.onwer', 'favorited.category')
                ->where('favorited_type', $type)
                ->latest()
                ->get();
        }
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

    /**
     * 用户有很多的求购
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demands()
    {
        return $this->hasMany(Models\Demand::class, 'user_id');
    }

    /**
     * 用户的账户明细
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bills()
    {
        return $this->hasMany(Models\Bill::class, 'user_id');
    }

    /**
     * 用户的发布
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function books()
    {
        return $this->HasMany(Models\Book::class, 'user_id');
    }

    public function messaged()
    {
        return $this->hasMany(Models\Message::class, 'from_user_id');
    }

    public function messages()
    {
        return $this->hasMany(Models\Message::class, 'to_user_id');
    }

    /**
     * 用户的联系人
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Models\Contact::class, 'user_id');
    }

    public function addContacts($user)
    {
        if (! $this->isContacted($user)) {
            return $this->contacts()->create(['contact_user_id' => $user->id]);
        }
        return $this->contacts();
    }

    public function isContacted($user)
    {
        return $this->contacts()->where(['contact_user_id' => $user->id])->exists();
    }

    public function chats()
    {
        return $this->contacts;
    }

    public function sayHello($user)
    {
        if (! auth()->user()->messaged()->where(['to_user_id' => $user->id])->exists()) {
            auth()->user()->messaged()->create([
                'to_user_id' => $user->id,
                'message' => '你好！我想了解一下具体情况'
            ]);
        }
    }
}
