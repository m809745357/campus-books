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
    public function billed()
    {
        return $this->bills()->create(['user_id' => auth()->id()]);
    }
}
