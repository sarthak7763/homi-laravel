<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
     protected $fillable = [
	    'id',
	    'reason_type',
	    'name', 
	    'email',
	    'mobile_no',
	    'description',
	    'status',
	    'delete_status'
	];

	
     public function getReasonType(){
         return $this->hasOne('App\Models\Reason','id','reason_type');
    }
}
