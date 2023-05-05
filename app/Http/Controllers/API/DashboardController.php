<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Property;
use App\Models\Category;
use App\Models\Userlocationsearch;
use App\Models\PropertyGallery;
use App\Models\FavProperty;
use App\Models\Notifications;
use App\Models\UserNotification;
use App\Models\Userrentinglocationsearch;
use Validator;
use Hash;
use DB;

class DashboardController extends BaseController
{

	public function getuserlocation(Request $request)
	{
		try{
	        $user = auth()->guard("api")->user();
	        if($user)
	        {
		        $userlocationsearchresult=Userlocationsearch::where('user_id',$user->id)->where('status',1)->get()->first();
		        if($userlocationsearchresult)
		        {
		        	$userlocationsearchresultarray=$userlocationsearchresult->toArray();

		        	$locationarray=array(
		        		'location'=>$userlocationsearchresultarray['user_location'],
		        		'lat'=>$userlocationsearchresultarray['user_latitude'],
		        		'lng'=>$userlocationsearchresultarray['user_longitude']
		        	);
		        }
		        else{
		        	$locationarray=[];
		        }

	        }
	        else{
	        	$locationarray=[];
	        }

		    $success['location'] =  (object)$locationarray;
            return $this::sendResponse($success, 'User Location.'); 

    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
	}

	public function getpropertycategorylist(Request $request)
	{
		try{

			//property type 1: renting
        	//property type 2: buying
			if(isset($request->type) && $request->type!="")
	        {
	        	$property_type=$request->type;
	        }
	        else{
	        	$property_type=1;
	        }

	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	//login user
	        	$categorylist=Category::where('category_type',$property_type)->where('status',1)->get();
	        	if($categorylist)
	        	{
	        		$categorylistarray=$categorylist->toArray();
	        		if($categorylistarray)
	        		{
	        			foreach($categorylistarray as $list)
	        			{
	        				$category_arr[]=array(
	        					'id'=>$list['id'],
	        					'name'=>$list['name']
	        				);
	        			}
	        		}
	        		else{
	        			$category_arr=[];
	        		}
	        	}
	        	else{
	        		$category_arr=[];
	        	}

	        	$category_all[]=array(
	        		'id'=>0,
	        		'name'=>'All'
	        	);

	        	if(count($category_arr) > 0)
	        	{
	        		$final_category_arr=array_merge($category_all,$category_arr);
	        	}
	        	else{
	        		$final_category_arr=$category_all;
	        	}
	        	

	        	$success['categorylist']=$final_category_arr;
            	return $this::sendResponse($success, 'Property Category List.');
	        }
	        else{
	        	//guest login
	        	$categorylist=Category::where('category_type',$property_type)->where('status',1)->get();
	        	if($categorylist)
	        	{
	        		$categorylistarray=$categorylist->toArray();
	        		if($categorylistarray)
	        		{
	        			foreach($categorylistarray as $list)
	        			{
	        				$category_arr[]=array(
	        					'id'=>$list['id'],
	        					'name'=>$list['name']
	        				);
	        			}
	        		}
	        		else{
	        			$category_arr=[];
	        		}
	        	}
	        	else{
	        		$category_arr=[];
	        	}

	        	$category_all[]=array(
	        		'id'=>0,
	        		'name'=>'All'
	        	);

	        	if(count($category_arr) > 0)
	        	{
	        		$final_category_arr=array_merge($category_all,$category_arr);
	        	}
	        	else{
	        		$final_category_arr=$category_all;
	        	}

	        	$minmaxdata = DB::table('tbl_property')
			   ->select(\DB::raw('MIN(property_price) AS minprice, MAX(property_price) AS maxprice, MIN(property_area) AS minarea, MAX(property_area) AS maxarea'))
			   ->get();
			   if($minmaxdata)
			   {
		   		$minmaxdataarray=$minmaxdata->toArray();
		   		$minprice=(int)$minmaxdataarray[0]->minprice;
		   		$maxprice=(int)$minmaxdataarray[0]->maxprice;
		   		$minarea=(int)$minmaxdataarray[0]->minarea;
		   		$maxarea=(int)$minmaxdataarray[0]->maxarea;
			   }
			   else{
			   	$minprice=0;
			   	$maxprice=0;
			   	$minarea=0;
			   	$maxarea=0;
			   }


	        	$success['categorylist']=$final_category_arr;
	        	$success['minprice']=$minprice;
	        	$success['maxprice']=$maxprice;
	        	$success['minarea']=$minarea;
	        	$success['maxarea']=$maxarea;
            	return $this::sendResponse($success, 'Property Category List.');
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
	}

    public function gethomepagedata(Request $request)
    {
    	try{

    		$validator = Validator::make($request->all(), [
		            'location' => 'required',
		            'lat'=>'required',
		            'lng'=>'required'
		        ]);

	        if($validator->fails()){
	            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
	        }

		    $lat=$request->lat;
		    $lng=$request->lng;


		    //property type 1: renting
        //property type 2: buying

		    if(isset($request->type) && $request->type!="")
	        {
	        	$property_type=$request->type;
	        }
	        else{
	        	$property_type=1;
	        }

	        if(isset($request->category) && $request->category!="")
	        {
	        	$property_category=$request->category;
	        	if($property_category!=0)
	        	{
	        		$checkpropertycategory=Category::where('category_type',$property_type)->where('id',$property_category)->get()->first();

	        		if(!$checkpropertycategory)
	        		{
	        			return $this::sendError('Unauthorised Exception.', ['error'=>'Something went wrong.']);
	        		}
	        	}
	        }
	        else{
	        	$property_category=0;
	        }

	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	//user login api
		        $userlocationsearchresult=Userlocationsearch::where('user_id',$user->id)->get();
		        if($userlocationsearchresult)
		        {
		        	$userlocationsearchresultarray=$userlocationsearchresult->toArray();

		        	if($userlocationsearchresultarray)
		        	{
		        		Userlocationsearch::where('user_id',$user->id)->update(['status' => 0]);
		        	}
		        }

                $userlocation = new Userlocationsearch;
                $userlocation->user_id=$user->id;
                $userlocation->user_location = $request->location;
                $userlocation->user_latitude = $lat;
                $userlocation->user_longitude = $lng;
                $userlocation->status=1;
                $userlocation->save();

                if(isset($lat) && isset($lng))
                {
                	$nearbypropertylist=$this->gethomenearbypropertieslocationwise($lat,$lng,$user->id,$property_type,$property_category);

                	$recently_added_properties=$this->gethomerecentlyaddedproperties($user->id,$property_type,$property_category);
                }
                else{
                	$nearbypropertylist=$this->gethomenearbyproperties($user->id,$property_type,$property_category);

                	$recently_added_properties=$this->gethomerecentlyaddedproperties($user->id,$property_type,$property_category);
                }

                $success['nearby'] =  $nearbypropertylist;
                $success['recently_added'] =  $recently_added_properties;
                $success['property_type']=$property_type;
            	return $this::sendResponse($success, 'Properties List.');

	        }
	        else{

	        	// guest login

		        if(isset($lat) && isset($lng))
                {
                	$nearbypropertylist=$this->gethomenearbypropertieslocationwise($lat,$lng,$userid="",$property_type,$property_category);

                	$recently_added_properties=$this->gethomerecentlyaddedproperties($userid="",$property_type,$property_category);

                }
                else{
                	$nearbypropertylist=$this->gethomenearbyproperties($userid="",$property_type,$property_category);

                	$recently_added_properties=$this->gethomerecentlyaddedproperties($userid="",$property_type,$property_category);

                }

                $success['nearby'] =  $nearbypropertylist;
                $success['recently_added'] =  $recently_added_properties;
                $success['property_type']=$property_type;
                return $this::sendResponse($success, 'Properties List.');

	        }  
    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
    }


public function gethomenearbypropertieslocationwise($lat,$lng,$userid,$property_type,$property_category)
{
	if($property_category!=0)
	{
		$nearbypropertylist=Property::where('property_status',1)->where('property_type',$property_type)->where('property_category',$property_category)->get();
	}
	else{
		$nearbypropertylist=Property::where('property_status',1)->where('property_type',$property_type)->get();
	}
	
	if($nearbypropertylist)
	{
		$nearbylistarr=$nearbypropertylist->toArray();

		$nearbypropertylistarr=[];
		foreach($nearbylistarr as $list)
		{

			if($list['property_image']!="")
	        {
	        	$property_image=url('/').'/property/'.$list['property_image'];
	        }
	        else{
	        	$property_image=url('/').'/no_image/user.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list['id']);
	        }
	        else{
	        	$favourite=0;
	        }
	        

	        if($property_type==1)
	        {
		        $nearbypropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        	$nearbypropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'favourite'=>$favourite
				);
	        }
			
		}
	}
	else{
		$nearbypropertylistarr=[];
	}

	return $nearbypropertylistarr;
}

public function gethomenearbyproperties($userid,$property_type,$property_category)
{

	if($property_category!=0)
	{
		$nearbypropertylist=Property::where('property_status',1)->where('property_type',$property_type)->where('property_category',$property_category)->get();
	}
	else{
		$nearbypropertylist=Property::where('property_status',1)->where('property_type',$property_type)->get();
	}

	if($nearbypropertylist)
	{
		$nearbylistarr=$nearbypropertylist->toArray();

		$nearbypropertylistarr=[];
		foreach($nearbylistarr as $list)
		{

			if($list['property_image']!="")
	        {
	        	$property_image=url('/').'/property/'.$list['property_image'];
	        }
	        else{
	        	$property_image=url('/').'/no_image/user.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list['id']);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $nearbypropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        $nearbypropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'favourite'=>$favourite
				);
	        }
			
		}
	}
	else{
		$nearbypropertylistarr=[];
	}

	return $nearbypropertylistarr;
}

public function gethomerecentlyaddedproperties($userid,$property_type,$property_category)
{

	if($property_category!=0)
	{
		$recentlyaddedpropertylist=Property::where('property_status',1)->where('property_type',$property_type)->where('property_category',$property_category)->get();
	}
	else{
		$recentlyaddedpropertylist=Property::where('property_status',1)->where('property_type',$property_type)->get();
	}

	if($recentlyaddedpropertylist)
	{
		$recentlyaddedlistarr=$recentlyaddedpropertylist->toArray();

		$recentlyaddedpropertylistarr=[];
		foreach($recentlyaddedlistarr as $list)
		{
			if($list['property_image']!="")
	        {
	        	$property_image=url('/').'/property/'.$list['property_image'];
	        }
	        else{
	        	$property_image=url('/').'/no_image/user.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list['id']);
	        }
	        else{
	        	$favourite=0;
	        }
	        
	        if($property_type==1)
	        {
		        $recentlyaddedpropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        $recentlyaddedpropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite
				);
	        }
			
		}
	}
	else{
		$recentlyaddedpropertylistarr=[];
	}

