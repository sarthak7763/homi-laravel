<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CmsPage;
use App\Models\Contactenquiry;
use App\Models\Notifications;
use App\Models\UserNotification;
use App\Models\CancelReasons;
use App\Models\SystemSetting;
use Validator;
use Hash;

class PagesController extends BaseController
{

    public function getcmspagecontent(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	$request->validate([
		            'slug'=>'required'
		        ]);

		        $pageslug=$request->slug;
		        $cmspagedata=CmsPage::where('page_slug',$pageslug)->get()->first();
		        if($cmspagedata)
		        {
		        	$cmspagedataarray=$cmspagedata->toArray();
		        	$pagedet=array(
		        		'name'=>$cmspagedataarray['page_title'],
		        		'description'=>$cmspagedataarray['page_description']
		        	);

		        	$success['pagedet'] =  $pagedet;
                	return $this::sendResponse($success, 'CMS Page Details.');
		        }else{
		        	return $this::sendError('Unauthorised.', ['error'=>'Something went wrong.']); 
		        }
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']); 
	        }
	    }
	    catch(\Exception $e){
        	return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
        }
    }


    public function getcontactsettingslist()
    {
    	try{
	        $user=auth()->user();

	        $contactsettingsdata=SystemSetting::where('setting_type','contactusinfo')->where('status','1')->get();
	        	if($contactsettingsdata)
	        	{
	        		$contactsettingsdataarray=$contactsettingsdata->toArray();
	        		if($contactsettingsdataarray)
	        		{
	        			$contactsettingslist=array(
	        					'contact_email'=>$contactsettingsdataarray[0]['option_value'],
	        					'contact_number'=>$contactsettingsdataarray[1]['option_value']
	        				);
	        		}
	        		else{
	        			$contactsettingslist=[];
	        		}
	        	}
	        	else{
	        		$contactsettingslist=[];
	        	}

	        	$success['contactsettingslist'] =  $contactsettingslist;
                return $this::sendResponse($success, 'Contact Settings List.');

    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
    }

    public function sendcontactenquiry(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {

		        $validator = Validator::make($request->all(), [
		            'name' =>'required',
		            'email'=>'required|email',
		            'message'=>'required'
		        ]);

		        if($validator->fails()){
		            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
		        }

	        	$name=$request->name;
	        	$email=$request->email;
	        	$message=$request->message;

	        	try{

                  $contactenquiry = new Contactenquiry;
                  $contactenquiry->name=$name;
                  $contactenquiry->email = $email;
                  $contactenquiry->message = $message;
                  $contactenquiry->status=1;
                  $contactenquiry->save();

                  $success=[];
                	return $this::sendResponse($success, 'successfully send.');
                 
              }catch(\Exception $e){
                return $this::sendError('Unauthorised Exception.', ['error'=>'Something went wrong']);     
             }

		    }
		    else{
		    	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
		    }
		}
		catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
    }

    public function getusernotificationslistcount(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	$notificationlistcount=UserNotification::where('user_id',$user->id)->where('is_read','0')->get()->count();

	        	$success['notificationcount']=$notificationlistcount;
               	return $this::sendResponse($success, 'Notifications Count.');

	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
    }

    public function getusernotificationslist(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	$usernotificationlist=UserNotification::where('user_id',$user->id)->get();
	        	if($usernotificationlist)
	        	{
	        		$usernotificationlistarray=$usernotificationlist->toArray();
	        		if($usernotificationlistarray)
	        		{
	        			$notificationlist=[];
	        			foreach($usernotificationlistarray as $list)
	        			{
	        				$checknotification=Notifications::where('id',$list['notification_id'])->where('status',1)->get()->first();
	        				if($checknotification)
	        				{
	        					$notificationlist[]=array(
	        						'notification_id'=>$checknotification->id,
	        						'title'=>$checknotification->title,
	        						'message'=>$checknotification->message,
	        						'image'=>'',
	        						'notification_date'=>date('d M, Y',strtotime($checknotification['created_at']))
	        					);
	        				}
	        			}
	        		}
	        		else{
	        			$notificationlist=[];
	        		}
	        	}
	        	else{
	        		$notificationlist=[];
	        	}

	        	$this->readusernotifications($user->id);

	        	$success['notificationlist']=$notificationlist;
               	return $this::sendResponse($success, 'Notifications List.');
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
    }

    public function readusernotifications($userid)
    {
    	UserNotification::where('user_id', $userid)
       ->update([
           'is_read' => 1
        ]);

       return true;
    }

    public function deleteusernotification(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	$validator = Validator::make($request->all(), [
		            'notification_id' =>'required'
		        ]);

		        if($validator->fails()){
		            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
		        }

		        $notification_id=$request->notification_id;
		        $checknotification=Notifications::where('id',$notification_id)->get()->first();
		        if($checknotification)
		        {
		        	$checkusernotification=UserNotification::where('notification_id',$notification_id)->where('user_id',$user->id)->get()->first();
		        	if($checkusernotification)
		        	{
		        		UserNotification::where('notification_id',$notification_id)->where('user_id',$user->id)->delete();

		       $usernotificationlist=UserNotification::where('user_id',$user->id)->get();
	        	if($usernotificationlist)
	        	{
	        		$usernotificationlistarray=$usernotificationlist->toArray();
	        		if($usernotificationlistarray)
	        		{
	        			$notificationlist=[];
	        			foreach($usernotificationlistarray as $list)
	        			{
	        				$checknotification=Notifications::where('id',$list['notification_id'])->where('status',1)->get()->first();
	        				if($checknotification)
	        				{
	        					$notificationlist[]=array(
	        						'notification_id'=>$checknotification->id,
	        						'title'=>$checknotification->title,
	        						'message'=>$checknotification->message,
	        						'image'=>'',
	        						'notification_date'=>date('d M, Y',strtotime($checknotification['created_at']))
	        					);
	        				}
	        			}
	        		}
	        		else{
	        			$notificationlist=[];
	        		}
	        	}
	        	else{
	        		$notificationlist=[];
	        	}

		        		$success['notificationlist']=$notificationlist;
               			return $this::sendResponse($success, 'Notification delete successfully.');

		        	}
		        	else{
		        		return $this::sendError('Unauthorised.', ['error'=>'Invalid User Notification.']);
		        	}
		        }
		        else{
		        	return $this::sendError('Unauthorised.', ['error'=>'Invalid Notification.']);
		        }
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
    }

    public function clearallusernotifications(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	$getusernotification=UserNotification::where('user_id',$user->id)->get();
	        	if($getusernotification)
	        	{
	        		$getusernotificationslist=$getusernotification->toArray();
	        		if($getusernotificationslist)
	        		{
	        			UserNotification::where('user_id',$user->id)->delete();

	        			$success=[];
               			return $this::sendResponse($success, 'All Notifications deleteted successfully.');

	        		}
	        		else{
	        			return $this::sendError('Unauthorised.', ['error'=>'No Notifications available.']);
	        		}
	        	}
	        	else{
	        		return $this::sendError('Unauthorised.', ['error'=>'No Notifications available.']);
	        	}
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
    }

    public function getcancelbookingreasons(Request $request)
    {
    	try{
	        $user=auth()->user();
	        if($user)
	        {
	        	$cancelreasonslist=CancelReasons::where('reason_status',1)->get();
	        	if($cancelreasonslist)
	        	{
	        		$cancelreasonslistarray=$cancelreasonslist->toArray();
	        		if($cancelreasonslistarray)
	        		{
	        			$cancel_reasons_arr=[];
	        			foreach($cancelreasonslistarray as $list)
	        			{
	        				$cancel_reasons_arr[]=array(
        						'reason_id'=>$list['id'],
        						'name'=>$list['reason_name'],
        						'description'=>$list['reason_description']
	        				);
	        			}
	        		}
	        		else{
	        			$cancel_reasons_arr=[];
	        		}
	        	}
	        	else{
	        		$cancel_reasons_arr=[];
	        	}

		       $cancel_reasons_all[]=array(
	        		'reason_id'=>0,
	        		'name'=>'Other',
	        		'description'=>'Other'
	        	);

	        	if(count($cancel_reasons_arr) > 0)
	        	{
	        		$final_cancel_reasons_arr=array_merge($cancel_reasons_arr,$cancel_reasons_all);
	        	}
	        	else{
	        		$final_cancel_reasons_arr=$cancel_reasons_all;
	        	}

	        	$success['cancel_reasons']=$final_cancel_reasons_arr;
               	return $this::sendResponse($success, 'Cancel Booking Reasons List.');
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
    }

    





}