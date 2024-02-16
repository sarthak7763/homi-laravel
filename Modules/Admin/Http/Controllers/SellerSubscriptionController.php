<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,Email,SellerSubscription,UserSubscription,Subscription};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,Redirect,Auth,Toastr;
use DataTables;

class SellerSubscriptionController extends Controller{


    public function index(Request $request)
    {
        try{
               
            if($request->ajax()) { 
               
            $data = SellerSubscription::where('status',2)->get();
        
            
           return Datatables::of( $data)
                  ->addIndexColumn()
                    ->addColumn('seller name', function($row){
                        
                      $seller_name = User::where('id',$row->user_id)->first();
                        
                        return $seller_name->name;

                    })
                    ->addColumn('subscription plan', function($row){
                      $subscription_plan_name = Subscription::where('id',$row->subscription_id)->first();

                        return $subscription_plan_name->name;
                        
                    })->addColumn('fund amount', function($row){
                        return $row->fund_amount;

                     })->addColumn('fund screenshot', function($row){
                        
                        $fund_image='<img style="height:50px;width:auto;" src="'.url('/').'/images/'.$row->fund_screenshot.'">';
                        return $fund_image ;

                     
                    })->addColumn('action', function($row){
                        $status = $row->status;
                         if($status==2)
                         {
                            $status='<span class="badge badge-danger badge_subscription_status_change" style="cursor: pointer;" id="'.$row->id.'">Pending</span>';  
                         }
                         else
                         {
                            $status='<span class="badge badge-success badge_subscription_status_change" style="cursor: pointer;" id="'.$row->id.'">Activate</span>';
                         }  
                        return $status;
                     }) 
                     ->rawColumns(['seller name','subscription plan','fund amount','fund screenshot','action'])
                    ->make(true);
                }
            return view('admin::sellersubscription.index');
        }
        
        catch (\Exception $e) 
            {
              return redirect()->back()->with('error', $e->getMessage());
            }
    }


    public function statusupdate(Request $request)
    {
        
            $data=$request->all();
            $check_id = SellerSubscription::where('id',$data['id'])->first();
                if(empty($check_id))
                {
                    return response()->json(['error'=>'somethuing wrong']);
                }
                    $sellerData = SellerSubscription::where('id', $data['id'])->first();
                    if($sellerData->status==2){
                            $status = 1;
                        }
                        else{
                            $status = 2;
                        }
                        $sellerData->status = $status;   
                        $sellerData->save();

                        $start_date = date('Y-m-d');
                        $end_date    = date('Y-m-d', strtotime("+1 month", strtotime($start_date)));

                        $check_user_status = UserSubscription::where('user_id',$sellerData->user_id)->first();
                        if(!empty($check_user_status)){
                           $update_status =  UserSubscription::where('user_id',$sellerData->user_id)->update(['subscription_status'=>0]); 
                        
                        }
                                $user_subscription = new UserSubscription;
                                $user_subscription->user_id = $sellerData->user_id;
                                $user_subscription->subscription_id = 0;
                                $user_subscription->plan_id = $sellerData->subscription_id;
                                $user_subscription->starting_date = $start_date;
                                $user_subscription->ending_date = $end_date;
                                $user_subscription->subscription_status = 1;
                                $user_subscription->save();

                                //  $admin  = User::where('user_type','1')->get()->first();
                                
                                //  $seller_details = User::where('id',$sellerData->user_id)->get()->first();
                                 
                                //  $subscription_plan_details= Subscription::where('id',$user_subscription->plan_id)->first();    
                                
                                //  getemailtemplate($template_id='9',$admin->email="",$admin->name,$otp="",$seller_details->name,$seller_details->email="",$data['title']="",$property_typevalue="",$data['property_price']="",$data['property_address']="",
                                //  $property_image_link="",$subscription_plan_details->name="",$subscription_plan_details->plan_price="",
                                //  $subscription_plan_details->plan_duration="",$subscription_plan_details->product_listing="",$sellerData->fund_amount="",$sellerData->fund_screenshot="");

                               return response()->json(['success'=>$status]);
            
       
    }








}