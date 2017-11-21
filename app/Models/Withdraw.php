<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bills;
use App\User;

class Withdraw extends Model
{
    use Bills;

    protected $guarded = [];

    protected static function boot()
    {
        static::bootTraits();

        static::created(function ($query) {
            $query->billed(array('change_type' => 'decrement', 'remark' => '提现'));
        });
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
     * 获取提现金额
     * @return [type] [description]
     */
    public function price()
    {
        return $this->money;
    }
}