	return $recentlyaddedpropertylistarr;
}


public function getnearbypropertieslist(Request $request)
{
	try{

		$validator = Validator::make($request->all(), [
		            'lat'=>'required',
		            'lng'=>'required'
		        ]);

        if($validator->fails()){
            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
        }

        $lat=$request->lat;
	    $lng=$request->lng;

	    //property type 1: renting
        //property type 2: buying

	    if(isset($request->type) && $request->type!="")
        {
        	$property_type=$request->type;
        }
        else{
        	$property_type=1;
        }

		if(isset($request->page) && $request->page!="")
	    {
	    	$page=$request->page;
	    }
	    else{
	    	$page=1;
	    }

	    //Buying:
		// Lowest price : 1
		// Highest Price: 2
		// Most recent: 3

		// Renting:
		// Lowest price: 1
		// Highest Price: 2
		// Most recent: 3
		//Lowest Rating: 4
		// Highest rating: 5

	    if(isset($request->sort_by) && $request->sort_by!="")
	    {
	    	$sort_by=$request->sort_by;
	    }
	    else{
	    	$sort_by=0;
	    }

	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	//user login api

	        	$nearbypropertydata=$this->get_nearby_properties_list($lat,$lng,$property_type,$user->id,$page,$sort_by);
	        	if($nearbypropertydata['code']==200)
	        	{
	        		$success['nearby'] =  $nearbypropertydata['nearbypropertylist'];
	        		$success['total']=(int)$nearbypropertydata['total'];
					$success['page']=(int)$nearbypropertydata['page'];
					$success['last_page']=(int)$nearbypropertydata['last_page'];
            		return $this::sendResponse($success, 'Nearby Properties List.');
	        	}
	        	else{
	        		return $this::sendError('Unauthorised Exception.', ['error'=>$nearbypropertydata['message']]);
	        	}
		    }
		    else{
		    	//guest login api

		    	$nearbypropertydata=$this->get_nearby_properties_list($lat,$lng,$property_type,$userid="",$page,$sort_by);
		    	if($nearbypropertydata['code']==200)
	        	{
	        		$success['nearby'] =  $nearbypropertydata['nearbypropertylist'];
            		$success['total']=(int)$nearbypropertydata['total'];
					$success['page']=(int)$nearbypropertydata['page'];
					$success['last_page']=(int)$nearbypropertydata['last_page'];
            		return $this::sendResponse($success, 'Nearby Properties List.');
	        	}
	        	else{
	        		return $this::sendError('Unauthorised Exception.', ['error'=>$nearbypropertydata['message']]);
	        	}

		    }
		}
		catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
}


public function get_nearby_properties_list($lat,$lng,$property_type,$userid,$page,$sort_by)
{
	$nearbypropertyquery=Property::where('property_status',1)->where('property_type',$property_type);

	$perPage = 2;
    $total = $nearbypropertyquery->count();
    $last_page=ceil($total / $perPage);

    if($sort_by==1)
    {
    	$nearbypropertyquery=$nearbypropertyquery->orderBy('property_price', 'ASC');
    }
    elseif($sort_by==2)
    {
    	$nearbypropertyquery=$nearbypropertyquery->orderBy('property_price', 'DESC');
    }
    elseif($sort_by==3)
    {
    	$nearbypropertyquery=$nearbypropertyquery->orderBy('id', 'DESC');
    }
    elseif($sort_by==4)
    {
    	$nearbypropertyquery=$nearbypropertyquery->orderBy('property_rating', 'ASC');
    }
    elseif($sort_by==5)
    {
    	$nearbypropertyquery=$nearbypropertyquery->orderBy('property_rating', 'DESC');
    }
    else{
    	$nearbypropertyquery=$nearbypropertyquery->orderBy('id', 'DESC');
    }
    

    $nearbypropertylist = $nearbypropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();
    if($nearbypropertylist)
    {
    	$nearbylistarr=$nearbypropertylist->toArray();
    	$nearbypropertylistarr=[];
		foreach($nearbylistarr as $list)
		{
			if($list['property_image']!="")
	        {
	        	$property_image=url('/').'/property/'.$list['property_image'];
	        }
	        else{
	        	$property_image=url('/').'/no_image/user.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list['id']);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $nearbypropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'favourite'=>$favourite,
					'rating'=>5,
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area']
				);
	        }
	        else{
		        	$nearbypropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'favourite'=>$favourite,
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area']
				);
	        }	        
		}

		if(count($nearbypropertylistarr) > 0)
		{
			$data=array('code'=>200,'message'=>'success','nearbypropertylist'=>$nearbypropertylistarr,'total'=>(int)$total,'page'=>(int)$page,'last_page'=>(int)$last_page);
			return $data;
		}
		else{
			$nearbypropertylistarr=[];
    		$data=array('code'=>200,'message'=>'success','nearbypropertylist'=>$nearbypropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0);
			return $data;
		}
		
    }
    else{
    	$nearbypropertylistarr=[];
    	$data=array('code'=>200,'message'=>'success','nearbypropertylist'=>$nearbypropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0);
		return $data;

    }
}


