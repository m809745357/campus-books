<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bills;

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
     * 获取提现金额
     * @return [type] [description]
     */
    public function money()
    {
        return $this->money;
    }
}
