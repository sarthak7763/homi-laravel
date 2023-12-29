<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\{Userbooking,Property,User,CancelReasons};
use Hash,Auth,Validator,Exception,DataTables,Mail,Str,Notification,Session,DB;
use Carbon\Carbon;

class BookingController extends Controller
{
  public function Booking(Request $request)
        {
          try {
            if($request->segment(3))
            {
              $segmentvalue=$request->segment(3);
              
            }
            else{
              $segmentvalue="";
            }
            
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
          
            
            if($search_title!= "" || $search_booking_id!="" || $search_checkin!="" || $search_checkout!="" || $segmentvalue!=""  ) {
            $bookingDataquery->where(function($query) use ($search_title, $search_booking_id,$search_checkin,$search_checkout,$search_status,$segmentvalue)
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
                      $query->where("user_booking.user_checkout_date","<=",$newcheckout_Date);  
                    }

                    if ($search_status == '0' || $search_status == '1' || $search_status == '2' ) {
                      $query->where('user_booking.booking_status',$search_status );
                  }
                  
                  if($search_booking_id!=""){
                      $query->Where('user_booking.booking_id', 'like', '%' . $search_booking_id . '%');
                    } 
                    
                  
                    if($segmentvalue!="")
                    {
                      

                        if($segmentvalue=='ongoing'){
                          $query->where('user_booking.booking_status',0 );
                        }
                        elseif($segmentvalue=='completed'){
                          $query->where('user_booking.booking_status',1 );
                        }
                        elseif($segmentvalue=='cancel'){
                          $query->where('user_booking.booking_status',2 );
                        }
              

                    }
              
           

                    
              });

            }



            $bookingData = $bookingDataquery->get()->toArray();
            
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
        return view('buyer::my-bookings',compact('bookingData','cancel_reasons'));
        }
        catch (\Exception $e){
             
            return response()->json(["status" => 'error','message'=>$e->getMessage()]);
        }
    }


   

    public function bookingview($booking_id)
    {
        try {
            $view_booking_data = DB::table('user_booking')->leftjoin('tbl_property','tbl_property.id','=','user_booking.property_id')                          
                                                              ->where('user_booking.booking_id',$booking_id)
                                                              ->select('user_booking.*','tbl_property.*')
                                                              ->first();
                                         
            
            return view('buyer::viewbooking',compact('view_booking_data'));
           }
          catch (\Exception $e){
            
              return response()->json(["status" => 'error','message'=>$e->getMessage()]);
          }
    } 



    public function bookingstatus(Request $request){
        
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