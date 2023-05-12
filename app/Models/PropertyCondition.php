<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyCondition extends Model
{
        protected $table="property_condition";
        protected $fillable = [
        'name',
        'status'
    ];

}
