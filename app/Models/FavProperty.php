<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavProperty extends Model
{
    use HasFactory;
      protected $fillable = [
	    'id',
	    'buyer_id',
	    'property_id', 
	    'status'
	];

}
