<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBookingRatings extends Model
{
    use HasFactory;
    protected $table="user_booking_ratings";
      protected $fillable = [
        'user_id',
        'booking_id',
        'property_id',
        'rating',
        'status',
    ];

   
}
