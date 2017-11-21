<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    protected $guarded = [];

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function paymented()
    {
        return $this->morphTo();
    }
}
