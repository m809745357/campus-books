<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $appends = ['notifies_count'];

    protected $guarded = [];

    /**
     * 所属者
     *
     * @return [type] [description]
     */
    public function onwer()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    /**
     * 联系人
     *
     * @return [type] [description]
     */
    public function person()
    {
        return $this->belongsTo(\App\User::class, 'contact_user_id');
    }

    /**
     * 获取用户有多少的消息
     *
     * @return [type] [description]
     */
    public function getNotifiesCountAttribute()
    {
        return count($this->onwer->notifications->where('read_at', null)->where('data.from_user_id', $this->contact_user_id));
    }
}
