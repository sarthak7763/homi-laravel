<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyOffer extends Model
{
    use HasFactory;


     protected $fillable = [
     	'property_id', 
     	'start_timestamp', 
     	'end_timestamp', 
     	'date_start', 
     	'date_end', 
     	'time_start', 
     	'time_end', 
     	'add_by', 
     	'offer_details', 
     	'sale_status', 
        'status', 
	     'notif_status_cron', 
	     'notification_status', 
	     'delete_status'
    ];

    public function OfferPropertyInfo(){
         return $this->hasOne('App\Models\Property','id','property_id');
    }
}
