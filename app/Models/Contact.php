<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $appends = ['notifies_count'];

    protected $guarded = [];

    public function onwer()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function person()
    {
        return $this->belongsTo(\App\User::class, 'contact_user_id');
    }

    public function getNotifiesCountAttribute()
    {
        return count($this->onwer->notifications->where('read_at', null)->where('data.from_user_id', $this->contact_user_id));
    }
}
