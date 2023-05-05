<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Bid extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
	      'id', 
	      'bidder_id', 
	      'property_id', 
	      'offer_id', 
	      'bid_price', 
	      'bid_status',
	      'created_at', 
	      'updated_at'
    ];


    public function BidderInfo(){
         return $this->hasOne('App\Models\User','id','bidder_id');
    }

    public function BidPropertyInfo(){
         return $this->hasOne('App\Models\Property','id','property_id');
    }

    public function BidPropertySaleOffer(){
         return $this->hasOne('App\Models\PropertyOffer','id','offer_id');
    }

}