public function getrecentlyaddeddpropertylist(Request $request)
{
	try{

			//property type 1: renting
        	//property type 2: buying

			if(isset($request->type) && $request->type!="")
	        {
	        	$property_type=$request->type;
	        }
	        else{
	        	$property_type=1;
	        }

		    if(isset($request->page) && $request->page!="")
		    {
		    	$page=$request->page;
		    }
		    else{
		    	$page=1;
		    }

		    //Buying:
		// Lowest price : 1
		// Highest Price: 2
		// Most recent: 3

		// Renting:
		// Lowest price: 1
		// Highest Price: 2
		// Most recent: 3
		//Lowest Rating: 4
		// Highest rating: 5

		    if(isset($request->sort_by) && $request->sort_by!="")
		    {
		    	$sort_by=$request->sort_by;
		    }
		    else{
		    	$sort_by=0;
		    }

	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	//user login api

	        	$recentlypropertydata=$this->get_recentlyadded_properties_list($property_type,$user->id,$page,$sort_by);
	        	if($recentlypropertydata['code']==200)
	        	{
	        		$success['recently_added'] =  $recentlypropertydata['recentlypropertylist'];
	        		$success['total']=(int)$recentlypropertydata['total'];
					$success['page']=(int)$recentlypropertydata['page'];
					$success['last_page']=(int)$recentlypropertydata['last_page'];
            		return $this::sendResponse($success, 'Recently added Properties List.');
	        	}
	        	else{
	        		return $this::sendError('Unauthorised Exception.', ['error'=>$recentlypropertydata['message']]);
	        	}
                
	        }
	        else{
	        	//guest login api

	        	$recentlypropertydata=$this->get_recentlyadded_properties_list($property_type,$userid="",$page,$sort_by);
	        	if($recentlypropertydata['code']==200)
	        	{
	        		$success['recently_added'] =  $recentlypropertydata['recentlypropertylist'];
	        		$success['total']=(int)$recentlypropertydata['total'];
					$success['page']=(int)$recentlypropertydata['page'];
					$success['last_page']=(int)$recentlypropertydata['last_page'];
            		return $this::sendResponse($success, 'Recently added Properties List.');
	        	}
	        	else{
	        		return $this::sendError('Unauthorised Exception.', ['error'=>$recentlypropertydata['message']]);
	        	}

	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
}

public function get_recentlyadded_properties_list($property_type,$userid,$page,$sort_by)
{
	$recentlypropertyquery=Property::where('property_status',1)->where('property_type',$property_type);

	$perPage = 2;
    $total = $recentlypropertyquery->count();
    $last_page=ceil($total / $perPage);

    if($sort_by==1)
    {
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('property_price', 'ASC');
    }
    elseif($sort_by==2)
    {
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('property_price', 'DESC');
    }
    elseif($sort_by==3)
    {
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('id', 'DESC');
    }
    elseif($sort_by==4)
    {
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('property_rating', 'ASC');
    }
    elseif($sort_by==5)
    {
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('property_rating', 'DESC');
    }
    else{
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('id', 'DESC');
    }

    $recentlypropertylist = $recentlypropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

    if($recentlypropertylist)
    {
    	$recentlylistarr=$recentlypropertylist->toArray();
    	$recentlypropertylistarr=[];
    	foreach($recentlylistarr as $list)
    	{
    		if($list['property_image']!="")
	        {
	        	$property_image=url('/').'/property/'.$list['property_image'];
	        }
	        else{
	        	$property_image=url('/').'/no_image/user.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list['id']);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $recentlypropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        $recentlypropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite
				);
	        }
    	}

    	if(count($recentlypropertylistarr) > 0)
		{
			$data=array('code'=>200,'message'=>'success','recentlypropertylist'=>$recentlypropertylistarr,'total'=>(int)$total,'page'=>(int)$page,'last_page'=>(int)$last_page);
			return $data;
		}
		else{
			$recentlypropertylistarr=[];
    		$data=array('code'=>200,'message'=>'success','recentlypropertylist'=>$recentlypropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0
    		);
			return $data;
		}
    }
    else{
    	$recentlypropertylistarr=[];
    	$data=array('code'=>200,'message'=>'success','recentlypropertylist'=>$recentlypropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0);
		return $data;
    }
}


public function getpropertydetails(Request $request)
{
	try{

    		$validator = Validator::make($request->all(), [
		            'property_id' => 'required'
		        ]);

	        if($validator->fails()){
	            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
	        }

	        $property_id=$request->property_id;

	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	//login user

	        	$propertydata=$this->getproperty_details_api($property_id,$user->id);

	        	if($propertydata['code']==200)
	        	{
	        		$success['property_data'] =  $propertydata['propertyarray'];
            		return $this::sendResponse($success, 'Properties Details.');
	        	}
	        	else{
	        		return $this::sendError('Unauthorised Exception.', ['error'=>$propertydata['message']]);
	        	}
	        }
	        else{
	        	//guest user

	        	$propertydata=$this->getproperty_details_api($property_id,$userid="");
	        	if($propertydata['code']==200)
	        	{
	        		$success['property_data'] =  $propertydata['propertyarray'];
            		return $this::sendResponse($success, 'Properties Details.');
	        	}
	        	else{
	        		return $this::sendError('Unauthorised Exception.', ['error'=>$propertydata['message']]);
	        	}
	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }

}


