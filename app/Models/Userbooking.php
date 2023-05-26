<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userbooking extends Model
{
    use HasFactory;
    protected $table="user_booking";
      protected $fillable = [
        'booking_id',
        'invoice_id',
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
        'payment_mode',
        'payment_status',
        'cancel_reason_id',
        'cancel_reason',
        'cancel_date'
    ];

   
}
