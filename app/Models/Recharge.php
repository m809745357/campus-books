<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bills;
use App\Models\Traits\Payments;

class Recharge extends Model
{
    use Bills, Payments;

    /**
     * 获取价格
     *
     * @return [type] [description]
     */
    public function price()
    {
        return $this->money;
    }

    /**
     * 添加记录
     * @param [type] $data [description]
     */
    public function addPaymentRecord($data)
    {
        return $this->paymented($data);
    }
}