public function getproperty_details_api($property_id,$userid)
{
	$checkproperty=Property::where('id',$property_id)->where('property_status','1')->get()->first();
	if($checkproperty)
	{
		$checkpropertyarray=$checkproperty->toArray();
		if($checkpropertyarray)
		{
			$checkpropertygallery=PropertyGallery::where('property_id',$property_id)->where('status',1)->get();
			if($checkpropertygallery)
			{
				$propertygalleryarray=$checkpropertygallery->toArray();
				if($propertygalleryarray)
				{
					$property_gallery=[];
					foreach($propertygalleryarray as $list)
					{
						$property_gallery[]=url('/').'/images/property/gallery/'.$list['image'];
					}
				}
				else{
					$property_gallery=[];
				}
			}
			else{
				$property_gallery=[];
			}

			if(count($property_gallery) == 0)
			{
				if($checkpropertyarray['property_image']!="")
		        {
		        	$property_image=url('/').'/property/'.$checkpropertyarray['property_image'];
		        }
		        else{
		        	$property_image=url('/').'/no_image/user.jpg';
		        }

				array_push($property_gallery,$property_image);
			}

			if($checkpropertyarray['property_type']==1)
			{
				$category_type=2;
			}
			else{
				$category_type=1;
			}

			$checkpropertycategory=Category::where('category_type',$category_type)->where('id',$checkpropertyarray['property_category'])->get()->first();
			if($checkpropertycategory)
			{
				$property_category=$checkpropertycategory->name;
			}
			else{
				$property_category='-';
			}

			$sellerid=$checkpropertyarray['add_by'];
			$sellerdet=User::where('user_type',3)->where('id',$sellerid)->get()->first();
			if($sellerdet)
			{
				$sellername=$sellerdet->name;
				$selleremail=$sellerdet->email;
				$sellernumber=$sellerdet->mobile;

				if($sellerdet->profile_pic!="")
		        {
		        	$sellerimage=url('/').'/images/user/'.$sellerdet->profile_pic;
		        }
		        else{
		        	$sellerimage=url('/').'/no_image/user.jpg';
		        }
			}
			else{
				$sellername="";
				$selleremail="";
				$sellernumber="";
				$sellerimage="";
			}

			if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$checkpropertyarray['id']);
	        }
	        else{
	        	$favourite=0;
	        }

			$propertyarray=array(
				'property_id'=>$checkpropertyarray['id'],
				'property_gallery'=>$property_gallery,
				'property_type'=>$checkpropertyarray['property_type'],
				'title'=>$checkpropertyarray['title'],
				'property_address'=>$checkpropertyarray['property_address'],
				'property_latitude'=>$checkpropertyarray['property_latitude'],
				'property_longitude'=>$checkpropertyarray['property_longitude'],
				'property_price'=>$checkpropertyarray['property_price'],
				'property_date'=>date('d M Y',strtotime($checkpropertyarray['created_at'])),
				'property_category'=>$property_category,
				'guest_count'=>$checkpropertyarray['guest_count'],
				'no_of_bedroom'=>$checkpropertyarray['no_of_bedroom'],
				'no_of_kitchen'=>$checkpropertyarray['no_of_kitchen'],
				'no_of_bathroom'=>$checkpropertyarray['no_of_bathroom'],
				'no_of_pool'=>$checkpropertyarray['no_of_pool'],
				'no_of_garden'=>$checkpropertyarray['no_of_garden'],
				'no_of_balcony'=>$checkpropertyarray['no_of_balcony'],
				'property_area'=>$checkpropertyarray['property_area'],
				'built_in_year'=>$checkpropertyarray['built_in_year'],
				'property_description'=>$checkpropertyarray['property_description'],
				'favourite'=>$favourite
			);

			if($checkpropertyarray['property_type']==1)
			{
				$propertyarray['property_rating'] = 5;
			}
			else{
				$propertyarray['sellernumber'] = $checkpropertyarray['property_number'];
				$propertyarray['sellerimage']=$sellerimage;
				$propertyarray['sellername']=$sellername;
			}

			$data=array('code'=>200,'message'=>'success','propertyarray'=>$propertyarray);
			return $data;
		}
		else{

			$data=array('code'=>400,'message'=>'Something went wrong','propertyarray'=>[]);
			return $data;
		}
	}
	else{

		$data=array('code'=>400,'message'=>'Something went wrong','propertyarray'=>[]);
		return $data;
	}
}



	public function wishlistproperty(Request $request)
    {
    	try{

    		$validator = Validator::make($request->all(), [
		            'property_id' => 'required'
		        ]);

	        if($validator->fails()){
	            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
	        }

		    $property_id=$request->property_id;
	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	//user login api

	        	$checkproperty=Property::where('id',$property_id)->where('property_status',1)->get()->first();
	        	if($checkproperty)
	        	{
	        		$checkpropertywishlist=FavProperty::where('property_id',$property_id)->where('buyer_id',$user->id)->get()->first();
	        		if($checkpropertywishlist)
	        		{
	        			$wishlistid=$checkpropertywishlist->id;
	        			$favproperty=FavProperty::find($wishlistid);
	        			if(is_null($favproperty)){
				           return redirect('admin/user-list/')->with('error','Something went wrong.');
				        }

				        $favproperty->delete();

				        $success['favourite']=0;
            			return $this::sendResponse($success, 'Property removed from wishlist');
	        		}
	        		else{
	        			$favproperty=new FavProperty;
	        			$favproperty->property_id=$request->property_id;
	        			$favproperty->buyer_id=$user->id;
	        			$favproperty->save();

	        			 $success['favourite']=1;
            			return $this::sendResponse($success, 'Property added to wishlist');
	        		}
	        	}
	        	else{
	        		return $this::sendError('Unauthorised.', ['error'=>'Invalid property.']);
	        	}
	        }
	        else{

	        	// guest login

	        	return $this::sendError('Unauthorised.', ['error'=>'Guest user not allowed to wishlist the property.']);
	        }  
    	}
    	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
    }


    public function filterpropertylisting(Request $request)
    {
    	try{
    	//property type 1: renting
        //property type 2: buying

    	if(isset($request->type) && $request->type!="")
        {
        	$property_type=$request->type;
        }
        else{
        	$property_type=1;
        }

        //list type nearBy: nearbylist
        //list type recent: recentlyadded

        if(isset($request->list_type) && $request->list_type!="")
        {
        	$list_type=$request->list_type;
        }
        else{
        	$list_type="recent";
        }

	    if(isset($request->page) && $request->page!="")
	    {
	    	$page=$request->page;
	    }
	    else{
	    	$page=1;
	    }

	 	//Buying:
		// Lowest price : 1
		// Highest Price: 2
		// Most recent: 3

		// Renting:
		// Lowest price: 1
		// Highest Price: 2
		// Most recent: 3
		//Lowest Rating: 4
		// Highest rating: 5

	    if(isset($request->sort_by) && $request->sort_by!="")
	    {
	    	$sort_by=$request->sort_by;
	    }
	    else{
	    	$sort_by=0;
	    }

	    if(isset($request->category) && $request->category!="")
        {
        	$category=$request->category;
        	$checkpropertycategory=Category::where('category_type',$property_type)->where('id',$category)->get()->first();
        	if(!$checkpropertycategory)
        	{
        		$category="";
        	}
        }
        else{
        	$category="";
        }

        if(isset($request->min_price) && $request->min_price!="")
	    {
	    	$min_price=$request->min_price;
	    }
	    else{
	    	$min_price=0;
	    }

	    if(isset($request->max_price) && $request->max_price!="")
	    {
	    	$max_price=$request->max_price;
	    }
	    else{
	    	$max_price="";
	    }

	    if(isset($request->min_area) && $request->min_area!="")
	    {
	    	$min_area=$request->min_area;
	    }
	    else{
	    	$min_area=0;
	    }

	    if(isset($request->max_area) && $request->max_area!="")
	    {
	    	$max_area=$request->max_area;
	    }
	    else{
	    	$max_area="";
	    }

	    if(isset($request->publish_date) && $request->publish_date!="")
	    {
	    	$publish_date=$request->publish_date;
	    }
	    else{
	    	$publish_date="";
	    }

	    //bed count
	    //All: 0
	    //1 : 1
	    //2:  2
	    //3:  3
	    //4+: 4

	    if(isset($request->bed_count) && $request->bed_count!="")
	    {
	    	$bed_count=$request->bed_count;
	    }
	    else{
	    	$bed_count=0;
	    }

	    if(isset($request->built_year) && $request->built_year!="")
	    {
	    	$built_year=$request->built_year;
	    }
	    else{
	    	$built_year="";
	    }

	    if($list_type=="nearBy")
	    {
	    	if($request->lat!="")
	    	{
	    		$lat=$request->lat;
	    	}
	    	else{
	    		return $this::sendError('Unauthorised Exception.', ['error'=>'Please provide location latitude']);
	    	}

	    	if($request->lng!="")
	    	{
	    		$lng=$request->lng;
	    	}
	    	else{
	    		return $this::sendError('Unauthorised Exception.', ['error'=>'Please provide location longitude']);
	    	}
	    }

	    $user = auth()->guard("api")->user();
        if($user)
        {
        	//user login api

        	if($list_type=="nearBy")
        	{
        		$nearbyfilterpropertydata=$this->get_nearby_filter_properties_list($property_type,$user->id,$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$lat,$lng);
	        	if($nearbyfilterpropertydata['code']==200)
	        	{
	        		$success['nearby'] =  $nearbyfilterpropertydata['filterpropertylist'];
	        		$success['total']=(int)$nearbyfilterpropertydata['total'];
					$success['page']=(int)$nearbyfilterpropertydata['page'];
					$success['last_page']=(int)$nearbyfilterpropertydata['last_page'];
	        		return $this::sendResponse($success, 'Nearby Filter Properties List.');
	        	}
	        	else{
	        		return $this::sendError('Unauthorised Exception.', ['error'=>$nearbyfilterpropertydata['message']]);
	        	}
        	}
        	else{
        		$recentfilterpropertydata=$this->get_recently_filter_properties_list($property_type,$user->id,$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year);
	        	if($recentfilterpropertydata['code']==200)
	        	{
	        		$success['recently_added'] =  $recentfilterpropertydata['filterpropertylist'];
	        		$success['total']=(int)$recentfilterpropertydata['total'];
					$success['page']=(int)$recentfilterpropertydata['page'];
					$success['last_page']=(int)$recentfilterpropertydata['last_page'];
	        		return $this::sendResponse($success, 'Recent Filter Properties List.');
	        	}
	        	else{
	        		return $this::sendError('Unauthorised Exception.', ['error'=>$recentfilterpropertydata['message']]);
	        	}
        	}	
            
        }
        else{
        	//guest login api

        	if($list_type=="nearBy")
        	{
        		$nearbyfilterpropertydata=$this->get_nearby_filter_properties_list($property_type,$userid="",$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$lat,$lng);
	        	if($nearbyfilterpropertydata['code']==200)
	        	{
	        		$success['nearby'] =  $nearbyfilterpropertydata['filterpropertylist'];
	        		$success['total']=(int)$nearbyfilterpropertydata['total'];
					$success['page']=(int)$nearbyfilterpropertydata['page'];
					$success['last_page']=(int)$nearbyfilterpropertydata['last_page'];
	        		return $this::sendResponse($success, 'Nearby Filter Properties List.');
	        	}
	        	else{
	        		return $this::sendError('Unauthorised Exception.', ['error'=>$nearbyfilterpropertydata['message']]);
	        	}
        	}
        	else{
        		$recentfilterpropertydata=$this->get_recently_filter_properties_list($property_type,$userid="",$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year);
	        	if($recentfilterpropertydata['code']==200)
	        	{
	        		$success['recently_added'] =  $recentfilterpropertydata['filterpropertylist'];
	        		$success['total']=(int)$recentfilterpropertydata['total'];
					$success['page']=(int)$recentfilterpropertydata['page'];
					$success['last_page']=(int)$recentfilterpropertydata['last_page'];
	        		return $this::sendResponse($success, 'Recent Filter Properties List.');
	        	}
	        	else{
	        		return $this::sendError('Unauthorised Exception.', ['error'=>$recentfilterpropertydata['message']]);
	        	}
        	}

        }
    }
    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }


    }

    public function get_nearby_filter_properties_list($property_type,$userid,$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$lat,$lng)
    {
    	$filterpropertyquery=Property::where('property_status',1)->where('property_type',$property_type);

    	if(isset($category) && $category!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_category',$category);
    	}

    	if(isset($min_price) && $min_price!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_price','>=',$min_price);
    	}

    	if(isset($max_price) && $max_price!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_price','<=',$max_price);
    	}

    	if(isset($min_area) && $min_area!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_area','>=',$min_area);
    	}

    	if(isset($max_area) && $max_area!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_area','<=',$max_area);
    	}

    	if(isset($publish_date) && $publish_date!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('publish_date',$publish_date);
    	}

    	if(isset($bed_count) && $bed_count!="")
    	{
    		if($bed_count==1)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==2)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==3)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==4)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('no_of_bedroom','>=',$bed_count);
    		}
    	}

    	if(isset($built_year) && $built_year!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('built_in_year',$built_year);
    	}

		$perPage = 2;
	    $total = $filterpropertyquery->count();
	    $last_page=ceil($total / $perPage);

	    if($sort_by==1)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('property_price', 'ASC');
	    }
	    elseif($sort_by==2)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('property_price', 'DESC');
	    }
	    elseif($sort_by==3)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('id', 'DESC');
	    }
	    elseif($sort_by==4)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('property_rating', 'ASC');
	    }
	    elseif($sort_by==5)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('property_rating', 'DESC');
	    }
	    else{
	    	$filterpropertyquery=$filterpropertyquery->orderBy('id', 'DESC');
	    }

	    $filterpropertylist = $filterpropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

	    if($filterpropertylist)
	    {
	    	$filterlistarr=$filterpropertylist->toArray();
	    	$filterpropertylistarr=[];
	    	foreach($filterlistarr as $list)
	    	{
	    		if($list['property_image']!="")
		        {
		        	$property_image=url('/').'/property/'.$list['property_image'];
		        }
		        else{
		        	$property_image=url('/').'/no_image/user.jpg';
		        }

		        if($userid!="")
		        {
		        	$favourite=checkfavproperty($userid,$list['id']);
		        }
		        else{
		        	$favourite=0;
		        }

		        if($property_type==1)
		        {
			        $filterpropertylistarr[]=array(
			        	'property_id'=>$list['id'],
						'title'=>$list['title'],
						'property_address'=>$list['property_address'],
						'property_image'=>$property_image,
						'property_price'=>$list['property_price'],
						'property_date'=>date('d M Y',strtotime($list['created_at'])),
						'property_bedrooms'=>$list['no_of_bedroom'],
						'property_description'=>$list['property_description'],
						'property_area'=>$list['property_area'],
						'favourite'=>$favourite,
						'rating'=>5
					);
		        }
		        else{
			        $filterpropertylistarr[]=array(
			        	'property_id'=>$list['id'],
						'title'=>$list['title'],
						'property_address'=>$list['property_address'],
						'property_image'=>$property_image,
						'property_price'=>$list['property_price'],
						'property_date'=>date('d M Y',strtotime($list['created_at'])),
						'property_bedrooms'=>$list['no_of_bedroom'],
						'property_description'=>$list['property_description'],
						'property_area'=>$list['property_area'],
						'favourite'=>$favourite
					);
		        }
	    	}

	    	if(count($filterpropertylistarr) > 0)
			{
				$data=array('code'=>200,'message'=>'success','filterpropertylist'=>$filterpropertylistarr,'total'=>(int)$total,'page'=>(int)$page,'last_page'=>(int)$last_page);
				return $data;
			}
			else{
				$filterpropertylistarr=[];
	    		$data=array('code'=>200,'message'=>'success','filterpropertylist'=>$filterpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0
	    		);
				return $data;
			}
	    }
	    else{
	    	$filterpropertylistarr=[];
	    	$data=array('code'=>200,'message'=>'success','filterpropertylist'=>$filterpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0);
			return $data;
	    }
    }

    public function get_recently_filter_properties_list($property_type,$userid,$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year)
    {
    	$filterpropertyquery=Property::where('property_status',1)->where('property_type',$property_type);

    	if(isset($category) && $category!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_category',$category);
    	}

    	if(isset($min_price) && $min_price!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_price','>=',$min_price);
    	}

    	if(isset($max_price) && $max_price!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_price','<=',$max_price);
    	}

    	if(isset($min_area) && $min_area!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_area','>=',$min_area);
    	}

    	if(isset($max_area) && $max_area!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_area','<=',$max_area);
    	}

    	if(isset($publish_date) && $publish_date!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('publish_date',$publish_date);
    	}

    	if(isset($bed_count) && $bed_count!="")
    	{
    		if($bed_count==1)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==2)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==3)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==4)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('no_of_bedroom','>=',$bed_count);
    		}
    	}

    	if(isset($built_year) && $built_year!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('built_in_year',$built_year);
    	}

		$perPage = 2;
	    $total = $filterpropertyquery->count();
	    $last_page=ceil($total / $perPage);

	    if($sort_by==1)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('property_price', 'ASC');
	    }
	    elseif($sort_by==2)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('property_price', 'DESC');
	    }
	    elseif($sort_by==3)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('id', 'DESC');
	    }
	    elseif($sort_by==4)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('property_rating', 'ASC');
	    }
	    elseif($sort_by==5)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('property_rating', 'DESC');
	    }
	    else{
	    	$filterpropertyquery=$filterpropertyquery->orderBy('id', 'DESC');
	    }

	    $filterpropertylist = $filterpropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

	    if($filterpropertylist)
	    {
	    	$filterlistarr=$filterpropertylist->toArray();
	    	$filterpropertylistarr=[];
	    	foreach($filterlistarr as $list)
	    	{
	    		if($list['property_image']!="")
		        {
		        	$property_image=url('/').'/property/'.$list['property_image'];
		        }
		        else{
		        	$property_image=url('/').'/no_image/user.jpg';
		        }

		        if($userid!="")
		        {
		        	$favourite=checkfavproperty($userid,$list['id']);
		        }
		        else{
		        	$favourite=0;
		        }

		        if($property_type==1)
		        {
			        $filterpropertylistarr[]=array(
			        	'property_id'=>$list['id'],
						'title'=>$list['title'],
						'property_address'=>$list['property_address'],
						'property_image'=>$property_image,
						'property_price'=>$list['property_price'],
						'property_date'=>date('d M Y',strtotime($list['created_at'])),
						'property_bedrooms'=>$list['no_of_bedroom'],
						'property_description'=>$list['property_description'],
						'property_area'=>$list['property_area'],
						'favourite'=>$favourite,
						'rating'=>5
					);
		        }
		        else{
			        $filterpropertylistarr[]=array(
			        	'property_id'=>$list['id'],
						'title'=>$list['title'],
						'property_address'=>$list['property_address'],
						'property_image'=>$property_image,
						'property_price'=>$list['property_price'],
						'property_date'=>date('d M Y',strtotime($list['created_at'])),
						'property_bedrooms'=>$list['no_of_bedroom'],
						'property_description'=>$list['property_description'],
						'property_area'=>$list['property_area'],
						'favourite'=>$favourite
					);
		        }
	    	}

	    	if(count($filterpropertylistarr) > 0)
			{
				$data=array('code'=>200,'message'=>'success','filterpropertylist'=>$filterpropertylistarr,'total'=>(int)$total,'page'=>(int)$page,'last_page'=>(int)$last_page);
				return $data;
			}
			else{
				$filterpropertylistarr=[];
	    		$data=array('code'=>200,'message'=>'success','filterpropertylist'=>$filterpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0
	    		);
				return $data;
			}
	    }
	    else{
	    	$filterpropertylistarr=[];
	    	$data=array('code'=>200,'message'=>'success','filterpropertylist'=>$filterpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0);
			return $data;
	    }
    }



