<?php

namespace App\Models\Traits;

use App\Models\Bill;

trait Bills
{
    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bills()
    {
        return $this->morphMany(Bill::class, 'billed');
    }

    /**
     * [bills description]
     * @return Models
     */
    public function billed($data = null)
    {
        return $this->bills()->create(array_merge(['user_id' => auth()->id()], $data));
    }

}
