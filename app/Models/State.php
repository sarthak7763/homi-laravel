<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'country_id',
        'status',
        'delete_status'
    ];

    public function getCountry(){
        return $this->hasOne('App\Models\Country','id','country_id');
    }

    public function getCities(){
        return $this->hasMany('App\Models\City','state_id','id');
    }

    public function getPropertyByState(){
        return $this->hasMany('App\Models\Property','state','id');
    }




  

    

    


}
