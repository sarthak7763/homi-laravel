<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\{Userbooking,Property,User,CancelReasons};
use Hash,Auth,Validator,Exception,DataTables,Mail,Str,Notification,Session,DB;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
    $access_module= sellermoduleaccess();
    if($access_module=='false')
    {
      return redirect()->route('buyer.subscription-plans');
    }
   
    try{

        
        $user_id = Auth::User()->id;

        $property_id = Property ::where('add_by',$user_id)->select('id')->get()->toArray();

        $total_booking = Userbooking::whereIN('property_id',$property_id)->count();
        $total_property = Property::where('add_by',$user_id)->count();
        $ongoing_booking = Userbooking::whereIN('property_id',$property_id)->where('booking_status',0)->count();
        $completed_booking = Userbooking::whereIN('property_id',$property_id)->where('booking_status',1)->count();
        $cancel_booking = Userbooking::whereIN('property_id',$property_id)->where('booking_status',2)->count();
        $total_renting_property = Property::where('add_by',$user_id)->where('property_type',1)->count();
        $total_buying_property = Property::where('add_by',$user_id)->where('property_type',2)->count();
        
        return view('buyer::dashboard',compact('total_booking','total_property','ongoing_booking',
        'completed_booking','cancel_booking','total_renting_property','total_buying_property'));
        }
        catch (\Exception $e){
             
            return response()->json(["status" => 'error','message'=>$e->getMessage()]);
        }
    
    }




    




}
