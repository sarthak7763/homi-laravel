<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Property;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\SellerSubscription;
use App\Models\SystemSetting;


use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str,DB;



class MySubscriptionController extends Controller
{
    //
    
    // public function usersubscription(Request $request,$id)
    // {
    //    $subscription_plan = Subscription::where('id',$id)->first();
    //   return view('buyer::user-subscription',compact('subscription_plan'));
       
    // }



    public function index()
    {

        
    $user_id = Auth::user()->id;
    
     $user_subscription_plan = UserSubscription::where('user_id',$user_id)->get();
        $user_subscrption_data =DB::table('user_subscriptions')->leftjoin('subscriptions','subscriptions.id','=','user_subscriptions.plan_id')

                                                            ->where('user_id',$user_id)
                                                            ->orderby('subscription_status','DESC')
                                                            ->select('user_subscriptions.*','subscriptions.*')
                                                            ->get();
           if($user_subscrption_data)
            {
                $user_subscription_plan_array = $user_subscrption_data->toArray();

            }
            else{
                return redirect()->back()->with('error', 'something wrong'); 
            }
    return view('buyer::my-subscription',compact('user_subscription_plan_array'));
       
    }


        

    public function allsubscriptions(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_subscription_plan = UserSubscription::where('user_id',$user_id)->where('subscription_status','1')->first();
        if($user_subscription_plan)
        {
            $user_subscription_plan_id=$user_subscription_plan->plan_id;
        }
        else{
            $user_subscription_plan_id="";
        }
       $subscription_plan = Subscription::all();
       
       return view('buyer::subscriptionplans',compact('subscription_plan','user_subscription_plan_id'));

       
    }

    public function sellerSubscription(Request $request,$id)

    {
        $subscription_plan_details= Subscription::where('id',$id)->first();
       
        $homi_account_number = SystemSetting::where('option_slug','personal-accountno')->select('option_value')->first();
        $homi_whatsapp_number = SystemSetting::where('option_slug','personal-whatsappno')->select('option_value')->first();
        $homi_email = SystemSetting::where('option_slug','personal-email')->select('option_value')->first();
        
        return view('buyer::sellersubscriptiondetails',compact('homi_account_number','homi_whatsapp_number','homi_email','subscription_plan_details'));

    }

    public function sellerSubscriptionstore (Request $request,$id)
    {
        $user_id = Auth::User()->id;
        $check_status = SellerSubscription::where('user_id',$user_id)->first();
        if(!empty($check_status))
        {
            $update_status = SellerSubscription::where('user_id',$user_id)->update(['status' =>  0,]);
        }

            if ($request->hasFile('fund_image')) {
                $imageName = time().'.'.$request->fund_image->extension();
                $fund_image = $request->fund_image->move(public_path('images/'), $imageName);
              
            }
            $user_id = Auth::User()->id;
            $seller = new SellerSubscription;
            $seller->user_id = $user_id;
            $seller->subscription_id = $id;
            $seller->status = 2;
            $seller->fund_amount = $request->fund_amount;
            $seller->fund_screenshot = $imageName;
            $seller->save();
            return redirect()->route('seller.subscription-details')->with('success','please wait .All details has been sent to admin for activation subcription plan');
        }



   
    
    


    // public function subscriptionconfirmation(Request $request,$id)
    // {
    //     try
    //       {
    //         $user_id = Auth::User()->id;
    //         $subscription_plan = Subscription::where('id',$id)->first();
    //         // $plan_duration = $subscription_plan->plan_duration;

    //         UserSubscription::where('user_id',$user_id)->update(['subscription_status'=>0]);

    //         $start_date = date('Y-m-d');
    //         $end_date    = date('Y-m-d', strtotime("+1 month", strtotime($start_date)));
    //             $confirmation = new UserSubscription();
    //             $confirmation->user_id = $user_id;
    //             $confirmation->plan_id = $id;
    //             $confirmation->subscription_id = 112;
    //             $confirmation->subscription_status = 1;
    //             $confirmation->starting_date = $start_date;
    //             $confirmation->ending_date   = $end_date;
                
    //             $confirmation->save();
    //         return redirect()->route('buyer.my-subscription')->with('success',"user subscription has been successfully");
    //       }
    //       catch(Exception $e){
    //             return redirect()->back()->with('error', 'something wrong');            
    //         }
       
    // }


   




    

}