public function getsearchpropertylist(Request $request)
{
	try{

			//property type 1: renting
        //property type 2: buying

			if(isset($request->type) && $request->type!="")
	        {
	        	$property_type=$request->type;
	        }
	        else{
	        	$property_type=1;
	        }

	        if(isset($request->search) && $request->search!="")
	        {
	        	$search=$request->search;
	        }
	        else{
	        	$search="";
	        }

		    if(isset($request->page) && $request->page!="")
		    {
		    	$page=$request->page;
		    }
		    else{
		    	$page=1;
		    }

		    if(isset($request->sort_by) && $request->sort_by!="")
		    {
		    	$sort_by=$request->sort_by;
		    }
		    else{
		    	$sort_by=0;
		    }

		    $lat="";
		    $lng="";


	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	//user login api
	        	if($lat!="" && $lng!="")
	        	{
	        		$nearbysearchpropertydata=$this->get_nearby_search_properties_list($property_type,$user->id,$page,$sort_by,$search,$lat,$lng);
		        	if($nearbysearchpropertydata['code']==200)
		        	{
		        		$success['property_list'] =  $nearbysearchpropertydata['searchpropertylist'];
		        		$success['total']=(int)$nearbysearchpropertydata['total'];
						$success['page']=(int)$nearbysearchpropertydata['page'];
						$success['last_page']=(int)$nearbysearchpropertydata['last_page'];
	            		return $this::sendResponse($success, 'Nearby Search Properties List.');
		        	}
		        	else{
		        		return $this::sendError('Unauthorised Exception.', ['error'=>$nearbysearchpropertydata['message']]);
		        	}
	        	}
	        	else{
	        		$recentsearchpropertydata=$this->get_recent_search_properties_list($property_type,$user->id,$page,$sort_by,$search);
		        	if($recentsearchpropertydata['code']==200)
		        	{
		        		$success['property_list'] =  $recentsearchpropertydata['searchpropertylist'];
		        		$success['total']=(int)$recentsearchpropertydata['total'];
						$success['page']=(int)$recentsearchpropertydata['page'];
						$success['last_page']=(int)$recentsearchpropertydata['last_page'];
	            		return $this::sendResponse($success, 'Recent Search Properties List.');
		        	}
		        	else{
		        		return $this::sendError('Unauthorised Exception.', ['error'=>$recentsearchpropertydata['message']]);
		        	}
	        	}
                
	        }
	        else{
	        	//guest login api

	        	if($lat!="" && $lng!="")
	        	{
	        		$nearbysearchpropertydata=$this->get_nearby_search_properties_list($property_type,$userid="",$page,$sort_by,$search,$lat,$lng);
		        	if($nearbysearchpropertydata['code']==200)
		        	{
		        		$success['property_list'] =  $nearbysearchpropertydata['searchpropertylist'];
		        		$success['total']=(int)$nearbysearchpropertydata['total'];
						$success['page']=(int)$nearbysearchpropertydata['page'];
						$success['last_page']=(int)$nearbysearchpropertydata['last_page'];
	            		return $this::sendResponse($success, 'Nearby Search Properties List.');
		        	}
		        	else{
		        		return $this::sendError('Unauthorised Exception.', ['error'=>$nearbysearchpropertydata['message']]);
		        	}
	        	}
	        	else{
	        		$recentsearchpropertydata=$this->get_recent_search_properties_list($property_type,$userid="",$page,$sort_by,$search);
		        	if($recentsearchpropertydata['code']==200)
		        	{
		        		$success['property_list'] =  $recentsearchpropertydata['searchpropertylist'];
		        		$success['total']=(int)$recentsearchpropertydata['total'];
						$success['page']=(int)$recentsearchpropertydata['page'];
						$success['last_page']=(int)$recentsearchpropertydata['last_page'];
	            		return $this::sendResponse($success, 'Recent Search Properties List.');
		        	}
		        	else{
		        		return $this::sendError('Unauthorised Exception.', ['error'=>$recentsearchpropertydata['message']]);
		        	}
	        	}

	        }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
}

