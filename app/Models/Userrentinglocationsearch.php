<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userrentinglocationsearch extends Model
{
    use HasFactory;
    protected $table="user_renting_location_search";
      protected $fillable = [
        'user_id',
        'user_category',
        'user_location',
        'user_latitude',
        'user_longitude',
        'user_checkin_date',
        'user_checkout_date',
        'user_adults_count',
        'user_children_count',
        'status',
    ];

   
}
