<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str,Redirect;


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

			$validator = Validator::make($request->all(), [

						'name'=>'required|regex:/^[\pL\s]+$/u',
						'mobile'=>'required|numeric|digits:10',
						'owner_type'=>'required'
					],
					[
					'name.required' => 'name is required.',
					'name.regex'=>'  Name field only alphabetic characters.',
					'mobile.required' => 'mobile no field can’t be left blank.',
					'mobile.numeric' => 'mobile no should be numeric.',
					'mobile.digits' => 'mobile no should be only 10 digits',
					 'owner_type.required' => 'owner type field can’t be left blank.',
				]);

					if($validator->fails()){

						return Redirect::back()->withErrors($validator)->withInput();
					}


					if($request->owner_type==1)
				      {
				          $validator = Validator::make($request->all(), [
				            'agency_name'=>[
				                    'required',
				                    'regex:/^[\pL\s]+$/u',
				              ],
				        ],
				        [
				          'agency_name.required' => 'Agency Name field can’t be left blank.',
				          'agency_name.regex' => 'Please enter only alphabetic characters.',
				        ]);

						    if($validator->fails()){

								return Redirect::back()->withErrors($validator)->withInput();
							}
				      }

				      
						try{
						$user  = User::find($user_id);
						if(!empty($user)){

							if ($request->hasFile('profile_pic')) {
								$imageName = time().'.'.$request->profile_pic->extension(); 
								
								$image = $request->profile_pic->move(public_path('images/user/'), $imageName);
								
								$user->name = $data['name'];
								$user->mobile = $data['mobile'];
								$user->profile_pic = $imageName;
								$user->owner_type = $data['owner_type'];
								$user->agency_name = $data['agency_name'] ?? "";
							}
							else{
								$user->name = $data['name'];
								$user->mobile = $data['mobile'];
								$user->owner_type = $data['owner_type'];
								$user->agency_name = $data['agency_name'] ?? "";
							}
							
						$user->save();
						return redirect()->route('buyer.my-profile')->with('success', 'Profile has been updated !');
					    }
						else{
						return redirect()->back()->with('error', 'user id does not found');
						}  
					}
					catch(Exception $e){
						return redirect()->back()->with('error', $e->getMessage());            
					}
        }	
    } 

	



	





       
        

    
   
  

    


    

