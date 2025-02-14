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
use App\Models\CancelReasons;
use App\Models\UserBookingRatings;
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

	        	//property type 1: renting
	        	//property type 2: buying
				if(isset($request->type) && $request->type!="")
		        {
		        	$property_type=$request->type;
		        }
		        else{
		        	$property_type="";
		        }

		        if(isset($request->lang_key) && $request->lang_key!="")
		        {
		        	$lang_key=$request->lang_key;
		        }
		        else{
		        	$lang_key="en";
		        }

	        	if($property_type!="")
	        	{
	        		$wishlistproperty=FavProperty::leftJoin('tbl_property', 'fav_properties.property_id', '=', 'tbl_property.id')
                	->select('fav_properties.*')->where('fav_properties.buyer_id',$user->id)->where('tbl_property.property_type',$property_type)->where('fav_properties.status','1')->get();
	        	}
	        	else{
	        		$wishlistproperty=FavProperty::where('buyer_id',$user->id)->where('status',1)->get();
	        	}
	        	

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
							        	$property_image=url('/').'/images/property/thumbnail/'.$checkpropertyarray['property_image'];
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

							        $propertylangdata=getpropertydetbylang($lang_key,$checkpropertyarray['id']);

	        						$fav_property[]=array(
							        	'property_id'=>$checkpropertyarray['id'],
										'title'=>$propertylangdata['title'],
										'property_address'=>$checkpropertyarray['property_address'],
										'property_image'=>$property_image,
										'property_price'=>$checkpropertyarray['property_price'],
										'property_date'=>date('d M Y',strtotime($checkpropertyarray['publish_date'])),
										'favourite'=>$favourite,
										'rating'=>5,
										'property_bedrooms'=>$checkpropertyarray['no_of_bedroom'],
										'property_description'=>$propertylangdata['description'],
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

	        	if(isset($request->lang_key) && $request->lang_key!="")
		        {
		        	$lang_key=$request->lang_key;
		        }
		        else{
		        	$lang_key="en";
		        }

	        	$ongoingbookinglist=Userbooking::where('booking_status',0)->where('user_id',$user->id)->orderBy('id','DESC')->get();
	        	if($ongoingbookinglist)
	        	{
	        		$ongoingbookinglistarray=$ongoingbookinglist->toArray();
	        		if($ongoingbookinglistarray)
	        		{
	        			$ongoing_bookings=$this->getpropertybookingslist($user->id,$ongoingbookinglistarray,$type=0,$lang_key);
	        		}
	        		else{
	        			$ongoing_bookings=[];
	        		}
	        	}
	        	else{
	        		$ongoing_bookings=[];
	        	}

	        	$completebookinglist=Userbooking::where('booking_status',1)->where('user_id',$user->id)->orderBy('id','DESC')->get();
	        	if($completebookinglist)
	        	{
	        		$completebookinglistarray=$completebookinglist->toArray();
	        		if($completebookinglistarray)
	        		{
	        			$complete_bookings=$this->getpropertybookingslist($user->id,$completebookinglistarray,$type=1,$lang_key);
	        		}
	        		else{
	        			$complete_bookings=[];
	        		}
	        	}
	        	else{
	        		$complete_bookings=[];
	        	}


	        	$cancelbookinglist=Userbooking::where('booking_status',2)->where('user_id',$user->id)->orderBy('id','DESC')->get();
	        	if($cancelbookinglist)
	        	{
	        		$cancelbookinglistarray=$cancelbookinglist->toArray();
	        		if($cancelbookinglistarray)
	        		{
	        			$cancel_bookings=$this->getpropertybookingslist($user->id,$cancelbookinglistarray,$type=2,$lang_key);
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

    public function getpropertybookingslist($userid,$bookinglistarray,$type,$lang_key)
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
		        	if($lang_key=="en")
		        	{
		        		$booking_status="Ongoing";
		        	}
		        	else{
		        		$booking_status="Em andamento";
		        	}	
		        }
		        elseif($type==1)
		        {
		        	if($lang_key=="en")
		        	{
		        		$booking_status="Complete";
		        	}
		        	else{
		        		$booking_status="Completo";
		        	}
		        }
		        elseif($type==2)
		        {
		        	if($lang_key=="en")
		        	{
		        		$booking_status="Cancel";
		        	}
		        	else{
		        		$booking_status="Cancelar";
		        	}
		        }
		        else{
		        	$booking_status="N.A.";
		        }

		        if($type==0)
		        {
		        	$current_date=date('Y-m-d');
		        	$new_check_in_date=date('Y-m-d', strtotime("-1 day", strtotime($list['user_checkin_date'])));

		        	if($new_check_in_date > $current_date){

					    $cancel_booking=1;

					}else{
					    $cancel_booking=0;
					}
		        }
		        else{
		        	$cancel_booking=0;
		        }

		        $propertylangdata=getpropertydetbylang($lang_key,$list['property_id']);

		        $ongoing_bookings[]=array(
		        	'booking_id'=>$list['id'],
		        	'property_id'=>$list['property_id'],
					'title'=>$propertylangdata['title'],
					'property_address'=>$checkpropertyarray['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['booking_property_price'],
					'property_date'=>date('d M Y',strtotime($checkpropertyarray['publish_date'])),
					'property_bedrooms'=>$checkpropertyarray['no_of_bedroom'],
					'property_description'=>$propertylangdata['description'],
					'property_area'=>$checkpropertyarray['property_area'],
					'rating'=>5,
					'check_in_date'=>date('d M,Y',strtotime($list['user_checkin_date'])),
					'check_out_date'=>date('d M,Y',strtotime($list['user_checkout_date'])),
					'adult_count'=>$list['user_adult_count'],
					'children_count'=>$list['user_children_count'],
					'booking_status'=>$booking_status,
					'cancel_booking'=>$cancel_booking,
					'booking_tax_price'=>$list['booking_tax_price'],
					'booking_total_price'=>$list['booking_price'],
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

			    if(isset($request->lang_key) && $request->lang_key!="")
		        {
		        	$lang_key=$request->lang_key;
		        }
		        else{
		        	$lang_key="en";
		        }


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
				        	if($lang_key=="en")
				        	{
				        		$booking_status_label="Ongoing";
				        	}
				        	else{
				        		$booking_status_label="Em andamento";
				        	}
				        }
				        elseif($checkbooking->booking_status==1)
				        {
				        	if($lang_key=="en")
				        	{
				        		$booking_status_label="Complete";
				        	}
				        	else{
				        		$booking_status_label="Completo";
				        	}
				        }
				        elseif($checkbooking->booking_status==2)
				        {
				        	if($lang_key=="en")
				        	{
				        		$booking_status_label="Cancel";
				        	}
				        	else{
				        		$booking_status_label="Cancelar";
				        	}
				        }
				        else{
				        	$booking_status_label="N.A.";
				        }

						if($checkbooking->booking_status==0)
				        {
				        	$current_date=date('Y-m-d');
				        	$new_check_in_date=date('Y-m-d', strtotime("-1 day", strtotime($list['user_checkin_date'])));
				        	
				        	if($new_check_in_date > $current_date){

							    $cancel_booking=1;

							}else{
							    $cancel_booking=0;
							}
				        }
				        else{
				        	$cancel_booking=0;
				        }

				        if($checkbooking->cancel_reason_id!="")
				        {
				        	if($checkbooking->cancel_reason_id!="0")
				        	{
				        		$checkcancelreason=CancelReasons::where('id',$checkbooking->cancel_reason_id)->get()->first();
				        		if($checkcancelreason)
				        		{
				        			$cancel_reason=$checkcancelreason->reason_name;
				        		}
				        		else{
				        			$cancel_reason="N.A.";
				        		}
				        	}
				        	else{
				        		$cancel_reason=$checkbooking->cancel_reason;
				        	}
				        }
				        else{
				        	$cancel_reason="N.A.";
				        }

				        $propertylangdata=getpropertydetbylang($lang_key,$checkbooking->property_id);

					   $booking_det=array(
			        	'booking_id'=>$checkbooking->id,
			        	'property_id'=>$checkbooking->property_id,
						'title'=>$propertylangdata['title'],
						'property_address'=>$checkpropertyarray['property_address'],
						'property_image'=>$property_image,
						'property_price'=>$checkbooking->booking_property_price,
						'property_date'=>date('d M Y',strtotime($checkpropertyarray['publish_date'])),
						'property_bedrooms'=>$checkpropertyarray['no_of_bedroom'],
						'property_description'=>$propertylangdata['description'],
						'property_area'=>$checkpropertyarray['property_area'],
						'rating'=>5,
						'check_in_date'=>date('d M,Y',strtotime($checkbooking->user_checkin_date)),
						'check_out_date'=>date('d M,Y',strtotime($checkbooking->user_checkout_date)),
						'booking_status'=>$checkbooking->booking_status,
						'booking_status_label'=>$booking_status_label,
						'booking_property_price'=>$checkbooking->booking_property_price,
						'booking_tax_price'=>$checkbooking->booking_tax_price,
						'booking_price'=>$checkbooking->booking_price,
						'user_name'=>$checkbooking->user_name,
						'user_email'=>$checkbooking->user_email,
						'user_age'=>$checkbooking->user_age,
						'user_gender'=>$checkbooking->user_gender,
						'user_number'=>$checkbooking->user_number,
						'user_adult_count'=>$checkbooking->user_adult_count,
						'user_children_count'=>$checkbooking->user_children_count,
						'cancel_booking'=>$cancel_booking,
						'cancel_reason'=>$cancel_reason,
						'cancel_date'=>$checkbooking->cancel_date
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

    public function getcancelreasonslist()
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	$cancel_reaonslist=CancelReasons::where('reason_status',1)->get();
	        	if($cancel_reaonslist)
	        	{
	        		$cancel_reaonslistarray=$cancel_reaonslist->toArray();
	        		if($cancel_reaonslistarray)
	        		{
	        			$cancel_reaons=[];
	        			foreach($cancel_reaonslistarray as $list)
	        			{
	        				$cancel_reaons[]=array(
	        					'id'=>$list['id'],
	        					'name'=>$list['reason_name']
	        				);
	        			}
	        		}
	        		else{
	        			$cancel_reaons=[];
	        		}
	        	}
	        	else{
	        		$cancel_reaons=[];
	        	}

	        	$success['cancel_reaons'] =  $cancel_reaons;
		        return $this::sendResponse($success, 'Cancel Reasons List.');
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
	        	$validator = Validator::make($request->all(), [
	        				'booking_id'=>'required',
				            'cancel_reason' => 'required',     
				        ]);

		        if($validator->fails()){
		            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
		        }



			    $cancel_reason=$request->cancel_reason;
			    $booking_id=$request->booking_id;

			    $checkbooking=Userbooking::where('id',$booking_id)->where('user_id',$user->id)->get()->first();
			    if($checkbooking)
			    {
			    	if($checkbooking->booking_status==0)
			    	{
			    		$current_date=date('Y-m-d');
				        $new_check_in_date=date('Y-m-d', strtotime("-1 day", strtotime($checkbooking->user_checkin_date)));

				        if($new_check_in_date >= $current_date)
				        {
				        	$cancel_date=date('Y-m-d');
					        
				        	$checkcancelreason=CancelReasons::where('reason_name',$cancel_reason)->get()->first();
				        	if($checkcancelreason)
				        	{
				        		$cancel_reason_id=$checkcancelreason->id;
				        		$updatearray=array('cancel_reason_id'=>$cancel_reason_id,'cancel_reason'=>$cancel_reason_id,'cancel_date'=>$cancel_date,'booking_status'=>2);
				        	}
				        	else{
				        		$updatearray=array('cancel_reason_id'=>0,'cancel_reason'=>$cancel_reason,'cancel_date'=>$cancel_date,'booking_status'=>2);
				        	}

						    DB::table('user_booking')
				            ->where('id', $booking_id)
				            ->where('user_id', $user->id)
				            ->update($updatearray);

				            $success=[];
		            		return $this::sendResponse($success, 'Booking cancelled successfully.');

						}else
						{
							return $this::sendError('Unauthorised.', ['error'=>'You cannot cancel the booking.']);
						}
			    	}
			    	else{
			    		return $this::sendError('Unauthorised.', ['error'=>'Booking already cancelled.']);
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
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
    }

    public function submitbookingrating(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	$validator = Validator::make($request->all(), [
	        				'booking_id'=>'required',
				            'rating' => 'required',
				        ]);

		        if($validator->fails()){
		            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
		        }



			    $rating=$request->rating;
			    $booking_id=$request->booking_id;
			    $checkbooking=Userbooking::where('id',$booking_id)->where('user_id',$user->id)->get()->first();
			    if($checkbooking)
			    {
			    	$property_id=$checkbooking->property_id;
			    	$checkuserpropertyratings=UserBookingRatings::where('user_id',$user->id)->where('booking_id',$booking_id)->where('property_id',$property_id)->get()->first();
			    	if($checkuserpropertyratings)
			    	{
			    		return $this::sendError('Unauthorised.', ['error'=>'Ratings already submitted.']);
			    	}
			    	else{
			    		$userbookingratings=new UserBookingRatings;
			    		$userbookingratings->user_id=$user->id;
			    		$userbookingratings->booking_id=$booking_id;
			    		$userbookingratings->property_id=$property_id;
			    		$userbookingratings->rating=$request->rating;
			    		$userbookingratings->status=1;
			    		$userbookingratings->save();

			    		$success=[];
		            	return $this::sendResponse($success, 'Ratings submitted successfully.');

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
  

    

}