<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function orderDetail()
    {
        return $this->hasOne('App\Models\OrderDetail');
    }

    public function shipping()
    {
        return $this->belongsTo('App\Models\ShippingAddress', 'shipping_id');
    }
}
