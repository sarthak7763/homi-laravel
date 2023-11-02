<?php

namespace Modules\Buyer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Password_reset;
use App\Models\{User,Tempuser};
use App\Helpers\Helper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Password;
use Hash,Auth,Validator,Exception,DataTables,Mail,Str,Notification,Session;
use Illuminate\Mail\Message; 
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

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

  //BUYER REGISTER SIGN UP VIEW PAGE
  public function BuyerVerifyEmail(Request $request){

    try{ 
      if(session()->has('email') && session()->has('type'))
      {
        return view('buyer::auth.verify');
      }
      else{
        return redirect('dealer/login/')->with('error', 'something wrong'); 
      }
      
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
    
    try{
          $data=$request->all();
          $request->validate([
            'email'=>'required|email:rfc,dns',
            'name'=>[
                  'required',
                  'regex:/^[\pL\s]+$/u',
              ],
            'password' => [
                    'required',
                    'min:8',
                    'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@%]).*$/',
                    'max:25'
              ],
            'confirm_password' => 'required|same:password',     
          ],
          [
            'name.required' => 'Name field can’t be left blank.',
            'name.regex' => 'Please enter only alphabetic characters.',
            'email.required'=>'Email field can not be empty',
            'email.email'=>'Please enter a valid email address',
            'password.required'=>'Password field can’t be left blank',
            'password.min'=>'Password can not be less than 8 character.',
            'password.max'=>'Password can not be more than 25 character',
            'password.regex'=>'Password should contain a Capital Letter, small letter, number and special characters',
            'confirm_password.required'=>'Confirm Password field can’t be left blank',
            'confirm_password.same'=>'Password and confirm password doesn’t match',
          ]);

          $checkuseremail=User::where('email',$data['email'])->where('user_type','3')->get()->first();
          if($checkuseremail)
          {
              return back()->with('error','Email already exists. Please try with another one.');
          }

          try{
                $data['password']= Hash::make($data['password']);
                $email_token="1234";
                $user = new Tempuser;
                $user->name=$data['name'];
                $user->email=$data['email'];
                $user->password=$data['password'];
                $user->user_type=3;
                $user->email_verified=0;
                $user->email_verification_token = $email_token;
                $user->save();
                if($user)
                {
                    $details = [
                      'name' =>$data['name'],
                      'email'=>$data['email'],
                      'otp' =>$email_token
                    ];
   
                    // \Mail::to($data['email'])->send(new \App\Mail\EmailVerification($details));

                    Session::put('email', $data['email']);
                    Session::put('type', 'register');
                  return redirect('dealer/verify-email/')->with('success',"Account created successfully. OTP has been send to your registered email.");
                }
                else{
                  return back()->with('error','Something went wrong4.'); 
                }
            }
            catch(\Exception $e){
                  return back()->with('error','Something went wrong3.');    
               }
    }
    catch (\Exception $e){
          if($e instanceof ValidationException){
            $listmessage=[];
            foreach($e->errors() as $key=>$list)
            {
                $listmessage[$key]=$list[0];
            }

            if(count($listmessage) > 0)
            {
                return back()->with('valid_error',$listmessage);
            }
            else{
                return back()->with('error','Something went wrong2.');
            }
            
        }
        else{
            return back()->with('error',$e->getMessage());
        }
      } 
  }

  public function sellerLoginPost(Request $request)
  {
    try
    {
       $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
       
        if (Auth::attempt($credentials)) {

          $user=auth()->user();
          if($user->user_type=="3")
          {
            if($user->status=="1")
            {
              $email_verified=$user->email_verified;
              if($email_verified==1)
              {
                Session::put('user_id', $user->id);
                return redirect('dealer/my-profile/')->with('success', 'Login successfully.');
              }
              else{
                Session::put('email', $user->email);
                Session::put('type', 'login');
                return redirect('dealer/verify-email/')->with('error', 'Please verify your email.');
              }
            }
            else{
              return redirect("dealer/login")->with('error','Your account has been suspended.');
            }
          }
          else{
            return redirect("dealer/login")->with('error','Unauthorised User');
          }
        
        }
        else{
          return redirect("dealer/login")->withSuccess('Oppes! You have entered invalid credentials');
        }
     }
    catch(\Exception $e)
    {
      return back()->with('error',$e->getMessage());
    }
   
  }

  public function sellerregisterverifyemailotp(Request $request)
  {
      try{
          $data=$request->all();
          $request->validate([
            'otp'=>'required|max:4|min:4',   
          ],
          [
            'otp.required'=>'OTP field can’t be left blank',
            'otp.min'=>'OTP can not be less than 4 character.',
            'otp.max'=>'OTP can not be more than 4 character',
          ]);

          if(session()->has('email') && session()->has('type'))
          {
            $seller_email=Session::get('email');
          }
          else{
            return redirect('dealer/login/')->with('error', 'something wrong'); 
          }

          $checkuseremail=User::where('email',$seller_email)->where('user_type','3')->get()->first();
          if($checkuseremail)
          {
              return back()->with('error','Email already exists. Please try with another one.');
          }

          $checktempuseremail=Tempuser::where('email',$seller_email)->where('user_type','3')->orderBy('id', 'DESC')->get()->first();
          if($checktempuseremail)
          {
              if($checktempuseremail->email_verified==1)
                {
                    return back()->with('error','Email already verified.');
                }

                $email_verification_token=$checktempuseremail->email_verification_token;

                if($email_verification_token==$data['otp'])
                {
                  $tempuserid=$checktempuseremail->id;
                  $tempuserdet=Tempuser::find($tempuserid);
                  $tempuserdet->email_verification_token="";
                  $tempuserdet->email_verified=1;
                  $tempuserdet->save();

                    Tempuser::query()
                     ->where('id',$tempuserid)
                     ->each(function ($oldPost) {
                      $newPost = $oldPost->replicate();
                      $newPost->setTable('users');
                      $newPost->save();
                      $oldPost->delete();
                    });

                    $checkuser=User::where('email',$seller_email)->where('user_type','3')->get()->first();
                    if($checkuser)
                    {
                      $user_id=$checkuser->id;
                      Session::forget('email');
                      Session::forget('type');
                      Session::put('user_id', $user_id);
                      return redirect('dealer/my-profile/')->with('success', 'Seller Account verified successfully.');  
                    }
                    else{
                      return back()->with('error','Something went wrong2.');
                    }
                }
                else{
                  return back()->with('error','Please enter correct OTP.');
                }
          }
          else{
            return back()->with('error','Email address not found.');
          }

    }
    catch (\Exception $e){
          if($e instanceof ValidationException){
            $listmessage=[];
            foreach($e->errors() as $key=>$list)
            {
                $listmessage[$key]=$list[0];
            }

            if(count($listmessage) > 0)
            {
                return back()->with('valid_error',$listmessage);
            }
            else{
                return back()->with('error','Something went wrong2.');
            }
            
        }
        else{
            return back()->with('error',$e->getMessage());
        }
      }
  }

  public function sellerloginverifyemailotp(Request $request)
  {
      try{
          $data=$request->all();
          $request->validate([
            'otp'=>'required|max:4|min:4',   
          ],
          [
            'otp.required'=>'OTP field can’t be left blank',
            'otp.min'=>'OTP can not be less than 4 character.',
            'otp.max'=>'OTP can not be more than 4 character',
          ]);

          if(session()->has('email') && session()->has('type'))
          {
            $seller_email=Session::get('email');
          }
          else{
            return redirect('dealer/login/')->with('error', 'something wrong'); 
          }

          $checkuseremail=User::where('email',$seller_email)->where('user_type','3')->orderBy('id', 'DESC')->get()->first();
          if($checkuseremail)
          {
              if($checkuseremail->email_verified==1)
                {
                    return back()->with('error','Email already verified.');
                }

                $email_verification_token=$checkuseremail->email_verification_token;

                if($email_verification_token==$data['otp'])
                {
                  $userid=$checkuseremail->id;
                  $userdet=User::find($userid);
                  $userdet->email_verification_token="";
                  $userdet->email_verified=1;
                  $userdet->save();

                  Session::forget('email');
                  Session::forget('type');
                  Session::put('user_id', $user_id);
                  return redirect('dealer/my-profile/')->with('success', 'Seller Account verified successfully.');
                }
                else{
                  return back()->with('error','Please enter correct OTP.');
                }
          }
          else{
            return back()->with('error','Email address not found.');
          }

    }
    catch (\Exception $e){
          if($e instanceof ValidationException){
            $listmessage=[];
            foreach($e->errors() as $key=>$list)
            {
                $listmessage[$key]=$list[0];
            }

            if(count($listmessage) > 0)
            {
                return back()->with('valid_error',$listmessage);
            }
            else{
                return back()->with('error','Something went wrong2.');
            }
            
        }
        else{
            return back()->with('error',$e->getMessage());
        }
      }
  }

 
}