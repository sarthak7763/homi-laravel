<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{PropertyOffer,Property};


class TestController extends Controller
{
    public function index()
    {
        echo date('H:i');
        echo date('Y-m-d');
        echo date('H:i');
        $property_timer=PropertyOffer::get();
        if(!$property_timer->isEmpty()){
            foreach($property_timer as $li){
                //IF TODAY DATE
                if($li->date_end == date('Y-m-d')){
                    //CHECK TIME
                    if($li->time_end < date('H:i')){
                        $property_timers=Property::where([['id',$li->property_id],['escrow_status','!=',"Sold"]])->update(['escrow_status'=>"Pending"]);
                    }
                }elseif($li->date_end < date('Y-m-d')){
                     $property_timers=Property::where([['id',$li->property_id],['escrow_status','!=',"Sold"]])->update(['escrow_status'=>"Pending"]);
                }
               
                
            } 
            return response()->json(['status'=>"true","data"=>$property_timer]);
        
        }else
        {
              return response()->json(['status'=>"false"]);
        }  
    }
    
  

}
