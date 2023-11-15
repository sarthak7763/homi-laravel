<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\UserSubscription;

use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str;



class MySubscriptionController extends Controller
{
    //
    public function index(Request $request)
    {
        
        $user_id = Auth::user()->id;
        // echo $user_id;
        // die;
        $user_subscription_plan = UserSubscription::where('user_id',$user_id)->first();
        // echo "<pre>";
        // print_r($user_subscription_plan);
        // die;


        $subscription_plan = Subscription::all();


        return view('buyer::my-subscription',compact('subscription_plan','user_subscription_plan'));
       
    }

    public function usersubscription(Request $request,$id)
    {
       $subscription_plan = Subscription::where('id',$id)->first();
      return view('buyer::user-subscription',compact('subscription_plan'));
       
    }

    public function subscriptionconfirmation(Request $request,$id)
    {
        try
          {
            $user_id = Auth::User()->id;
            $subscription_plan = Subscription::where('id',$id)->first();
            // $plan_duration = $subscription_plan->plan_duration;
            $start_date = date('Y-m-d');
            $end_date    = date('Y-m-d', strtotime("+1 month", strtotime($start_date)));
                $confirmation = new UserSubscription();
                $confirmation->user_id = $user_id;
                $confirmation->plan_id = $id;
                $confirmation->subscription_id = '';
                $confirmation->starting_date = $start_date;
                $confirmation->ending_date   = $end_date;
                $confirmation->save();
            return redirect()->route('buyer.my-subscription')->with('success',"user subscription has been successfully");
          }
          catch(Exception $e){
                return redirect()->back()->with('error', 'something wrong');            
            }
       
    }

    

}
