<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantClosure extends Model
{
    protected $fillable = ['restaurant_id', 'closed_date', 'reason'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
