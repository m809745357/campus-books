<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Filters\FavoriteFilters;
use App\Notifications\UserChatNotifications;
use Carbon\Carbon;
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

    /**
     * 用户订单
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Models\Order::class, 'user_id');
    }

    /**
     * 用户提现
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function withdraws()
    {
        return $this->hasMany(Models\Withdraw::class, 'user_id');
    }

    /**
     * 用户提现
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sms()
    {
        return $this->hasMany(Models\Sms::class, 'user_id');
    }

    /**
     * 添加通讯录
     *
     * @param [type] $user [description]
     */
    public function addContacts($user)
    {
        if (! $this->isContacted($user)) {
            return $this->contacts()->create(['contact_user_id' => $user->id]);
        }
        return $this->contacts();
    }

    /**
     * 判断通讯录中是否有这个人
     *
     * @param  [type]  $user [description]
     * @return boolean       [description]
     */
    public function isContacted($user)
    {
        return $this->contacts()->where(['contact_user_id' => $user->id])->exists();
    }

    /**
     * 查找所有的通讯录的人
     *
     * @return [type] [description]
     */
    public function chats()
    {
        return $this->contacts;
    }

    /**
     * 打招呼
     *
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function sayHello($user)
    {
        if (! auth()->user()->messaged()->where(['to_user_id' => $user->id])->exists()) {
            auth()->user()->messaged()->create([
                'to_user_id' => $user->id,
                'message' => '你好！我想了解一下具体情况'
            ]);
        }
    }

    /**
     * 获取我的信息
     *
     * @return [type] [description]
     */
    public function contact()
    {
        return $this->contacts->load(['person.messaged', 'onwer.notifications'])
        ->sortBy('created_at')->map(function ($contact) {
            return array(
                'id' => $contact->person->id,
                'nickname' => $contact->person->nickname,
                'avatar' => $contact->person->avatar,
                'message' => $contact->message,
                'created_at' => \Carbon\Carbon::parse($contact->created_at)->diffForHumans(),
                'count' => $contact->notifies_count
            );
        });
    }

    /**
     * 添加用户地址
     *
     * @return [type] [description]
     */
    public function address()
    {
        return $this->hasMany(Models\Address::class, 'user_id');;
    }

    /**
     * 查询通知记录个数
     *
     * @return [type] [description]
     */
    public function getNotificationCountAttribute()
    {
        return $this->unreadNotifications()->count();
    }

    /**
     * 标记已读
     *
     * @return [type] [description]
     */
    public function markAsRead()
    {
        return $this->unreadNotifications->markAsRead();
    }

    /**
     * 标记已读
     *
     * @return [type] [description]
     */
    public function markSmsAsRead()
    {
        return $this->sms->each->markAsRead();
    }

    /**
     * 添加用户订单
     *
     * @param [type] $order [description]
     */
    public function addOrder($order)
    {
        return $this->orders()->create(array_merge($order, [
            'remark' => request()->remark,
            'order_number' => config('wechat.app_id') . date('YmdHis') . rand(1000, 9999)
        ]));
    }

    /**
     * 新增求购
     *
     * @param [type] $demand [description]
     */
    public function addDemand($demand)
    {
        return $this->demands()->create($demand);
    }

    /**
     * 新增短信
     *
     * @param [type] $demand [description]
     */
    public function addSms($sms)
    {
        return $this->sms()->create($sms);
    }

    /**
     * 新增消息
     *
     * @param [type] $message [description]
     */
    public function addMessage($message)
    {
        return $this->messages()->create([
            'from_user_id' => $this->id,
            'message' => $message
        ]);
    }

    public function addAddress($address)
    {
        return $this->address()->create($address);
    }

    /**
     * 设置头像
     *
     * @param [type] $avatar [description]
     */
    public function setAvatarAttribute($avatar)
    {
        return $this->attributes['avatar'] = strpos($avatar, 'http') !== false ? $avatar : \Storage::url($avatar);
    }

    /**
     * 判断手机号码是否为当前用户的
     *
     * @return [type] [description]
     */
    public function validateMobile()
    {
        return $this->mobile === request()->mobile && $this->validateCode();
    }

    /**
     * 判断验证码是否相同
     *
     * @return [type] [description]
     */
    public function validateCode()
    {
        if (app()->environment('testing')) {
            return true;
        }

        $sms = $this->sms()->where(['mobile' => request()->mobile])->whereNull('read_at')->orderBy('created_at', 'desc')->first();

        if (! $sms) {
            return false;
        }

        $now = Carbon::now('Asia/Shanghai');

        $codeTime = Carbon::parse($sms->created_at, 'Asia/Shanghai')->addSeconds(30 * 60);

        if ($now->gt($codeTime)) {
            return false;
        }
        if (request()->code != $sms->code) {
            return false;
        }

        return true;
    }

    /**
     * 添加提现记录
     *
     * @param Array $widthdraw
     */
    public function addWithdraw($widthdraw)
    {
        if (! $this->ifHasEnoughBalances()) {
            return false;
        }

        $this->decrement('balances', request()->money);

        return $this->withdraws()->create($widthdraw);
    }

    /**
     * 判断是否有足够的金额提现
     *
     * @return boolean
     */
    public function ifHasEnoughBalances()
    {
        return $this->balances > request()->money;
    }
}
