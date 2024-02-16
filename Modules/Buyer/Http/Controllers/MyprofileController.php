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
				if(!empty($userInfo)){
				return view('buyer::editprofile',compact('userInfo'));
				}
				else{
					return redirect()->back()->with('error', 'user id does not found');
				}
			}
			catch(Exception $e){
				return redirect()->back()->with('error', 'something wrong');            
			}
		}


	    public function update(Request $request){
			$data                    =    $request->all();
			$user_id                 =    Auth::User()->id;
			$request->validate([
					
					'name'=>'required|regex:/^[\pL\s]+$/u',
					  
					  'mobile' => 'required|string|between:10,12',
			],
			[
				'name.required' => 'Name field can’t be left blank.',
				'name.regex' => 'Please enter only alphabetic characters.',
				'mobile.required' => 'mobile no field can’t be left blank.',
				
				//  'mobile.min'=>'Mobile number can not be less than 10 character',
				//  'mobile.regex'=>'Please enter only alphabetic characters',

				// 'mobile.max' => 'Mobile number can not be max than 12 character',
				'mobile.between' => 'Mobile number should be 10 to 12 charcters',


			]);
					try{
						$user  = User::find($user_id);
						if(!empty($user)){
							if ($request->hasFile('profile_pic')) {
								$imageName = time().'.'.$request->profile_pic->extension(); 
								
								$image = $request->profile_pic->move(public_path('images/user/'), $imageName);
								dd($image);
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
						return redirect()->route('buyer.my-profile')->with('success', 'Profile has been updated !');
					    }
						else{
						return redirect()->back()->with('error', 'user id does not found');
						}  
					}
					catch(Exception $e){
						return redirect()->back()->with('error', 'something wrong');            
					}
        }	
    } 

	



	





       
        

    
   
  

    


    

