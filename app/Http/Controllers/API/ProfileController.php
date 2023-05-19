<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Userbuyinglocationsearch;
use App\Models\FavProperty;
use App\Models\Property;
use App\Models\Userbooking;
use Validator;
use Hash;
use DB;

class ProfileController extends BaseController
{

    public function getuserinfo()
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
		        if($user->profile_pic!="")
		        {
		        	$profile_pic=url('/').'/images/user/'.$user->profile_pic;
		        }
		        else{
		        	$profile_pic=url('/').'/no_image/user.jpg';
		        }

		        $userlocationsearchresult=Userbuyinglocationsearch::where('user_id',$user->id)->where('status',1)->get()->first();
		        if($userlocationsearchresult)
		        {
		        	$userlocationsearchresultarray=$userlocationsearchresult->toArray();

		     			$location=$userlocationsearchresultarray['user_location'];
		        		$lat=$userlocationsearchresultarray['user_latitude'];
		        		$lng=$userlocationsearchresultarray['user_longitude'];
		        }
		        else{
		        	$location="";
		        	$lat="";
		        	$lng="";
		        }

		        $userdet=array(
		        	'name'=>$user->name,
		        	'email'=>$user->email,
		        	'mobile'=>$user->mobile,
		        	'image'=>$profile_pic,
		        	'location'=>$location,
		        	'lat'=>$lat,
		        	'lng'=>$lng
		        );

