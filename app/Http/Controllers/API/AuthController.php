<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\Helper;
use Spatie\Permission\Models\{Role,Permission};
use App\Models\{User,DeviceToken,Tempuser};
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str,DB;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use App\Mail\EmailVerification;

class AuthController extends BaseController
{
    public function register(request $request){

        try{
            $data = $request->all();
            $validator = Validator::make($data,
            [
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
            ]
        );

            if($validator->fails()){
                return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
            }

            try{
                $checkuseremail=User::where('email',$data['email'])->where('user_type','2')->get()->first();
                if($checkuseremail)
                {
                    return $this::sendError('Email exists.', ['error'=>'Email already exists. Please try with another one.']);
                }
            }
            catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }


            try{
                $data['password']= Hash::make($data['password']);
                $email_token="1234";
                $user = new Tempuser;
                $user->name=$data['name'];
                $user->email=$data['email'];
                $user->password=$data['password'];
                $user->user_type=2;
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
                    $success['email'] =  $data['email'];
                    $success['otp']=$email_token;
                    return $this::sendResponse($success, 'Account created successfully. OTP has been send to your registered email.');
                }
                else{
                    return $this::sendError('Unauthorised Exception.', ['error'=>'Something went wrong']); 
                }
            }
            catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
        }
        catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }

    }

    public function verifyemailotp(Request $request)
    {
        try{
            $data = $request->all();
            $validator = Validator::make($data,
            [
                'email'=>'required|email:rfc,dns',
                'otp'=>'required|max:4|min:4',
            ],
            [
                'email.required'=>'Email field can not be empty',
                'email.email'=>'Please enter a valid email address',
                'otp.required'=>'OTP field can’t be left blank',
                'otp.min'=>'OTP can not be less than 4 character.',
                'otp.max'=>'OTP can not be more than 4 character',
            ]
        );

            if($validator->fails()){
                return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
            }

            $checkuseremail=User::where('email',$data['email'])->where('user_type','2')->get()->first();
            if($checkuseremail)
            {
                return $this::sendError('Email exists.', ['error'=>'Email already exists. Please try with another one.']);
            }

            $checktempuseremail=Tempuser::where('email',$data['email'])->where('user_type','2')->orderBy('id', 'DESC')->get()->first();
            if($checktempuseremail)
            {
            	if($checktempuseremail->email_verified==1)
                {
                    return $this::sendError('Unauthorised Exception.', ['error'=>'Email already verified.']);
                }

                $email_verification_token=$checktempuseremail->email_verification_token;

                if($email_verification_token==$data['otp'])
                {
                    $tempuserid=$checktempuseremail->id;

                    Tempuser::query()
                     ->where('id',$tempuserid)
                     ->each(function ($oldPost) {
                      $newPost = $oldPost->replicate();
                      $newPost->setTable('users');
                      $newPost->save();
                      $oldPost->delete();
                    });

                $checkuser=User::where('email',$data['email'])->where('user_type','2')->get()->first();
                if($checkuser)
                {
                    $userid=$checkuser->id;
                    $user=User::find($userid);
                    if($user)
                    {
                        $user->email_verification_token="";
                        $user->email_verified=1;
                        $user->save();

                        $token = $user->createToken('Laravel8PassportAuth')->accessToken;

                        $success['user_id']=$userid;
                        $success['userdet']=$user;
                        $success['token']=$token;
                        $success['name'] = $user->name;
                        return $this::sendResponse($success, 'You have login successfully.');
                    }
                    else{
                        return $this::sendError('Unauthorised Exception.', ['error'=>'Something went wrong.']);
                    }
                    
                }
                else{
                    return $this::sendError('Unauthorised Exception.', ['error'=>'Email address not found.']);
                }

                }
                else{
                    return $this::sendError('Unauthorised Exception.', ['error'=>'Please enter correct OTP.']);
                }
            }
            else{
                return $this::sendError('Unauthorised Exception.', ['error'=>'Email address not found.']);
            }
        }
        catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
    }

    public function resendemailotp(Request $request)
    {
    	try{
            $data = $request->all();
            $validator = Validator::make($data,
            [
                'email'=>'required|email:rfc,dns',
            ],
            [
                'email.required'=>'Email field can not be empty',
                'email.email'=>'Please enter a valid email address',
            ]
        );

            if($validator->fails()){
                return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
            }

            $checkuseremail=Tempuser::where('email',$data['email'])->where('user_type','2')->orderBy('id', 'DESC')->get()->first();
            if($checkuseremail)
            {
                
            	if($checkuseremail->email_verified==1)
            	{
            		return $this::sendError('Unauthorised Exception.', ['error'=>'Email already verified.']);
            	}

                if($checkuseremail->email_verification_token=="")
                {
                	$email_verification_token=rand(1111,9999);
                }
                else{
                	$email_verification_token=$checkuseremail->email_verification_token;
                }

                $userid=$checkuseremail->id;
                $user=Tempuser::find($userid);
                if($user)
                {
                	$user->email_verification_token=$email_verification_token;
                    $user->email_verified=0;
                	$user->save();

                	$success['email'] =  $data['email'];
                    $success['otp']=$email_verification_token;
                    return $this::sendResponse($success, 'OTP send again to your registered email address.');
                }
                else{
                    return $this::sendError('Unauthorised Exception.', ['error'=>'Something went wrong.']);
                }
                
            }
            else{
                return $this::sendError('Unauthorised Exception.', ['error'=>'Email address not found.']);
            }
        }
        catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
    }


    public function login(Request $request)
    {
    	try{
            $data = $request->all();
            $validator = Validator::make($data,
            [
                'email'=>'required|email:rfc,dns',
                'password' => [
                    'required',
                    'min:8',
                    'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@%]).*$/',
                    'max:25'
                ],
            ],
            [
                'email.required'=>'Email field can not be empty',
                'email.email'=>'Please enter a valid email address',
                'password.required'=>'Password field can’t be left blank',
                'password.min'=>'Password can not be less than 8 character.',
                'password.max'=>'Password can not be more than 25 character',
                'password.regex'=>'Password should contain a Capital Letter, small letter, number and special characters',
            ]
        );

            if($validator->fails()){
                return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
            }

            $email=$data['email'];
            $password=$data['password'];

       try{
        if (auth()->attempt($data)) {

            $user=auth()->user();
            //$user = Auth::user();
            $token = $user->createToken('Laravel8PassportAuth')->accessToken;

            if($user->user_type=="2")
            {
                if($user->status=="1")
                {
                	$email_verified=$user->email_verified;
                	if($email_verified==1)
                	{
                		$userdet = User::find($user->id);
	                    $success['user_id']=$user->id;
                    	$success['userdet']=$user;
                    	$success['token']=$token;
                    	$success['name'] = $user->name;
                    	$success['email_verified']=$email_verified;

	                    return $this::sendResponse($success, 'User login successfully.');
                	}
                	else{
                		$userdet = User::find($user->id);
	                    $success['email']=$email;
	                    $success['otp']=$user->email_verification_token;
                    	$success['email_verified']=$email_verified;

	                    return $this::sendResponse($success, 'Please verify your email.');
                	}
                }
                else{
                    return $this::sendError('Account Supended.', ['error'=>'Your account has been suspended.']);
                }
            }
            else{
                return $this::sendForbiddenError('Unauthorised.', ['error'=>'Unauthorised User']);
            }

        } else {
            return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Invalid email or password.']);
        }
    }
    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong1.']);    
               }

        }
        catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }

    }
    

}