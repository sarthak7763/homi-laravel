<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userlocationsearch extends Model
{
    use HasFactory;
    protected $table="user_location_search";
      protected $fillable = [
        'user_id',
        'user_location',
        'user_latitude',
        'user_longitude',
        'status',
    ];

   
}
