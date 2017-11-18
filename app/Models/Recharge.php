<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bills;

class Recharge extends Model
{
    use Bills;

    /**
     * 获取价格
     *
     * @return [type] [description]
     */
    public function price()
    {
        return $this->money;
    }
}
