<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\UserForgotMail;
use Validator;
use Mail;
use Hash;

class ForgotController extends BaseController
{

    public function forgotpassword(Request $request)
    {
        try{
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns'
        ],
        [
          'email.required'=>'Email field can not be empty',
          'email.email'=>'Please enter a valid email address',
        ]
      );

        if($validator->fails()){
                return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
        }

            try{
                  $checkmail=User::where('email',$data['email'])->where('user_type','2')->get()->first();
                    if(!$checkmail)
                    {
                        return $this::sendError('Email not exists.', ['error'=>'Email does not exists. Please enter your registered email.']);
                    }

                }catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }

               $userid=$checkmail->id;
               //$user_forgot_otp=rand(1111,9999); 
               $user_forgot_otp="1234";

               $userdet = User::find($userid);

             if(is_null($userdet)){
               return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please enter correct email.']);
            }

        try{
            
            $userdet->forgot_otp = $user_forgot_otp;
            $userdet->save();

            $success['email'] =  $request->email; 
            $success['otp'] =  $user_forgot_otp;

            return $this::sendResponse($success, 'Please check your email. We have send OTP to reset your password.');
        }
        catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
        
    }
    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }

}

    public function resendotp(Request $request)
    {
        try{
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns'
        ],
        [
          'email.required'=>'Email field can not be empty',
          'email.email'=>'Please enter a valid email address',
        ]
      );

        if($validator->fails()){
                return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
        }

            try{
                    $checkmail=User::where('email',$request->email)->get()->where('user_type','2')->first();
                    if(!$checkmail)
                    {
                        return $this::sendError('Email not exists.', ['error'=>'Email does not exists. Please enter your registered email.']);
                    }

                }catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }

               $userid=$checkmail->id;
               $userdet = User::find($userid);

             if(is_null($userdet)){
               return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please enter correct email.']);
            }

        try{
            
            if($userdet->forgot_otp!="")
            {
                $user_forgot_otp=$userdet->forgot_otp;
            }
            else{
                //$user_forgot_otp=rand(1111,9999);
                $user_forgot_otp="1234";
                $userdet->forgot_otp = $user_forgot_otp;
                $userdet->save();
            }

            $success['email'] =  $request->email; 
            $success['otp'] =  $user_forgot_otp;
            
            return $this::sendResponse($success, 'Please check your email. We have sent OTP to reset password to your account.');
        }
        catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
        
    }
    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }

    }

    public function verifyotp(Request $request)
    {
        try{
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'otp'=>'required'
        ],
        [
          'email.required'=>'Email field can not be empty',
          'email.email'=>'Please enter a valid email address',
          'otp.required'=>'OTP field can not be empty'
        ]
      );

        if($validator->fails()){
                return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
        }

            try{
                    $checkmail=User::where('email',$request->email)->get()->where('user_type','2')->first();
                    if(!$checkmail)
                    {
                        return $this::sendError('Email not exists.', ['error'=>'Email does not exists. Please enter your registered email.']);
                    }

                }catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }

               $userid=$checkmail->id;
               $userdet = User::find($userid);

             if(is_null($userdet)){
               return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please enter correct email.']);
            }

        try{

            if($userdet->forgot_otp!="")
            {
                if($userdet->forgot_otp==$request->otp)
                {
                    $success['email'] =  $request->email;
                    return $this::sendResponse($success, 'OTP verified successfully. Please reset password to your account.');
                }
                else{
                    return $this::sendError('wrong OTP.', ['error'=>'Please enter correct OTP.']);
                }
            }
            else{
                return $this::sendError('Unauthorised Exception.', ['error'=>'Something went wrong']); 
            }
        }
        catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
        
    }
    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }

}

    public function resetpassword(Request $request)
    {
        try{
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'password' => [
                    'required',
                    'min:8',
                    'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@%]).*$/',
                    'max:25'
                ],
              'confirm_password' => 'required|same:password',
        ],
        [
                'email.required'=>'Email field can not be empty',
                'email.email'=>'Please enter a valid email address',
                'password.required'=>'Password field can’t be left blank',
                'password.min'=>'Password can not be less than 8 character.',
                'password.max'=>'Password can not be more than 25 character',
                'password.regex'=>'Password should contain a Capital Letter, small letter, number and special characters',
                'confirm_password.required'=>'Confirm Password field can’t be left blank',
                'confirm_password.same'=>'Password and confirm password doesn’t match',
            ]
      );

        if($validator->fails()){
                return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
        }

            try{
                    $checkmail=User::where('email',$request->email)->get()->where('user_type','2')->first();
                    if(!$checkmail)
                    {
                        return $this::sendError('Email not exists.', ['error'=>'Email does not exists. Please enter your registered email.']);
                    }

                }catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }

               $userid=$checkmail->id;
               $userdet = User::find($userid);

             if(is_null($userdet)){
               return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please enter correct email.']);
            }

        try{
        
            $userdet->password = Hash::make($request->password);
            $userdet->forgot_otp="";
            $userdet->save();

            $success['message'] = 'Password reset successfully.';
            return $this::sendResponse($success, 'Password reset successfully to your account.');
        }
        catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
        
    }
    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }

    }
    
}