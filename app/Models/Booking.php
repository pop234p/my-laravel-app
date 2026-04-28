<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'car_id',
        'start_date',
        'end_date',
        'insurance',
        'total_price'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}