public function get_nearby_search_properties_list($property_type,$userid,$page,$sort_by,$search,$lat,$lng)
{
	$searchpropertyquery=Property::where('property_status',1)->where('property_type',$property_type);

	if(isset($search) && $search!="")
	{
		$searchpropertyquery=$searchpropertyquery->where('title', 'LIKE', '%' .$search . '%');
	}

	$perPage = 2;
    $total = $searchpropertyquery->count();
    $last_page=ceil($total / $perPage);

    if($sort_by==1)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_price', 'ASC');
    }
    elseif($sort_by==2)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_price', 'DESC');
    }
    elseif($sort_by==3)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('id', 'DESC');
    }
    elseif($sort_by==4)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_rating', 'ASC');
    }
    elseif($sort_by==5)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_rating', 'DESC');
    }
    else{
    	$searchpropertyquery=$searchpropertyquery->orderBy('id', 'DESC');
    }

    $searchpropertylist = $searchpropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

    if($searchpropertylist)
    {
    	$searchlistarr=$searchpropertylist->toArray();
    	$searchpropertylistarr=[];
    	foreach($searchlistarr as $list)
    	{
    		if($list['property_image']!="")
	        {
	        	$property_image=url('/').'/property/'.$list['property_image'];
	        }
	        else{
	        	$property_image=url('/').'/no_image/user.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list['id']);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite
				);
	        }
    	}

    	if(count($searchpropertylistarr) > 0)
		{
			$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>(int)$total,'page'=>(int)$page,'last_page'=>(int)$last_page);
			return $data;
		}
		else{
			$searchpropertylistarr=[];
    		$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0
    		);
			return $data;
		}
    }
    else{
    	$searchpropertylistarr=[];
    	$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0);
		return $data;
    }
}

