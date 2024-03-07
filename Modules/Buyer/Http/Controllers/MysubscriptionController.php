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
use Hash,Auth,Validator,Exception,DataTables,Mail,Str,Notification,Redirect,Session,DB;






class MySubscriptionController extends Controller
{
    

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



    public function pendingSubscription()
    {

        $user_id = Auth::user()->id;

        $seller_subscription_pending_plan = SellerSubscription::where('user_id',$user_id)->where('status','0')->get()->toArray();

        $seller_subscrption_data =DB::table('seller_subscription_activation')->leftjoin('subscriptions','subscriptions.id','=','seller_subscription_activation.subscription_id')

                                                            ->where('user_id',$user_id)
                                                            ->where('seller_subscription_activation.status',2)
                                                            ->select('seller_subscription_activation.*','subscriptions.*')
                                                            ->get();
                if($seller_subscrption_data)
                {
                    $seller_subscription_data = $seller_subscrption_data->first();
    
                }
                else{
                    return redirect()->back()->with('error', 'something wrong'); 
                }                                       

            return view('buyer::pending-subscription',compact('seller_subscription_data'));
       
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

    public function sellerSubscriptionstore (Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'fund_amount' => 'required',
            'fund_image' => 'required|mimes:jpeg,png,jpg'
            ],
            [
            'fund_amount.required' => 'fund amount is required.',
            'fund_image.required' => 'fund image is required.',
            'fund_image.mimes'=>'Image extension should be jpg,jpeg,png'

            ]);
            if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
            }

                $id = $request->hidden_id;

               
               

                $user_id = Auth::User()->id;
                
                $check_status = SellerSubscription::where('user_id',$user_id)->first();
                if(!empty($check_status))
                {
                    $update_status = SellerSubscription::where('user_id',$user_id)->update(['status' =>  0,]);
                }
                      if(!empty($id))
                      {
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

                        $admin  = User::where('user_type','1')->get()->first();
                        $seller_details = User::where('id',$user_id)->get()->first();

                        $subscription_plan_details= Subscription::where('id',$id)->first();

                        $fund_screenshot = url('/').'/images/'.$imageName;

                        getemailtemplate($template_id='8',$admin->email,$admin->name,$otp="",$seller_details->name,$seller_details->email="",$title="",$property_typevalue="",$property_price="",$property_address="",
                        $property_image_link="",$subscription_plan_details->name,$subscription_plan_details->plan_price,
                        $seller->fund_amount,$fund_screenshot);

                      

                        return redirect()->route('buyer.subscription-plans')->with('success','please wait .All details has been sent to admin for activation subcription plan by mail');
                        }
                      else
                      {

                        return Redirect()->back();
                      }
                    
        }



   
    
    


    
   




    

}
