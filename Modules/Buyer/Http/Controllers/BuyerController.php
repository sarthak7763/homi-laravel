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
use Hash,Auth,Validator,Exception,DataTables,Mail,Str,Notification,Redirect,Session,DB;
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

  
  public function buyershowForgotPassword(){
  try{
      
      return view('buyer::auth.passwords.email');
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }
  }




  public function buyerSubmitResetPassword(Request $request){
   try{

          $validator = Validator::make($request->all(), [
            'email'=>'required|email'
            ],
            
            [
          'email.required' => 'email is required.',
          'email.email' => 'please enter valid email type',
          ]);
          if($validator->fails()){

          return Redirect::back()->withErrors($validator)->withInput();
          }

                $user = User::where('email', $request->email)->select('email')->first();
                if(!empty($user)){
                  $token = Str::random(64);
                
                
                  DB::table('password_resets')->insert([
                        'email' => $request->email, 
                        'token' => $token, 
                        'created_at' => Carbon::now()
                      ]);

                $resend_link =  'https://homi.ezxdemo.com/dealer/reset-password/'.$token;

                

                
                getemailtemplate($template_id='11',$user['email'],$user['name'],$resend_link);

                

                  // Mail::send('emails.resetpassword', ['token' => $token ], function($message) use($user){
                    //     $message->to($user->email);
                    //     $message->subject('Reset Password');
                    // });
                    return redirect()->back()->with('success', 'Email has been sent on your email id !');
                }
                else{
                  return redirect()->back()->with('error', 'Email id does not exist !');
                }
      }
      catch(Exception $e){ 
     return redirect()->back()->with('error', $e->getmessage());     
    }
  }


  public function showResetPasswordForm($token) { 
   try{

    return view('buyer::auth.passwords.reset',['token' => $token]);
   }
    catch(Exception $e){ 
      return redirect()->back()->with('error', $e->getmessage());     
     }
 }



 public function submitResetPasswordForm(Request $request)
      {

        $validator = Validator::make($request->all(), [
          'email' => 'required|email',
              'password' => 'required|min:6|max:10|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@%]).*$/',
            'password_confirmation' => 'required|same:password'
      ],
  

      [
      'email.required' => 'Email field can’t be left blank',
      'email.email' => 'Email should be valid email type',
      'password.min'     => 'Passsword should be minimum 6 characters.',
      'password.max'    => 'Passsword must not be greater than 10 characters.',
      'password.regex' => 'Passsword should be capital letter, small letter,special charcters and number .',
      'password.required' => 'Password field can’t be left blank',
      'password_confirmation.required'=>'Confirm Password field can’t be left blank',
      'password_confirmation.same'=>'Password and confirm password doesn’t match',

      ]);
if($validator->fails()){

return Redirect::back()->withErrors($validator)->withInput();
}
        
       $request->validate([
              'email' => 'required|email',
              'password' => 'required|min:6|max:10|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@%]).*$/',
            'password_confirmation' => 'required|same:password'
          ]);
          
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();

              if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

                 if($user)
                 {
                  DB::table('password_resets')->where(['email'=> $request->email])->delete();
        
          return redirect()->route('buyer-login')->with('success', 'Your password has been reset successfully!');
              }     
              else      
              {

            return redirect()->back()->with('error','please enter valid email id');
                }
 
          
      }


      public function buyerlogout(Request $request){
        try{
        Auth::logout();
        return redirect()->route('buyer-login')->with('message', 'You Are Successfully logout!');
        }
        catch(Exception $e){ 
          return redirect()->back()->with('error', $e->getmessage());     
        }


      }//BUYER SIGN UP REGISTER POST 
        public function sellerSignupPost(Request $request){
                try{

                  $validator = Validator::make($request->all(), [
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
                        // 'confirm_password' => 'required|same:password', 
                        'mycheckbox' =>'required'    
            ],
            [
                        'name.required' => 'Name field can’t be left blank.',
                        'name.regex' => 'Please enter only alphabetic characters.',
                        'email.required'=>'Email field can not be empty',
                        'email.email'=>'Please enter a valid email address',
                        'password.required'=>'Password field can’t be left blank',
                        'password.min'=>'Password can not be less than 8 character.',
                        'password.max'=>'Password can not be more than 12 character',
                        'password.regex'=>'Password should contain a Capital Letter, small letter, number and special characters',
                        // 'confirm_password.required'=>'Confirm Password field can’t be left blank',
                        // 'confirm_password.same'=>'Password and confirm password doesn’t match',
                        'mycheckbox.required'=>'please accept terms and condition',

            ]);
                if($validator->fails()){

                return Redirect::back()->withErrors($validator)->withInput();
                }
      
          $data=$request->all();
          
          $checkuseremail=User::where('email',$data['email'])->where('user_type','3')->get()->first();
          if($checkuseremail)
          {
              return back()->with('error','Email already exists. Please try with another one.');

          }

          try{
                $data['password']= Hash::make($data['password']);
                $email_token= rand(1111,9999);
                $user = new Tempuser;
                $user->name=$data['name'];
                $user->email=$data['email'];
                $user->password=$data['password'];
                $user->user_type=3;
                $user->email_verified=0;
                $user->status=3;
                $user->email_verification_token = $email_token;
                $user->save();
                if($user)
                {
                    $details = [
                      'name' =>$data['name'],
                      'email'=>$data['email'],
                      'otp' =>$email_token
                    ];



                    getemailtemplate($template_id='1',$data['email'],$data['name'],$email_token);

   
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

      
          $validator = Validator::make($request->all(), [
              'email' => 'required|email',
              'password' => [
                'required',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@%]).*$/',
                'max:25'
               ],
              ],
          [
            'email.required' => 'email is required.',
            'email.email' => 'please enter valid email type',
            'password.required' => 'password is required.',
            'password.min' => 'password should be minimum 8 characters.',
            'password.max' => 'password should be maximum 25 characters',
            'password.regex' => 'password should be capital letter, small letter,special charcters and number .',

          ]);
            if($validator->fails()){

            return Redirect::back()->withErrors($validator)->withInput();
            }

          $credentials = $request->only('email', 'password');
              
            $vendor_login_access= User::where('email',$credentials['email'])->where('status',3)->first();
            if(!empty($vendor_login_access))
            {
              return Redirect()->back()->with('error','your request not has been verified by super admin for approval.please wait for approval');
            }
        
   
          
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
                    return redirect()->route('buyer.my-profile');
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
              return redirect("dealer/login")->with('error','Oppes! You have entered invalid credentials');
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
                         $admin = User::where('user_type','1')->get()->first();
                    getemailtemplate($template_id='5',$admin->email,$admin->name,$email_token="",$checkuser->name,$checkuser->email); 
                    
                       
                      $user_id=$checkuser->id;
                      Session::forget('email');
                      Session::forget('type');
                      Session::put('user_id', $user_id);
                      return redirect()->route('buyer-login')->with('success', 'your account verification request has been sent to super admin for approval');  
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

  public function sellerresendemailotp(Request $request)
  {
    
    $data=$request->all();

    $resend_otp = rand(1111,9999);



    if(session()->has('email') && session()->has('type'))
          {
            $seller_email=Session::get('email');
          }
          else{

            return response()->json(['status'=>'error_email','message'=>'please enter correct email','routeurl'=>'dealer/login/']);
            
          }

         $checkuseremail=Tempuser::where('email',$seller_email)->where('user_type','3')->orderBy('id', 'DESC')->get()->first();
        
         
          if($checkuseremail)

          {
              if($checkuseremail->email_verified==0)
                    {
                      
                  getemailtemplate($template_id='3',$seller_email,$checkuseremail->name,$resend_otp,$checkuseremail->mobile="");

                    $otp_update = Tempuser::where('email',$seller_email)->where('user_type','3')->orderBy('id', 'DESC')->update(
                                                                                                        ['email_verification_token'=>$resend_otp],
                                                                                                            );
                    return response()->json(['status'=>'success','message'=>'OTP resend successfully on your registered email.']);
                    }
                  else
                  {
                    return response()->json(['status'=>'error','message'=>'something wrong']);
                  }
          }
          else{
            return response()->json(['status'=>'error','message'=>'please enter correct email']);
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


  public function changePassword() {
   
    try{
     return view('buyer::changepassword');
    }
     catch(Exception $e){ 
       return redirect()->back()->with('error', $e->getmessage());     
      }
  }



  public function submitchangePassword(Request $request) {
    try
    {

          $validator = Validator::make($request->all(), [
                        'current_password' => 'required|min:6|max:10|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@%]).*$/',
                        'new_password' => [
                          'required',
                          'min:6',
                          'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@%]).*$/',
                          'max:10'
                    ],
                  'confirm_password' => 'required|same:new_password', 
          ],
            [
            'current_password.required' => 'Old passsword field can’t be left blank.',
            'current_password.min'     => ' Old passsword should be minimum 6 characters.',
            'current_password.max'    => 'Old passsword must not be greater than 10 characters.',
            'current_password.regex' => 'Old passsword should be capital letter, small letter,special charcters and number .',
            'new_password.required' => 'New password field can’t be left blank.',
            'new_password.min'      => ' New password should be minimum 6 characters.',
            'new_password.max'     => ' New password must not be greater than 10 characters.',
            'new_password.regex'   => 'Password should be capital letter, small letter,special charcters and number .',
            'confirm_password.required'=>'Confirm Password field can’t be left blank',
            'confirm_password.same'=>'Password and confirm password doesn’t match',
            
          ]);
          if($validator->fails()){

            return Redirect::back()->withErrors($validator)->withInput();
         }
         else {
                $curr_password = $request->current_password;
                $new_password  = $request->new_password;
                    if(!Hash::check($curr_password,Auth::user()->password)){
                        return redirect()->route('buyer.change-password')->with('error', 'Please enter correct old password');
                      }
                    else{
                          $user_id = Auth::user()->id;
                          $update_password = DB::table('users')->where('id',$user_id)->update(
                                                                                    [
                                                                                      'password'=> Hash::make($new_password),
                                                                                    ]);
                          return redirect()->route('buyer.my-profile')->with('success', 'Password has been updated !');
                    }
          }
      }
      catch(Exception $e){ 
            return redirect()->back()->with('error', $e->getmessage());     
     }
  }



  public function uniqueEmailGet(Request $request)
  {
    $email = $request->input('email');
    $isExists = User::where('email',$email)->first();
    if($isExists){
        return response()->json(array("code" => 400,'message'=>'Email already exists.'));
    }else{
        return response()->json(array("code" => 200,'message'=>'success'));
    }
   }
}

 





 