public function get_recent_search_properties_list($property_type,$userid,$page,$sort_by,$search)
{
	$searchpropertyquery=Property::where('property_status',1)->where('property_type',$property_type);

	if(isset($search) && $search!="")
	{
		$searchpropertyquery=$searchpropertyquery->where('title', 'LIKE', '%' .$search . '%');
	}

	$perPage = 2;
    $total = $searchpropertyquery->count();
    $last_page=ceil($total / $perPage);

    if($sort_by==1)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_price', 'ASC');
    }
    elseif($sort_by==2)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_price', 'DESC');
    }
    elseif($sort_by==3)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('id', 'DESC');
    }
    elseif($sort_by==4)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_rating', 'ASC');
    }
    elseif($sort_by==5)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_rating', 'DESC');
    }
    else{
    	$searchpropertyquery=$searchpropertyquery->orderBy('id', 'DESC');
    }

    $searchpropertylist = $searchpropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

    if($searchpropertylist)
    {
    	$searchlistarr=$searchpropertylist->toArray();
    	$searchpropertylistarr=[];
    	foreach($searchlistarr as $list)
    	{
    		if($list['property_image']!="")
	        {
	        	$property_image=url('/').'/property/'.$list['property_image'];
	        }
	        else{
	        	$property_image=url('/').'/no_image/user.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list['id']);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite
				);
	        }
    	}

    	if(count($searchpropertylistarr) > 0)
		{
			$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>(int)$total,'page'=>(int)$page,'last_page'=>(int)$last_page);
			return $data;
		}
		else{
			$searchpropertylistarr=[];
    		$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0
    		);
			return $data;
		}
    }
    else{
    	$searchpropertylistarr=[];
    	$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0);
		return $data;
    }
}


public function searchrentingproperty(Request $request)
{
	try{

		$validator = Validator::make($request->all(), [
		            'location' => 'required',
		            'lat'=>'required',
		            'lng'=>'required'
		        ]);

	        if($validator->fails()){
	            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
	        }

		    $lat=$request->lat;
		    $lng=$request->lng;

		      //property type 1: renting
        	//property type 2: buying

		    if(isset($request->type) && $request->type!="")
	        {
	        	$property_type=$request->type;
	        }
	        else{
	        	$property_type=1;
	        }

	        if(isset($request->check_in_date) && $request->check_in_date!="")
	        {
	        	$check_in_date=$request->check_in_date;
	        }
	        else{
	        	$check_in_date="";
	        }

	        if(isset($request->check_out_date) && $request->check_out_date!="")
	        {
	        	$check_out_date=$request->check_out_date;
	        }
	        else{
	        	$check_out_date="";
	        }

	        if(isset($request->adult_count) && $request->adult_count!="")
	        {
	        	$adult_count=$request->adult_count;
	        }
	        else{
	        	$adult_count="";
	        }

	        if(isset($request->children_count) && $request->children_count!="")
	        {
	        	$children_count=$request->children_count;
	        }
	        else{
	        	$children_count="";
	        }

	        if(isset($request->page) && $request->page!="")
		    {
		    	$page=$request->page;
		    }
		    else{
		    	$page=1;
		    }

		     //Buying:
			// Lowest price : 1
			// Highest Price: 2
			// Most recent: 3

			// Renting:
			// Lowest price: 1
			// Highest Price: 2
			// Most recent: 3
			//Lowest Rating: 4
			// Highest rating: 5

	    if(isset($request->sort_by) && $request->sort_by!="")
	    {
	    	$sort_by=$request->sort_by;
	    }
	    else{
	    	$sort_by=0;
	    }


	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	//login user api

	        	$userrentinglocationsearchresult=Userrentinglocationsearch::where('user_id',$user->id)->get();
		        if($userrentinglocationsearchresult)
		        {
		        	$userrentinglocationsearchresultarray=$userrentinglocationsearchresult->toArray();

		        	if($userrentinglocationsearchresultarray)
		        	{
		        		Userrentinglocationsearch::where('user_id',$user->id)->update(['status' => 0]);
		        	}
		        }

		        $userlocation = new Userrentinglocationsearch;
                $userlocation->user_id=$user->id;
                $userlocation->user_location = $request->location;
                $userlocation->user_latitude = $lat;
                $userlocation->user_longitude = $lng;
                $userlocation->user_checkin_date=$check_in_date;
                $userlocation->user_checkout_date=$check_out_date;
                $userlocation->user_adults_count=$adult_count;
                $userlocation->user_children_count=$children_count;
                $userlocation->status=1;
                $userlocation->save();


                if($lat!="" && $lng!="")
                {
                	$nearbyrentingdata=$this->get_nearby_renting_list($lat,$lng,$property_type,$user->id,$page,$sort_by,$check_in_date,$check_out_date,$adult_count,$children_count);
		        	if($nearbyrentingdata['code']==200)
		        	{
		        		$success['property_list'] =  $nearbyrentingdata['searchpropertylist'];
		        		$success['total']=(int)$nearbyrentingdata['total'];
						$success['page']=(int)$nearbyrentingdata['page'];
						$success['last_page']=(int)$nearbyrentingdata['last_page'];
	            		return $this::sendResponse($success, 'Nearby Properties List.');
		        	}
		        	else{
		        		return $this::sendError('Unauthorised Exception.', ['error'=>$nearbyrentingdata['message']]);
		        	}
                }
                else{
                	$recentrentingdata=$this->get_recent_renting_list($property_type,$user->id,$page,$sort_by,$check_in_date,$check_out_date,$adult_count,$children_count);
		        	if($recentrentingdata['code']==200)
		        	{
		        		$success['property_list'] =  $recentrentingdata['searchpropertylist'];
		        		$success['total']=(int)$recentrentingdata['total'];
						$success['page']=(int)$recentrentingdata['page'];
						$success['last_page']=(int)$recentrentingdata['last_page'];
	            		return $this::sendResponse($success, 'Nearby Properties List.');
		        	}
		        	else{
		        		return $this::sendError('Unauthorised Exception.', ['error'=>$recentrentingdata['message']]);
		        	}
                }
	        }
	        else{
	        	//guest user api

	        	if($lat!="" && $lng!="")
                {
                	$nearbyrentingdata=$this->get_nearby_renting_list($lat,$lng,$property_type,$userid="",$page,$sort_by,$check_in_date,$check_out_date,$adult_count,$children_count);
		        	if($nearbyrentingdata['code']==200)
		        	{
		        		$success['property_list'] =  $nearbyrentingdata['searchpropertylist'];
		        		$success['total']=(int)$nearbyrentingdata['total'];
						$success['page']=(int)$nearbyrentingdata['page'];
						$success['last_page']=(int)$nearbyrentingdata['last_page'];
	            		return $this::sendResponse($success, 'Nearby Properties List.');
		        	}
		        	else{
		        		return $this::sendError('Unauthorised Exception.', ['error'=>$nearbyrentingdata['message']]);
		        	}
                }
                else{
                	$recentrentingdata=$this->get_recent_renting_list($property_type,$userid="",$page,$sort_by,$check_in_date,$check_out_date,$adult_count,$children_count);
		        	if($recentrentingdata['code']==200)
		        	{
		        		$success['property_list'] =  $recentrentingdata['searchpropertylist'];
		        		$success['total']=(int)$recentrentingdata['total'];
						$success['page']=(int)$recentrentingdata['page'];
						$success['last_page']=(int)$recentrentingdata['last_page'];
	            		return $this::sendResponse($success, 'Nearby Properties List.');
		        	}
		        	else{
		        		return $this::sendError('Unauthorised Exception.', ['error'=>$recentrentingdata['message']]);
		        	}
                }
	        }
	}
	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
}



