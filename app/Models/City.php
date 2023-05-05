<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
      protected $fillable = [
        'name',
        'state_id',
        'status',
        'delete_status'
    ];

    public function getState()
    {
        return $this->hasOne('App\Models\State','id','state_id')->with('getCountry');
    }


      public function getPropertyByCity(){
        return $this->hasMany('App\Models\Property','city','id');
    }

   
}
