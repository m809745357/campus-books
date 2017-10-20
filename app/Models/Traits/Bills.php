<?php

namespace App\Models\Traits;

use App\Models\Bill;

trait Bills
{
    public function bills()
    {
        return $this->morphMany(Bill::class, 'billed');
    }

    public function billed()
    {
        return $this->bills()->create(['user_id' => auth()->id()]);
    }
}