public function get_nearby_renting_list($lat,$lng,$property_type,$userid,$page,$sort_by,$check_in_date,$check_out_date,$adult_count,$children_count)
{
	$searchpropertyquery=Property::where('property_status',1)->where('property_type',$property_type);

	if(isset($adult_count) && $adult_count!="")
	{
		$searchpropertyquery=$searchpropertyquery->where('guest_count','>=',$adult_count);
	}

	$perPage = 2;
    $total = $searchpropertyquery->count();
    $last_page=ceil($total / $perPage);

    if($sort_by==1)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_price', 'ASC');
    }
    elseif($sort_by==2)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_price', 'DESC');
    }
    elseif($sort_by==3)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('id', 'DESC');
    }
    elseif($sort_by==4)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_rating', 'ASC');
    }
    elseif($sort_by==5)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_rating', 'DESC');
    }
    else{
    	$searchpropertyquery=$searchpropertyquery->orderBy('id', 'DESC');
    }

    $searchpropertylist = $searchpropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

    if($searchpropertylist)
    {
    	$searchlistarr=$searchpropertylist->toArray();
    	$searchpropertylistarr=[];
    	foreach($searchlistarr as $list)
    	{
    		if($list['property_image']!="")
	        {
	        	$property_image=url('/').'/property/'.$list['property_image'];
	        }
	        else{
	        	$property_image=url('/').'/no_image/user.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list['id']);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite
				);
	        }
    	}

    	if(count($searchpropertylistarr) > 0)
		{
			$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>(int)$total,'page'=>(int)$page,'last_page'=>(int)$last_page);
			return $data;
		}
		else{
			$searchpropertylistarr=[];
    		$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0
    		);
			return $data;
		}
    }
    else{
    	$searchpropertylistarr=[];
    	$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0);
		return $data;
    }
}

public function get_recent_renting_list($property_type,$userid,$page,$sort_by,$check_in_date,$check_out_date,$adult_count,$children_count)
{
	$searchpropertyquery=Property::where('property_status',1)->where('property_type',$property_type);

	if(isset($adult_count) && $adult_count!="")
	{
		$searchpropertyquery=$searchpropertyquery->where('guest_count','>=',$adult_count);
	}

	$perPage = 2;
    $total = $searchpropertyquery->count();
    $last_page=ceil($total / $perPage);

    if($sort_by==1)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_price', 'ASC');
    }
    elseif($sort_by==2)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_price', 'DESC');
    }
    elseif($sort_by==3)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('id', 'DESC');
    }
    elseif($sort_by==4)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_rating', 'ASC');
    }
    elseif($sort_by==5)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('property_rating', 'DESC');
    }
    else{
    	$searchpropertyquery=$searchpropertyquery->orderBy('id', 'DESC');
    }

    $searchpropertylist = $searchpropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

    if($searchpropertylist)
    {
    	$searchlistarr=$searchpropertylist->toArray();
    	$searchpropertylistarr=[];
    	foreach($searchlistarr as $list)
    	{
    		if($list['property_image']!="")
	        {
	        	$property_image=url('/').'/property/'.$list['property_image'];
	        }
	        else{
	        	$property_image=url('/').'/no_image/user.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list['id']);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list['id'],
					'title'=>$list['title'],
					'property_address'=>$list['property_address'],
					'property_image'=>$property_image,
					'property_price'=>$list['property_price'],
					'property_date'=>date('d M Y',strtotime($list['created_at'])),
					'property_bedrooms'=>$list['no_of_bedroom'],
					'property_description'=>$list['property_description'],
					'property_area'=>$list['property_area'],
					'favourite'=>$favourite
				);
	        }
    	}

    	if(count($searchpropertylistarr) > 0)
		{
			$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>(int)$total,'page'=>(int)$page,'last_page'=>(int)$last_page);
			return $data;
		}
		else{
			$searchpropertylistarr=[];
    		$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0
    		);
			return $data;
		}
    }
    else{
    	$searchpropertylistarr=[];
    	$data=array('code'=>200,'message'=>'success','searchpropertylist'=>$searchpropertylistarr,'total'=>0,'page'=>(int)$page,'last_page'=>0);
		return $data;
    }
}


public function getpropertybookingdetails()
{
	try{
		$validator = Validator::make($request->all(), [
		            'property_id' => 'required'
		        ]);

	        if($validator->fails()){
	            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
	        }

	        $property_id=$request->property_id;

	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	$getuserrentinglocation=Userrentinglocationsearch::where('user_id',$user->id)->where('status',1)->get()->first();
	        	if($getuserrentinglocation)
	        	{
	        		$user_location=$getuserrentinglocation->user_location;
	        		$user_latitude=$getuserrentinglocation->user_latitude;
	        		$user_longitude=$getuserrentinglocation->user_longitude;
	        		$user_checkin_date=$getuserrentinglocation->user_checkin_date;
	        		$user_checkout_date=$getuserrentinglocation->user_checkout_date;
	        		$user_adults_count=$getuserrentinglocation->user_adults_count;
	        		$user_children_count=$getuserrentinglocation->user_children_count;
	        	}
	        	else{
		        	$validator = Validator::make($request->all(), [
			            'location' => 'required',
			            'lat'=>'required',
			            'lng'=>'required',
			            'check_in_date'=>'required',
			            'check_out_date'=>'required',
			            'adult_count'=>'required',
			            'children_count'=>'required'
			        ]);

			        if($validator->fails()){
			            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
			        }

			        $user_location=$request->location;
	        		$user_latitude=$request->lat;
	        		$user_longitude=$request->lng;
	        		$user_checkin_date=$request->check_in_date;
	        		$user_checkout_date=$request->check_out_date;
	        		$user_adults_count=$request->adult_count;
	        		$user_children_count=$request->children_count;

	        	}

	        	

	        	$searcharray=array(
	        		'user_location'=>$user_location,
	        		'user_latitude'=>$user_latitude,
	        		'user_longitude'=>$user_longitude,
	        		'user_checkin_date'=>$user_checkin_date,
	        		'user_checkout_date'=>$user_checkout_date,
	        		'user_adults_count'=>$user_adults_count,
	        		'user_children_count'=>$user_children_count
	        	);
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	        }
	}
	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
}


public function insertnotification()
{
	$userslist=User::where('user_type','2')->where('status',1)->get();
	if($userslist)
	{
		$userslistarray=$userslist->toArray();
		$Notificationsarr=[];
		foreach($userslistarray as $list)
		{
			$Notificationsarr[]=array(
				'user_id'=>$list['id'],
				'notification_id'=>3,
				'notification_type'=>'admin',
				'is_read'=>0
			);
		}

		UserNotification::insert($Notificationsarr);

	}
}






}