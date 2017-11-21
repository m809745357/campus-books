<?php

namespace App\Models\Traits;

use App\Models\PaymentRecord;

trait Payments
{
    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments()
    {
        return $this->morphMany(PaymentRecord::class, 'paymented');
    }

    /**
     * [bills description]
     * @return Models
     */
    public function paymented($data = null)
    {
        return $this->payments()->create(array_merge(['user_id' => auth()->id()], $data));
    }

}
