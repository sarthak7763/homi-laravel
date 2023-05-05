<?php

namespace Modules\Buyer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Password_reset;
use App\Models\{User,State,Bid,City,FavProperty,Property,PropertyOffer,Country,IntrestedCity,MailAction,MailTemplate,Faq,CmsPage,Reason,Complaint,Enquiry};
use App\Helpers\Helper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Password;
use Hash,Auth,Validator,Exception,DataTables,Mail,Str,Notification,Session;
use Illuminate\Mail\Message; 
use Carbon\Carbon;

class BuyerController extends Controller {
  

  //BUYER REGISTER SIGN UP VIEW PAGE
  public function buyerRegisterGet(Request $request){

    try{
      return view('buyer::auth.register');
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }
  }

  //BUYER SIGN UP REGISTER POST 
  public function sellerSignupPost(Request $request){
  print_r('ppop'); die;
    try {
      $data=$request->all();
      print_r($data);die;
      request()->validate([
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|same:password_confirmation',
        'password_confirmation' => 'required|same:password',
      ]);
     
      $data['password']= Hash::make($data['password']);
        
      
      $email_token=Str::random(32);
      $user = new User;
      $user->user_type = 3; 
      $user->email=$data['email'];
      $user->password=$data['password'];
      $user->email_verification_token = $email_token;
      $user->save();
      return redirect()->route('buyer-login')->with('success', 'Success! Dealer Register successfully !!');;
      // if($user->id){
      //   // IF ROLE NOT EXIST CREATE ROLE ELSE UPDATE ROLE NAME
      //   Role::updateOrCreate(
      //     ['name' =>"Buyer"],['name' =>"Buyer"]
      //   );
      //   //ASSIGN Patient ROLE TO USER
      //   $user->assignRole('Buyer');

      //   $adminInfo=getAdminInfo();
      //   $token="<a href=".route('buyer.verify.email',$email_token).">Click to Verify Email</a>";
      //   $mailParams=[$data['email'],$token];
      //   dispatch(new SendAddBidMailToBidders(["varify_buyer_email_for_login",$mailParams,$data['email']]));
      //   toastr()->success(' Registered Successfully! Verify email link has been sent to your email','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"3000",]);
      //        return back()->with('success', 'Success! Verify email link has been sent to your email');
      // }
    }
    catch (\Exception $e){
      dd($e);
      return redirect()->back()->with('error', 'something wrong');
    }
  }

 
}