<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\{Userbooking,Property,User,CancelReasons,UserSubscription};
use Hash,Auth,Validator,Exception,DataTables,Mail,Str,Notification,Session,DB;
use Carbon\Carbon;

class BookingController extends Controller
{

  public function Booking(Request $request)
        {
    
    $access_module= sellermoduleaccess();
    if($access_module=='false')
    {
      return redirect()->route('buyer.subscription-plans');
    }
          try {
      
            
            $user_id = Auth::User()->id;
            $property_id = Property ::where('add_by',$user_id)->select('id')->get()->toArray();
    
            $cancel_reasons = CancelReasons::where('reason_status',1)->get()->toArray();

            
            $bookingDataquery = DB::table('user_booking')->leftjoin('tbl_property','tbl_property.id','=','user_booking.property_id')
                                                    ->whereIN('user_booking.property_id',$property_id)
                                                    ->select('user_booking.*','tbl_property.title');

            $search_title = $request->title_search;
            $search_booking_id = $request->booking_id_search;
            $search_status = $request->status_search;
            $search_checkin = $request->check_in_search;
            $search_checkout = $request->check_out_search;
            $booking_status = $request->booking_status;
          
           
            $bookingDataquery->where(function($query) use ($search_title, $search_booking_id,$booking_status,$search_checkin,$search_checkout,$request)
              {
                
               
                if($search_title!=""){
                      $query->where('tbl_property.title', 'like', '%' . $search_title . '%');
                    }

                    if($search_checkin!=""){
                      $newcheckin_Date = date("Y-m-d", strtotime($search_checkin));
                      $query->where("user_booking.user_checkin_date",'>=',$newcheckin_Date);
                      
                    }

                    if($search_checkout!=""){
                      $newcheckout_Date = date("Y-m-d", strtotime($search_checkout));
                      $query->where("user_booking.user_checkout_date","=",$newcheckout_Date);  
                    }

                   
                //   if ($search_booking_status == '0'|| $search_booking_status == '1' || $search_booking_status == '2' ) {
                //     $query->where('user_booking.booking_status',$search_booking_status );
                // }
                  
                  if($search_booking_id!=""){
                      $query->Where('user_booking.booking_id', 'like', '%' . $search_booking_id . '%');
                    } 
                    
                  
                    // if($segmentvalue!="")
                    // {
                      

                        if($request->booking_status=='ongoing'){
                          $query->where('user_booking.booking_status',0 );
                        }
                        elseif($request->booking_status=='completed'){
                          $query->where('user_booking.booking_status',1 );
                        }
                        elseif($request->booking_status=='cancel'){
                          $query->where('user_booking.booking_status',2 );
                        }
                    // }
              });


        $bookingData = $bookingDataquery->get()->toArray();
        // dd($booking_status);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
        return view('buyer::my-bookings',compact('bookingData','cancel_reasons','search_title','search_booking_id','search_checkin','search_checkout','booking_status'));
        }
        catch (\Exception $e){
             
            return response()->json(["status" => 'error','message'=>$e->getMessage()]);
        }
    }

  

   

    public function bookingview($booking_id)
    {
      $access_module= sellermoduleaccess();
    if($access_module=='false')
    {
      return redirect()->route('buyer.subscription-plans');
    }

        try {
            $view_booking_data = DB::table('user_booking')->leftjoin('tbl_property','tbl_property.id','=','user_booking.property_id')                          
                                                              ->where('user_booking.booking_id',$booking_id)
                                                              ->select('user_booking.*','tbl_property.*')
                                                              ->first();
              
              $cancel_reason = CancelReasons ::where('id',$view_booking_data->cancel_reason_id)->select('reason_name')->first() ;                                              
                          
                  $new_checkin_date = $view_booking_data->user_checkin_date;
                  $new_checkout_date = $view_booking_data->user_checkout_date;
                  $diff = abs(strtotime($new_checkout_date) - strtotime($new_checkin_date));
                  $years = floor($diff / (365*60*60*24));
                  $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                  $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                 

               return view('buyer::viewbooking',compact('view_booking_data','days','cancel_reason'));
           }
          catch (\Exception $e){
            
              return response()->json(["status" => 'error','message'=>$e->getMessage()]);
          }
    } 



    public function bookingstatus(Request $request){
      $access_module= sellermoduleaccess();
    if($access_module=='false')
    {
      return redirect()->route('buyer.subscription-plans');
    }
        
        try {
          $data=$request->all();
            $request->validate([
              'booking_id'=>'required',
              ],
            [
              'booking_id.required'=>'Booking ID is required.',
            ]);

            $booking_update = Userbooking :: where('booking_id',$data['booking_id'])->first();
            if(is_null($booking_update)){
             return redirect()->route('buyer.booking','all')->with('error',"Something went wrong.");
          }
          if($booking_update->booking_status==1)
              {
                  $status = 0;
              }
                  else
                  {
                    $status = 1;
                  }
                
                  $booking_update->booking_status = $status;   
                  $booking_update->save();
              return redirect()->route('buyer.bookings','all')->with('success',"booking status updated successfully.");
            }
      catch (\Exception $e){
          return response()->json(["status" => 'error','message'=>'Something went wrong.']);
      }
        
}


    public function cancelbooking(Request $request){
      $access_module= sellermoduleaccess();
    if($access_module=='false')
    {
      return redirect()->route('buyer.subscription-plans');
    }
        try {
          $current_cancel_date = Carbon::today();
          $data=$request->all();
                $cancel_reasons = CancelReasons::where('id',$data['cancel_id'])->select('id','reason_name')->first();
                $user_booking = DB::table('user_booking')->where('booking_id',$data['cancel_booking_id'])
                                                        ->update(
                                                            ['cancel_reason_id'=>$cancel_reasons->id,
                                                            'cancel_reason'    =>$cancel_reasons->id,
                                                            'booking_status' =>  2,
                                                            'cancel_date' =>  $current_cancel_date,
                                                            ]
                                                        );
                                                     
        return redirect()->route('buyer.bookings','all')->with('success',"booking is cancelled successfully.");
        }
        catch (\Exception $e){
            return response()->json(["status" => 'error','message'=>'Something went wrong.']);
        }
                  
    }


      
        
        
        
        
            

}