		        $success['userdet']=$userdet;
                return $this::sendResponse($success, 'User Details.');
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']); 
	        }  
    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
    }

    public function updateprofile(Request $request)
    {
    	try{
    		$user=auth()->user();
    		if($user)
    		{
	    		$validator = Validator::make($request->all(), [
		            'name' => 'required'
		        ]);

		        if($validator->fails()){
		            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
		        }

		        if(isset($request->mobile) && $request->mobile!="")
		        {
		        	$mobile=$request->mobile;
		        }
		        else{
		        	$mobile="";
		        }

		        if ($file = $request->file('image')) {

		        	$validator = Validator::make($request->all(), [
		            	'image' => 'required|mimes:jpeg,png,jpg'
		        	]);

			         if($validator->fails()){
			            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
			        }

		            $name = 'profile_'.time().$file->getClientOriginalName(); 
		            $file->move('images/user/', $name);
		            $image = $name;
		        }
		        else{
		            $image="";
		        }

		        $userid=$user->id;
		        $userdet=User::find($userid);

			    if(is_null($userdet)){
	               return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	            }

	            if($image!="")
            	{
            		$userdet->profile_pic=$image;
            		$userdet->name = $request->name;
            		$userdet->mobile=$request->mobile;
        			$userdet->save();
            	}
            	else{
            		$userdet->name = $request->name;
            		$userdet->mobile=$request->mobile;
        			$userdet->save();
            	}

	            if($userdet->profile_pic!="")
		        {
		        	$userdet->profile_pic=url('/').'/images/user/'.$userdet->profile_pic;
		        }
		        else{
		        	$userdet->profile_pic=url('/').'/no_image/user.jpg';
		        }

		        $userlocationsearchresult=Userlocationsearch::where('user_id',$user->id)->where('status',1)->get()->first();
		        if($userlocationsearchresult)
		        {
		        	$userlocationsearchresultarray=$userlocationsearchresult->toArray();

		     			$location=$userlocationsearchresultarray['user_location'];
		        		$lat=$userlocationsearchresultarray['user_latitude'];
		        		$lng=$userlocationsearchresultarray['user_longitude'];
		        }
		        else{
		        	$location="";
		        	$lat="";
		        	$lng="";
		        }

		        $userdetarray=array(
		        	'name'=>$userdet->name,
		        	'email'=>$userdet->email,
		        	'mobile'=>$userdet->mobile,
		        	'image'=>$userdet->profile_pic,
		        	'location'=>$location,
		        	'lat'=>$lat,
		        	'lng'=>$lng
		        );     

		        $success['userdet']=$userdetarray;
	            return $this::sendResponse($success, 'Profile updated successfully.');
    		}
    		else{
    			return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
    		}	
    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
    }

    public function updateprofileimage(Request $request)
    {
    	try{
    		$user=auth()->user();
    		if($user)
    		{
    			$validator = Validator::make($request->all(), [
		            'image' => 'required|mimes:jpeg,png,jpg'
		        ]);

		        if($validator->fails()){
		            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
		        }

		        $userid=$user->id;
		        $userdet=User::find($userid);

		        if(is_null($userdet)){
	               return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	            }

		        if ($file = $request->file('image')) {
		            $name = 'profile_'.time().$file->getClientOriginalName(); 
		            $file->move('images/user/', $name);
		            $image = $name;
		        }
		        else{
		            $image="";
		        }

		        $userdet->image=$image;
				$userdet->save();

				if($userdet->image!="")
		        {
		        	$userdet->image=url('/').'/images/user/'.$userdet->image;
		        }
		        else{
		        	$userdet->image=url('/').'/images/user/profile_placeholder.png';
		        }

			    $success['userdet']=$userdet;
            	return $this::sendResponse($success, 'Profile image updated successfully.');
    		}
    		else{
    			return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
    		}
    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
    }

    public function deleteaccount(Request $request)
    {
    	try{
    		$user=auth()->user();
    		if($user)
    		{
    			$userid=$user->id;
		        $userdet=User::find($userid);

		        if(is_null($userdet)){
	               return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	            }

	            $userdet->status=2;
				$userdet->save();

				$success=[];
	           	return $this::sendResponse($success, 'Account deleted successfully.');
    		}
    		else{
    			return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
    		}
    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }

    }

    public function updatepassword(Request $request)
    {
    	try{
    		$user=auth()->user();
    		if($user)
    		{
	    		$validator = Validator::make($request->all(), [
		            'old_password' => 'required',
		            'password' => [
	                    'required',
	                    'min:8',
	                    'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@%]).*$/',
	                    'max:25'
	                ],

	                'confirm_password' => 'required|same:password',
		        ],
		        [
		        'old_password.required'=>'Please enter old password',
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

		        $userid=$user->id;
		        $userdet=User::find($userid);

		        if(is_null($userdet)){
	               return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	            }

		        $old_password=$request->old_password;
		        $new_password=$request->password;

		        if (Hash::check($old_password, $userdet->password)) {
				    $finalnewpassword=Hash::make($new_password);
				    $userdet->password=$finalnewpassword;
				    $userdet->save();

				    $success['userdet']=$userdet;
	            	return $this::sendResponse($success, 'Password updated successfully.');

				}
		        else{
		        	return $this::sendError('Wrong Password.', ['error'=>'Please enter correct old password.']);
		        }
		    }
		    else{
    			return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
    		}

    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
    }


    public function updateuserpushnotificationsettings(Request $request)
    {
    	try{
    		$user=auth()->user();

    		if($user)
    		{
    			$validator = Validator::make($request->all(), [
		            'push_notification' => 'required'
		        ]);

		        if($validator->fails()){
		            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
		        }

		        $userid=$user->id;
		        $userdet=User::find($userid);

		        if(is_null($userdet)){
	               return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	            }

	            $userdet->push_notifications=$request->push_notification;
	            $userdet->save();

	            $userarray=array(
			        	'push_notification'=>(int)$userdet->push_notifications
			        );

				    $success['userdet'] =  $userarray;
	            	return $this::sendResponse($success, 'Settings updated successfully.');

    		}
    		else{
    			return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
    		}
    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
    }


    public function updateuseremailnotificationsettings(Request $request)
    {
    	try{
    		$user=auth()->user();
    		
    		if($user)
    		{
    			$validator = Validator::make($request->all(), [
		            'email_notification' => 'required'
		        ]);

		        if($validator->fails()){
		            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
		        }

		        $userid=$user->id;
		        $userdet=User::find($userid);

		        if(is_null($userdet)){
	               return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	            }

	            $userdet->email_notifications=$request->email_notification;
	            $userdet->save();

	            $userarray=array(
			        	'email_notification'=>(int)$userdet->email_notifications
			        );

				    $success['userdet'] =  $userarray;
	            	return $this::sendResponse($success, 'Settings updated successfully.');
    		}
    		else{
    			return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
    		}

    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
    }

    public function getuserfavpropertylist(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	$wishlistproperty=FavProperty::where('buyer_id',$user->id)->where('status',1)->get();
	        	if($wishlistproperty)
	        	{
	        		$wishlistpropertyarr=$wishlistproperty->toArray();
	        		if($wishlistpropertyarr)
	        		{
	        			$propertyidarr=[];
	        			foreach($wishlistpropertyarr as $row)
	        			{
	        				$propertyidarr[]=$row['property_id'];
	        			}

	        			if(count($propertyidarr) > 0)
	        			{
	        				$fav_property=[];
	        				foreach($propertyidarr as $list)
	        				{
	        					$checkproperty=Property::where('id',$list)->get()->first();
	        					if($checkproperty)
	        					{
	        						$checkpropertyarray=$checkproperty->toArray();

	        						if($checkpropertyarray['property_image']!="")
							        {
							        	$property_image=url('/').'/property/'.$checkpropertyarray['property_image'];
							        }
							        else{
							        	$property_image=url('/').'/no_image/user.jpg';
							        }

							        if($user->id!="")
							        {
							        	$favourite=checkfavproperty($user->id,$checkpropertyarray['id']);
							        }
							        else{
							        	$favourite=0;
							        }

	        						$fav_property[]=array(
							        	'property_id'=>$checkpropertyarray['id'],
										'title'=>$checkpropertyarray['title'],
										'property_address'=>$checkpropertyarray['property_address'],
										'property_image'=>$property_image,
										'property_price'=>$checkpropertyarray['property_price'],
										'property_date'=>date('d M Y',strtotime($checkpropertyarray['created_at'])),
										'favourite'=>$favourite,
										'rating'=>5,
										'property_bedrooms'=>$checkpropertyarray['no_of_bedroom'],
										'property_description'=>$checkpropertyarray['property_description'],
										'property_area'=>$checkpropertyarray['property_area'],
										'property_type'=>$checkpropertyarray['property_type']
									);
	        					}
	        				}
	        			}
	        			else{
	        				$fav_property=[];
	        			}
	        		}
	        		else{
	        			$fav_property=[];
	        		}
	        	}
	        	else{
	        		$fav_property=[];
	        	}

		        $success['fav_property']=$fav_property;
                return $this::sendResponse($success, 'Favourite Property List.');
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']); 
	        }  
    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
    }


    public function getuserbookings(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	$ongoingbookinglist=Userbooking::where('booking_status',0)->where('user_id',$user->id)->get();
	        	if($ongoingbookinglist)
	        	{
	        		$ongoingbookinglistarray=$ongoingbookinglist->toArray();
	        		if($ongoingbookinglistarray)
	        		{
	        			$ongoing_bookings=$this->getpropertybookingslist($user->id,$ongoingbookinglistarray,$type=0);
	        		}
	        		else{
	        			$ongoing_bookings=[];
	        		}
	        	}
	        	else{
	        		$ongoing_bookings=[];
	        	}

	        	$completebookinglist=Userbooking::where('booking_status',1)->where('user_id',$user->id)->get();
	        	if($completebookinglist)
	        	{
	        		$completebookinglistarray=$completebookinglist->toArray();
	        		if($completebookinglistarray)
	        		{
	        			$complete_bookings=$this->getpropertybookingslist($user->id,$completebookinglistarray,$type=1);
	        		}
	        		else{
	        			$complete_bookings=[];
	        		}
	        	}
	        	else{
	        		$complete_bookings=[];
	        	}


	        	$cancelbookinglist=Userbooking::where('booking_status',2)->where('user_id',$user->id)->get();
	        	if($cancelbookinglist)
	        	{
	        		$cancelbookinglistarray=$cancelbookinglist->toArray();
	        		if($cancelbookinglistarray)
	        		{
	        			$cancel_bookings=$this->getpropertybookingslist($user->id,$cancelbookinglistarray,$type=2);
	        		}
	        		else{
	        			$cancel_bookings=[];
	        		}
	        	}
	        	else{
	        		$cancel_bookings=[];
	        	}

	        	$success['ongoing'] =  $ongoing_bookings;
	            $success['complete'] =  $complete_bookings;
	            $success['cancel'] =  $cancel_bookings;
	            return $this::sendResponse($success, 'My Bookings List.');
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']); 
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
    }

    public function getpropertybookingslist($userid,$bookinglistarray,$type)
    {
    	$ongoing_bookings=[];

    	foreach($bookinglistarray as $list)
    	{
    		$property_id=$list['property_id'];
    		$checkproperty=Property::where('id',$property_id)->get()->first();
    		if($checkproperty)
    		{
    			$checkpropertyarray=$checkproperty->toArray();

	    		if($checkpropertyarray['property_image']!="")
		        {
		        	$property_image=url('/').'/images/property/thumbnail/'.$checkpropertyarray['property_image'];
		        }
		        else{
		        	$property_image=url('/').'/no_image/property.jpg';
		        }

		        if($type==0)
		        {
		        	$booking_status="Ongoing";
		        }
		        elseif($type==1)
		        {
		        	$booking_status="Complete";
		        }
		        elseif($type==2)
		        {
		        	$booking_status="Cancel";
		        }
		        else{
		        	$booking_status="N.A.";
		        }

		        if($type==0)
		        {
		        	$current_date=date('Y-m-d');
		        	if($list['user_checkin_date'] > $current_date){

					    $cancel_booking=1;

					}else{
					    $cancel_booking=0;
					}
		        }
		        else{
		        	$cancel_booking=0;
		        }

		        $ongoing_bookings[]=array(
		        	'booking_id'=>$list['id'],
		        	'property_id'=>$list['property_id'],
					'title'=>$checkpropertyarray['title'],
					'property_address'=>$checkpropertyarray['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['booking_property_price'],
					'property_date'=>date('d M Y',strtotime($checkpropertyarray['created_at'])),
					'property_bedrooms'=>$checkpropertyarray['no_of_bedroom'],
					'property_description'=>$checkpropertyarray['property_description'],
					'property_area'=>$checkpropertyarray['property_area'],
					'rating'=>5,
					'check_in_date'=>$list['user_checkin_date'],
					'check_out_date'=>$list['user_checkout_date'],
					'booking_status'=>$booking_status,
					'cancel_booking'=>$cancel_booking
				);
    		}
    	}
    	return $ongoing_bookings;
    }



    public function getbookingdetails(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
				$validator = Validator::make($request->all(), [
				            'booking_id' => 'required'
				        ]);

		        if($validator->fails()){
		            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
		        }

			    $booking_id=$request->booking_id;

			    $checkbooking=Userbooking::where('id',$booking_id)->where('user_id',$user->id)->get()->first();
			    if($checkbooking)
			    {
			    	$property_id=$checkbooking->property_id;
    				$checkproperty=Property::where('id',$property_id)->get()->first();
    				if($checkproperty)
    				{
    					$checkpropertyarray=$checkproperty->toArray();
			    		if($checkpropertyarray['property_image']!="")
				        {
				        	$property_image=url('/').'/images/property/thumbnail/'.$checkpropertyarray['property_image'];
				        }
				        else{
				        	$property_image=url('/').'/no_image/property.jpg';
				        }

						if($checkbooking->booking_status==0)
				        {
				        	$booking_status="Ongoing";
				        }
				        elseif($checkbooking->booking_status==1)
				        {
				        	$booking_status="Complete";
				        }
				        elseif($checkbooking->booking_status==2)
				        {
				        	$booking_status="Cancel";
				        }
				        else{
				        	$booking_status="N.A.";
				        }

					   $booking_det=array(
			        	'booking_id'=>$checkbooking->id,
			        	'property_id'=>$checkbooking->property_id,
						'title'=>$checkpropertyarray['title'],
						'property_address'=>$checkpropertyarray['property_address'],
						'property_image'=>$property_image,
						'property_price'=>$checkbooking->booking_property_price,
						'property_date'=>date('d M Y',strtotime($checkpropertyarray['created_at'])),
						'property_bedrooms'=>$checkpropertyarray['no_of_bedroom'],
						'property_description'=>$checkpropertyarray['property_description'],
						'property_area'=>$checkpropertyarray['property_area'],
						'rating'=>5,
						'check_in_date'=>$checkbooking->user_checkin_date,
						'check_out_date'=>$checkbooking->user_checkout_date,
						'booking_status'=>$booking_status,
						'booking_property_price'=>$checkbooking->booking_property_price,
						'booking_tax_price'=>$checkbooking->booking_tax_price,
						'booking_price'=>$checkbooking->booking_price,
						'user_name'=>$checkbooking->user_name,
						'user_email'=>$checkbooking->user_email,
						'user_age'=>$checkbooking->user_age,
						'user_gender'=>$checkbooking->user_gender,
						'user_number'=>$checkbooking->user_number,
						'user_adult_count'=>$checkbooking->user_adult_count,
						'user_children_count'=>$checkbooking->user_children_count
					);


					$success['booking_det'] =  $booking_det;
		            return $this::sendResponse($success, 'My Bookings Detail Page.');


    				}
    				else{
    					return $this::sendError('Unauthorised.', ['error'=>'Something went wrong.']);
    				}
			    }
			    else{
			    	return $this::sendError('Unauthorised.', ['error'=>'Something went wrong.']); 
			    }
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']); 
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
    }

    public function submitcancelbooking(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']); 
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
    }

    public function submitbookingrating(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']); 
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
    }

    public function getuserongoingbookinglist(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']); 
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
    }

    public function getusercompletebookinglist(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']); 
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
    }

    public function getusercancelbookinglist(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']); 
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
    }
  

    

}