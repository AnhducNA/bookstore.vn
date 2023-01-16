<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function book()
    {
        return $this->belongsTo('App\Models\Book', 'product_id');
    }
}
