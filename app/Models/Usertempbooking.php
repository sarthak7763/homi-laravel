<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usertempbooking extends Model
{
    use HasFactory;
    protected $table="user_temp_booking";
      protected $fillable = [
        'user_id',
        'property_id',
        'user_name',
        'user_email',
        'user_age',
        'user_gender',
        'user_number',
        'user_checkin_date',
        'user_checkout_date',
        'booking_property_price',
        'booking_tax_price',
        'booking_price',
        'user_adult_count',
        'user_children_count',
        'booking_status',
    ];

   
}
