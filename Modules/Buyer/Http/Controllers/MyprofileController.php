<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str;


class MyprofileController extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = AUth::User()->id;
        $userInfo =User::where('id',$user_id)->first();
        return view('buyer::my-profile',compact('userInfo'));
       
    }

    public function edit(Request $request)
    {
        try{
            $user_id = AUth::User()->id;
            $userInfo =User::where('id',$user_id)->first();
            return view('buyer::editprofile',compact('userInfo'));
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }
	public function update(Request $request){
				$data                    =    $request->all();
				$user_id                 =    Auth::User()->id;
				$request->validate([
					'name'=>[
							'required',
							'regex:/^[\pL\s]+$/u',
							],
					'mobile' => [
						'nullable',
						'numeric',
					],
					],
				[
					'name.required' => 'Name field can’t be left blank.',
					'name.regex' => 'Please enter only alphabetic characters.',
					'email.required'=>'Email field can not be empty',
					'email.email'=>'Please enter a valid email address',
					'mobile.max'=>'Mobile number can not be more than 12 character',
				]);
					try{
						$user  = User::find($user_id);
						if ($request->hasFile('profile_pic')) {
							$imageName = time().'.'.$request->profile_pic->extension(); 
							
							$image = $request->profile_pic->move(public_path('images/'), $imageName);
							$user->name = $data['name'];
							$user->mobile = $data['mobile'];
							$user->profile_pic = $imageName;
							$user->owner_type = $data['owner_type'];
							$user->agency_name = $data['agency_name'];
							
						}
						else{
							$user->name = $data['name'];
							$user->mobile = $data['mobile'];
							$user->owner_type = $data['owner_type'];
							$user->agency_name = $data['agency_name'];
						}
							$user->save();
						  return redirect()->route('buyer.my-profile')->with('success', 'User has been updated !');
					}
					catch(Exception $e){
						return redirect()->back()->with('error', 'something wrong');            
					}
    }	
} 

	



	





       
        

    
   
  

    


    

