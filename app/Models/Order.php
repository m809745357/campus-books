<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/orders/' . $this->id;
    }

    public function setBookAttribute($book)
    {
        return $this->attributes['book'] = serialize(Book::find($book));
    }

    public function getBookAttribute($book)
    {
        return unserialize($book);
    }

    public function setAddressAttribute($address)
    {
        return $this->attributes['address'] = serialize(Address::find($address));
    }

    public function getAddressAttribute($address)
    {
        return unserialize($address);
    }
}
