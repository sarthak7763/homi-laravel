<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\UserSubscription;

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
    
    // $user_subscription_plan = UserSubscription::where('user_id',$user_id)->get();

    $user_subscription_plan = DB::table('user_subscriptions')->leftjoin('subscriptions','subscriptions.id','=','user_subscriptions.plan_id')
                                                            ->where('user_id',$user_id)
                                                            ->orderBy('subscription_status','DESC')
                                                            ->select('user_subscriptions.*','subscriptions.*')
                                                            ->get();
                                                 
            if($user_subscription_plan)
            {
                $user_subscription_plan_array=$user_subscription_plan->toArray();
                
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



    public function subscriptionconfirmation(Request $request,$id)
    {
        try
          {
            $user_id = Auth::User()->id;
            $subscription_plan = Subscription::where('id',$id)->first();
            // $plan_duration = $subscription_plan->plan_duration;

            UserSubscription::where('user_id',$user_id)->update(['subscription_status'=>0]);

            $start_date = date('Y-m-d');
            $end_date    = date('Y-m-d', strtotime("+1 month", strtotime($start_date)));
                $confirmation = new UserSubscription();
                $confirmation->user_id = $user_id;
                $confirmation->plan_id = $id;
                $confirmation->subscription_id = 112;
                $confirmation->subscription_status = 1;
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
