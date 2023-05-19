<?php

namespace Modules\Buyer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Password_reset;
use App\Models\{User};
use App\Helpers\Helper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Password;
use Hash,Auth,Validator,Exception,DataTables,Mail,Str,Notification,Session;
use Illuminate\Mail\Message; 
use Carbon\Carbon;

class BuyerController extends Controller {

	public function buyerlogin(Request $request) { 
      try{
      return view('buyer::auth.login');
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }
  }
  

  //BUYER REGISTER SIGN UP VIEW PAGE
  public function buyerRegisterGet(Request $request){

    try{ 
      return view('buyer::auth.register');
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }
  }

  public function buyerForgotPassword(){
    try{
      return view('buyer::auth.passwords.email');
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }
  }

  //BUYER SIGN UP REGISTER POST 
  public function sellerSignupPost(Request $request){
  
    try {
      $data=$request->all();
      $seller_email= $request['email'];  
      $exist_user=User::where('email',$seller_email)->where('user_type','3')->where('status','1')->get()->toArray();
     
      if(count($exist_user) > 0)
      {
        return redirect()->back()->with('error', 'User email already exists');


      }else{
        $data['password']= Hash::make($data['password']);

        $email_token=Str::random(32);
        $user = new User;
        $user->name = $data['name']; 
        $user->user_type = 3; 
        $user->email_verified = 0; 
        $user->email=$data['email'];
        $user->password=$data['password'];
        $user->email_verification_token = $email_token;
  
      
        $user->save();
        return redirect()->route('buyer-login')->with('success', 'Success! Dealer Register successfully !!');;
      
      }

      
      // request()->validate([
      //   'name'=>'required',
      //   'email' => 'required|email|unique:users,email',
      //   'password' => 'required|min:6|same:password_confirmation',
      //   'password_confirmation' => 'required|same:password',
      // ]);
     
     
    }
    catch (\Exception $e){
     print_r($e->getMessage()); die;
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

 
}