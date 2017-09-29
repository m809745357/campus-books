<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
    * Get the route key name for Laravel.
    *
    * @return string
    */
    public function getRouteKeyName()
    {
       return 'slug';
    }
}
