<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntrestedCity extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'city_id',
        'status',
        'delete_status'
    ];

    public function getIntrestedCity()
    {
        return $this->hasOne('App\Models\City','id','city_id');
    }

  
   
}

