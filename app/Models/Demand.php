<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/demands/' . $this->id;
    }

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function onwer()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function trending($num){
        return $this->with('onwer')->latest('views_count')->take($num)->get();
    }

    public function setImagesAttribute($images)
    {
        return $this->attributes['images'] = json_encode($images);
    }

    public function getImagesAttribute($images)
    {
        return array_map(function ($item) {
            return strpos($item, 'http') !== false ? $item : \Storage::url($item);
        }, json_decode($images, true));
    }
}
