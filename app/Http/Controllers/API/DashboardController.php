<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Property;
use App\Models\Category;
use App\Models\Userbuyinglocationsearch;
use App\Models\PropertyGallery;
use App\Models\FavProperty;
use App\Models\Notifications;
use App\Models\UserNotification;
use App\Models\Userrentinglocationsearch;
use App\Models\Usertempbooking;
use Validator;
use Hash;
use DB;

class DashboardController extends BaseController
{

	public function getstatelist(Request $request)
	{
		try{

		$validator = Validator::make($request->all(), [
	            'country_code' => 'required'
	        ]);

	        if($validator->fails()){
	            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
	        }

		    $country_code=$request->country_code;
		    if(isset($request->search) && $request->search!="")
		    {
		    	$search=$request->search;
		    }
		    else{
		    	$search="";
		    }

		    $checkcountrycode=DB::table('countries')->where('iso2',$country_code)->get()->first();
		    if($checkcountrycode)
		    {
		    	$countryid=$checkcountrycode->id;
		    	if($search!="")
		    	{
		    		$stateslist=DB::table('states')->where('country_id',$countryid)->where('name', 'like', '%'.$search.'%')->get();
		    	}
		    	else{
		    		$stateslist=DB::table('states')->where('country_id',$countryid)->get();
		    	}
		    	
		    	if($stateslist)
		    	{
		    		$stateslistarray=$stateslist->toArray();
		    		$stateslist_arr=[];
		    		foreach($stateslistarray as $list)
		    		{
		    			$stateslist_arr[]=array(
		    				'id'=>$list->id,
		    				'name'=>$list->name,
		    				'country_id'=>$list->country_id,
		    				'country_name'=>$checkcountrycode->name,
		    				'lat'=>$list->latitude,
		    				'lng'=>$list->longitude
		    			);
		    		}
		    	}
		    	else{
		    		$stateslist_arr=[];
		    	}

		    	$success['stateslist']=$stateslist_arr;
        		return $this::sendResponse($success, 'Property States List.');
		    }
		    else{
		    	return $this::sendError('Unauthorised Exception.', ['error'=>'Invalid Country.']);
		    }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
	}


	public function getcitylist(Request $request)
	{
		try{

		$validator = Validator::make($request->all(), [
	            'country_id' => 'required',
	            'state_id'=>'required'
	        ]);

	        if($validator->fails()){
	            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
	        }

		    $country_id=$request->country_id;
		    $state_id=$request->state_id;

		    if(isset($request->search) && $request->search!="")
		    {
		    	$search=$request->search;
		    }
		    else{
		    	$search="";
		    }

		    $checkcountry=DB::table('countries')->where('id',$country_id)->get()->first();
		    if($checkcountry)
		    {
		    	$checkcountrystate=DB::table('states')->where('id',$state_id)->where('country_id',$country_id)->get()->first();
		    	if($checkcountrystate)
		    	{
		    		

		    	if($search!="")
		    	{
		    		$citieslist=DB::table('cities')->where('country_id',$country_id)->where('state_id',$state_id)->where('name', 'like', '%'.$search.'%')->get();
		    	}
		    	else{
		    		$citieslist=DB::table('cities')->where('country_id',$country_id)->where('state_id',$state_id)->get();
		    	}

			    	if($citieslist)
			    	{
			    		$citieslistarray=$citieslist->toArray();
			    		$citieslist_arr=[];
			    		foreach($citieslistarray as $list)
			    		{
			    			$citieslist_arr[]=array(
			    				'id'=>$list->id,
			    				'name'=>$list->name,
			    				'country_id'=>$list->country_id,
			    				'state_id'=>$list->state_id,
			    				'country_name'=>$checkcountry->name,
			    				'state_name'=>$checkcountrystate->name,
			    				'lat'=>$list->latitude,
			    				'lng'=>$list->longitude
			    			);
			    		}
			    	}
			    	else{
			    		$citieslist_arr=[];
			    	}

			    	$success['citieslist']=$citieslist_arr;
            		return $this::sendResponse($success, 'Property Cities List.');
		    	}
		    	else{
		    		return $this::sendError('Unauthorised Exception.', ['error'=>'Invalid State.']);
		    	}
		    }
		    else{
		    	return $this::sendError('Unauthorised Exception.', ['error'=>'Invalid Country.']);
		    }
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong']);    
               }
	}

	public function getuserlocation(Request $request)
	{
		try{
	        $user = auth()->guard("api")->user();
	        if($user)
	        {
		        $userlocationsearchresult=Userbuyinglocationsearch::where('user_id',$user->id)->where('status',1)->get()->first();
		        if($userlocationsearchresult)
		        {
		        	$userlocationsearchresultarray=$userlocationsearchresult->toArray();

		        	$locationarray=array(
		        		'category'=>$userlocationsearchresultarray['user_category'],
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

		   	// $user = auth()->guard("api")->user();
	     //    if($user)
	     //    {
	     //    	//login user
	     //    	$final_category_arr = removeElementWithValue($final_category_arr, "id", 0);  	
	     //    }
	     //    else{
	     //    	//guest login
	     //    	$final_category_arr = removeElementWithValue($final_category_arr, "id", 7);   	
	     //    }
	        	
        	$success['categorylist']=$final_category_arr;
        	$success['minprice']=$minprice;
        	$success['maxprice']=$maxprice;
        	$success['minarea']=$minarea;
        	$success['maxarea']=$maxarea;

        	return $this::sendResponse($success, 'Property Category List.');
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
		        $userlocationsearchresult=Userbuyinglocationsearch::where('user_id',$user->id)->get();
		        if($userlocationsearchresult)
		        {
		        	$userlocationsearchresultarray=$userlocationsearchresult->toArray();

		        	if($userlocationsearchresultarray)
		        	{
		        		Userbuyinglocationsearch::where('user_id',$user->id)->update(['status' => 0]);
		        	}
		        }

                $userlocation = new Userbuyinglocationsearch;
                $userlocation->user_id=$user->id;
                $userlocation->user_category=$property_category;
                $userlocation->user_location = $request->location;
                $userlocation->user_latitude = $lat;
                $userlocation->user_longitude = $lng;
                $userlocation->status=1;
                $userlocation->save();

                if($lat!="" && $lng!="")
                {
                	$nearbypropertylist=$this->gethomenearbyproperties($lat,$lng,$user->id,$property_type,$property_category);

                	$recently_added_properties=$this->gethomerecentlyaddedproperties($lat,$lng,$user->id,$property_type,$property_category);
                }
                else{
                	$nearbypropertylist=$this->gethomenearbyproperties($lat="",$lng="",$user->id,$property_type,$property_category);

                	$recently_added_properties=$this->gethomerecentlyaddedproperties($lat="",$lng="",$user->id,$property_type,$property_category);
                }

                $success['nearby'] =  $nearbypropertylist;
                $success['recently_added'] =  $recently_added_properties;
                $success['property_type']=$property_type;
            	return $this::sendResponse($success, 'Properties List.');

	        }
	        else{

	        	// guest login

		        if($lat!="" && $lng!="")
                {
                	$nearbypropertylist=$this->gethomenearbyproperties($lat,$lng,$userid="",$property_type,$property_category);

                	$recently_added_properties=$this->gethomerecentlyaddedproperties($lat,$lng,$userid="",$property_type,$property_category);

                }
                else{
                	$nearbypropertylist=$this->gethomenearbyproperties($lat="",$lng="",$userid="",$property_type,$property_category);

                	$recently_added_properties=$this->gethomerecentlyaddedproperties($lat="",$lng="",$userid="",$property_type,$property_category);

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


public function gethomenearbyproperties($lat,$lng,$userid,$property_type,$property_category)
{
	$radiusvalue=getdistanceradiusvalue();
	if($property_category!=0)
	{
		if($lat!="" && $lng!="")
		{
			$nearbypropertylist = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->WHERE('tbl_pr.property_category',$property_category)
            ->orderBy('distance')
            ->having('distance', '<=', $radiusvalue)
            ->limit(10)
            ->get();
		}
		else{
			$nearbypropertylist = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->WHERE('tbl_pr.property_category',$property_category)
            ->orderBy('id','DESC')
            ->limit(10)
            ->get();
		}
		

	}
	else{
		if($lat!="" && $lng!="")
		{
			$nearbypropertylist = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->orderBy('distance')
            ->having('distance', '<=', $radiusvalue)
            ->limit(10)
           	->get();
		}
		else{
			$nearbypropertylist = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->orderBy('id','DESC')
            ->limit(10)
            ->get();
		}
	}
	
	if($nearbypropertylist)
	{
		$nearbylistarr=$nearbypropertylist->toArray();

		$nearbypropertylistarr=[];
		foreach($nearbylistarr as $list)
		{

			if($list->property_image!="")
	        {
	        	$property_image=url('/').'/images/property/thumbnail/'.$list->property_image;
	        }
	        else{
	        	$property_image=url('/').'/no_image/property.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list->id);
	        }
	        else{
	        	$favourite=0;
	        }
	        

	        if($property_type==1)
	        {
		        $nearbypropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        	$nearbypropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'favourite'=>$favourite
				);
	        }

	        // if($userid!="")
	        // {
	        // 	//login user
	        // 	$nearbypropertylistarr = removeElementWithKey($nearbypropertylistarr, "favourite");

	        // 	$nearbypropertylistarr = AddElementtoarray($nearbypropertylistarr, "new_key",12);	
	        // }
	        // else{
	        // 	//guest login  

	        // 	$nearbypropertylistarr = removeElementWithKey($nearbypropertylistarr, "property_date");	
	        // }
			
		}
	}
	else{
		$nearbypropertylistarr=[];
	}

	return $nearbypropertylistarr;
}

public function gethomerecentlyaddedproperties($lat,$lng,$userid,$property_type,$property_category)
{
	$radiusvalue=getdistanceradiusvalue();
	if($property_category!=0)
	{
		if($lat!="" && $lng!="")
		{
			$recentlyaddedpropertylist = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->WHERE('tbl_pr.property_category',$property_category)
            ->orderBy('publish_date','DESC')
            ->having('distance', '<=', $radiusvalue)
            ->limit(10)
            ->get();
		}
		else{
			$recentlyaddedpropertylist = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->WHERE('tbl_pr.property_category',$property_category)
            ->orderBy('publish_date','DESC')
            ->limit(10)
            ->get();
		}
	}
	else{
		if($lat!="" && $lng!="")
		{
			$recentlyaddedpropertylist = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->orderBy('publish_date','DESC')
            ->having('distance', '<=', $radiusvalue)
            ->limit(10)
            ->get();
		}
		else{
			$recentlyaddedpropertylist = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->orderBy('publish_date','DESC')
            ->limit(10)
            ->get();
		}
		

	}
	
	if($recentlyaddedpropertylist)
	{
		$recentlyaddedlistarr=$recentlyaddedpropertylist->toArray();

		$recentlyaddedpropertylistarr=[];
		foreach($recentlyaddedlistarr as $list)
		{

			if($list->property_image!="")
	        {
	        	$property_image=url('/').'/images/property/thumbnail/'.$list->property_image;
	        }
	        else{
	        	$property_image=url('/').'/no_image/property.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list->id);
	        }
	        else{
	        	$favourite=0;
	        }
	        

	        if($property_type==1)
	        {
		        $recentlyaddedpropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'property_bedrooms'=>$list->no_of_bedroom,
					'property_description'=>$list->property_description,
					'property_area'=>$list->property_area,
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        	$recentlyaddedpropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'property_bedrooms'=>$list->no_of_bedroom,
					'property_description'=>$list->property_description,
					'property_area'=>$list->property_area,
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

        if(isset($request->recent_ids) && $request->recent_ids!="")
        {
        	$recent_ids=$request->recent_ids;
        }
        else{
        	$recent_ids="";
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
	        	if($lat!="" && $lng!="")
	        	{
	        		$nearbypropertydata=$this->get_nearby_properties_list($lat,$lng,$property_type,$property_category,$user->id,$page,$sort_by,$recent_ids);
	        	}
	        	else{
	        		$nearbypropertydata=$this->get_nearby_properties_list($lat="",$lng="",$property_type,$property_category,$user->id,$page,$sort_by,$recent_ids);
	        	}
		    }
		    else{
		    	//guest login api
		    	if($lat!="" && $lng!="")
	        	{
	        		$nearbypropertydata=$this->get_nearby_properties_list($lat,$lng,$property_type,$property_category,$userid="",$page,$sort_by,$recent_ids);
	        	}
	        	else{
	        		$nearbypropertydata=$this->get_nearby_properties_list($lat="",$lng="",$property_type,$property_category,$userid="",$page,$sort_by,$recent_ids);
	        	}
		    }

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
		catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
}


public function get_nearby_properties_list($lat,$lng,$property_type,$property_category,$userid,$page,$sort_by,$recent_ids)
{
	$radiusvalue=getdistanceradiusvalue();
	if($property_category!=0)
	{
		if($lat!="" && $lng!="")
		{
			$nearbypropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->WHERE('tbl_pr.property_category',$property_category);
		}
		else{
			$nearbypropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->WHERE('tbl_pr.property_category',$property_category);
		}
	}
	else{
		if($lat!="" && $lng!="")
		{
			$nearbypropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type);
		}
		else{
			$nearbypropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type);
		}
		

	}

    if($sort_by==1)
    {
    	$nearbypropertyquery=$nearbypropertyquery->orderBy('tbl_pr.property_price', 'ASC');
    }
    elseif($sort_by==2)
    {
    	$nearbypropertyquery=$nearbypropertyquery->orderBy('tbl_pr.property_price', 'DESC');
    }
    elseif($sort_by==3)
    {
    	$nearbypropertyquery=$nearbypropertyquery->orderBy('tbl_pr.id', 'DESC');
    }
    elseif($sort_by==4)
    {
    	$nearbypropertyquery=$nearbypropertyquery->orderBy('tbl_pr.property_rating', 'ASC');
    }
    elseif($sort_by==5)
    {
    	$nearbypropertyquery=$nearbypropertyquery->orderBy('tbl_pr.property_rating', 'DESC');
    }
    else{
    	if($lat!="" && $lng!="")
    	{
    		$nearbypropertyquery=$nearbypropertyquery->orderBy('distance');
    	}
    	else{
    		$nearbypropertyquery=$nearbypropertyquery->orderBy('tbl_pr.id','DESC');
    	}
    }

    if($lat!="" && $lng!="")
    {
    	$nearbypropertyquery=$nearbypropertyquery->having('distance', '<=', $radiusvalue);
    }

    $perPage = 4;
    $total = $nearbypropertyquery->count();
    $last_page=ceil($total / $perPage);
    
    $nearbypropertylist = $nearbypropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();
    if($nearbypropertylist)
    {
    	$nearbylistarr=$nearbypropertylist->toArray();
    	$nearbypropertylistarr=[];
		foreach($nearbylistarr as $list)
		{
			if($list->property_image!="")
	        {
	        	$property_image=url('/').'/images/property/thumbnail/'.$list->property_image;
	        }
	        else{
	        	$property_image=url('/').'/no_image/property.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list->id);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $nearbypropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'favourite'=>$favourite,
					'rating'=>5,
					'property_bedrooms'=>$list->no_of_bedroom,
					'property_description'=>$list->property_description,
					'property_area'=>$list->property_area
				);
	        }
	        else{
		        	$nearbypropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'favourite'=>$favourite,
					'property_bedrooms'=>$list->no_of_bedroom,
					'property_description'=>$list->property_description,
					'property_area'=>$list->property_area
				);
	        }	        
		}

		if($recent_ids!="")
		{
			$nearbypropertylistarr=$this->getpagerecentidsdata($nearbypropertylistarr,$recent_ids,$userid,$property_type);
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

public function getpagerecentidsdata($nearbypropertylistarr,$recent_ids,$userid,$property_type)
{
	if($recent_ids!="")
	{
		$recentidsarray=explode(',',$recent_ids);
		$recent_ids_list=[];
		foreach($recentidsarray as $list)
		{
			$recentidproperty = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.id',$list)->get()->first();

            if($recentidproperty->property_image!="")
	        {
	        	$property_image=url('/').'/images/property/thumbnail/'.$recentidproperty->property_image;
	        }
	        else{
	        	$property_image=url('/').'/no_image/property.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$recentidproperty->id);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $recent_ids_list[]=array(
		        	'property_id'=>$recentidproperty->id,
					'title'=>$recentidproperty->title,
					'property_address'=>$recentidproperty->property_address,
					'property_image'=>$property_image,
					'property_price'=>$recentidproperty->property_price,
					'property_date'=>date('d M Y',strtotime($recentidproperty->created_at)),
					'favourite'=>$favourite,
					'rating'=>5,
					'property_bedrooms'=>$recentidproperty->no_of_bedroom,
					'property_description'=>$recentidproperty->property_description,
					'property_area'=>$recentidproperty->property_area
				);
	        }
	        else{
		        	$recent_ids_list[]=array(
		        	'property_id'=>$recentidproperty->id,
					'title'=>$recentidproperty->title,
					'property_address'=>$recentidproperty->property_address,
					'property_image'=>$property_image,
					'property_price'=>$recentidproperty->property_price,
					'property_date'=>date('d M Y',strtotime($recentidproperty->created_at)),
					'favourite'=>$favourite,
					'property_bedrooms'=>$recentidproperty->no_of_bedroom,
					'property_description'=>$recentidproperty->property_description,
					'property_area'=>$recentidproperty->property_area
				);
	        }

		}

		$finalnearbypropertylistarr=array_merge($recent_ids_list,$nearbypropertylistarr);
		return $finalnearbypropertylistarr;
	}
	else{
		return $nearbypropertylistarr;
	}
}


public function getrecentlyaddeddpropertylist(Request $request)
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

	        	if($lat!="" && $lng!="")
	        	{
	        		$recentlypropertydata=$this->get_recentlyadded_properties_list($lat,$lng,$property_type,$property_category,$user->id,$page,$sort_by);
	        	}
	        	else{
	        		$recentlypropertydata=$this->get_recentlyadded_properties_list($lat="",$lng="",$property_type,$property_category,$user->id,$page,$sort_by);
	        	}
	        	   
	        }
	        else{
	        	//guest login api
	        	if($lat!="" && $lng!="")
	        	{
	        		$recentlypropertydata=$this->get_recentlyadded_properties_list($lat,$lng,$property_type,$property_category,$userid="",$page,$sort_by);
	        	}
	        	else{
	        		$recentlypropertydata=$this->get_recentlyadded_properties_list($lat="",$lng="",$property_type,$property_category,$userid="",$page,$sort_by);
	        	}
	        }

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
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
}

public function get_recentlyadded_properties_list($lat,$lng,$property_type,$property_category,$userid,$page,$sort_by)
{
	$radiusvalue=getdistanceradiusvalue();
	if($property_category!=0)
	{
		if($lat!="" && $lng!="")
		{
			$recentlypropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
                ->WHERE('tbl_pr.property_status','1')
                ->WHERE('tbl_pr.property_type',$property_type)
                ->WHERE('tbl_pr.property_category',$property_category);
		}
		else{
			$recentlypropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->WHERE('tbl_pr.property_category',$property_category);
		}
	}
	else{
		if($lat!="" && $lng!="")
		{
			$recentlypropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type);
		}
		else{
			$recentlypropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type);
		}
		

	}

    if($sort_by==1)
    {
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('tbl_pr.property_price', 'ASC');
    }
    elseif($sort_by==2)
    {
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('tbl_pr.property_price', 'DESC');
    }
    elseif($sort_by==3)
    {
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('tbl_pr.id', 'DESC');
    }
    elseif($sort_by==4)
    {
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('tbl_pr.property_rating', 'ASC');
    }
    elseif($sort_by==5)
    {
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('tbl_pr.property_rating', 'DESC');
    }
    else{
    	$recentlypropertyquery=$recentlypropertyquery->orderBy('tbl_pr.publish_date', 'DESC');
    }

    if($lat!="" && $lng!="")
    {
    	$recentlypropertyquery=$recentlypropertyquery->having('distance', '<=', $radiusvalue);
    }

    $perPage = 4;
    $total = $recentlypropertyquery->count();
    $last_page=ceil($total / $perPage);

    $recentlypropertylist = $recentlypropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

    if($recentlypropertylist)
    {
    	$recentlylistarr=$recentlypropertylist->toArray();
    	$recentlypropertylistarr=[];
    	foreach($recentlylistarr as $list)
    	{
    		if($list->property_image!="")
	        {
	        	$property_image=url('/').'/images/property/thumbnail/'.$list->property_image;
	        }
	        else{
	        	$property_image=url('/').'/no_image/property.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list->id);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $recentlypropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'property_bedrooms'=>$list->no_of_bedroom,
					'property_description'=>$list->property_description,
					'property_area'=>$list->property_area,
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        $recentlypropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'property_bedrooms'=>$list->no_of_bedroom,
					'property_description'=>$list->property_description,
					'property_area'=>$list->property_area,
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
		        	$property_image=url('/').'/images/property/thumbnail/'.$checkpropertyarray['property_image'];
		        }
		        else{
		        	$property_image=url('/').'/no_image/property.jpg';
		        }

				array_push($property_gallery,$property_image);
			}

			$checkpropertycategory=Category::where('category_type',$checkpropertyarray['property_type'])->where('id',$checkpropertyarray['property_category'])->get()->first();
			if($checkpropertycategory)
			{
				$property_category=$checkpropertycategory->name;
			}
			else{
				$property_category='-';
			}

			$checkpropertycondition=DB::table('property_condition')->where('id',$checkpropertyarray['property_condition'])->get()->first();
			if($checkpropertycondition)
			{
				$property_condition=$checkpropertycondition->name;
			}
			else{
				$property_condition='-';
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
				'property_condition'=>$property_condition,
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
	    	$publish_date=date('Y-m-d',strtotime($request->publish_date));
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

	    //floor count
	    //1 : 1
	    //2:  2
	    //3:  3
	    //4:  4
	    //5+: 5

	    if(isset($request->floor_count) && $request->floor_count!="")
	    {
	    	$floor_count=$request->floor_count;
	    }
	    else{
	    	$floor_count="";
	    }

	    if(isset($request->condition) && $request->condition!="")
	    {
	    	$condition=$request->condition;
	    }
	    else{
	    	$condition="";
	    }

	    $user = auth()->guard("api")->user();
        if($user)
        {
        	//user login api
        	if($list_type=="nearBy")
        	{
        		if($lat!="" && $lng!="")
        		{
        			$nearbyfilterpropertydata=$this->get_nearby_filter_properties_list($property_type,$user->id,$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$floor_count,$condition,$lat,$lng);
        		}
        		else{
        			$nearbyfilterpropertydata=$this->get_nearby_filter_properties_list($property_type,$user->id,$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$floor_count,$condition,$lat="",$lng="");
        		}
        		
        	}
        	else{
        		if($lat!="" && $lng!="")
        		{
        			$recentfilterpropertydata=$this->get_recently_filter_properties_list($property_type,$user->id,$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$floor_count,$condition,$lat,$lng);
        		}
        		else{
        			$recentfilterpropertydata=$this->get_recently_filter_properties_list($property_type,$user->id,$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$floor_count,$condition,$lat="",$lng="");
        		}
        	}   
        }
        else{
        	//guest login api

        	if($list_type=="nearBy")
        	{
        		if($lat!="" && $lng!="")
        		{
        			$nearbyfilterpropertydata=$this->get_nearby_filter_properties_list($property_type,$userid="",$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$floor_count,$condition,$lat,$lng);
        		}
        		else{
        			$nearbyfilterpropertydata=$this->get_nearby_filter_properties_list($property_type,$userid="",$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$floor_count,$condition,$lat="",$lng="");
        		}
        		
        	}
        	else{
        		if($lat!="" && $lng!="")
        		{
        			$recentfilterpropertydata=$this->get_recently_filter_properties_list($property_type,$userid="",$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$floor_count,$condition,$lat,$lng);
        		}
        		else{
        			$recentfilterpropertydata=$this->get_recently_filter_properties_list($property_type,$userid="",$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$floor_count,$condition,$lat="",$lng="");
        		}
        	}
        }

       	if(isset($nearbyfilterpropertydata) && $nearbyfilterpropertydata!="")
       	{
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
        
       	if(isset($recentfilterpropertydata) && $recentfilterpropertydata!="")
       	{
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
    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }


    }

    public function get_nearby_filter_properties_list($property_type,$userid,$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$floor_count,$condition,$lat,$lng)
    {
    	$radiusvalue=getdistanceradiusvalue();
    	if($lat!="" && $lng!="")
		{
			$filterpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
                ->WHERE('tbl_pr.property_status','1')
                ->WHERE('tbl_pr.property_type',$property_type);
		}
		else{
			$filterpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type);
		}

		if(isset($category) && $category!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.property_category',$category);
    	}

    	if(isset($min_price) && $min_price!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.property_price','>=',$min_price);
    	}

    	if(isset($max_price) && $max_price!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.property_price','<=',$max_price);
    	}

    	if(isset($min_area) && $min_area!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.property_area','>=',$min_area);
    	}

    	if(isset($max_area) && $max_area!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.property_area','<=',$max_area);
    	}

    	if(isset($publish_date) && $publish_date!="")
    	{
    		$new_publish_date=date('Y-m-d',strtotime($publish_date));
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.publish_date',$new_publish_date);
    	}

    	if(isset($bed_count) && $bed_count!="")
    	{
    		if($bed_count==1)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==2)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==3)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==4)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_bedroom','>=',$bed_count);
    		}
    	}

    	if(isset($floor_count) && $floor_count!="")
    	{
    		if($floor_count==1)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_floors',$floor_count);
    		}
    		elseif($floor_count==2)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_floors',$floor_count);
    		}
    		elseif($floor_count==3)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_floors',$floor_count);
    		}
    		elseif($floor_count==4)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_floors',$floor_count);
    		}
    		elseif($floor_count==5)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_floors','>=',$floor_count);
    		}
    	}

    	if(isset($built_year) && $built_year!="")
    	{
    		$new_built_year=date('Y-m',strtotime($built_year));
    		$filterpropertyquery=$filterpropertyquery->where('built_in_year',$new_built_year);
    	}

    	if(isset($condition) && $condition!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_condition',$condition);
    	}

	   	if($sort_by==1)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.property_price', 'ASC');
	    }
	    elseif($sort_by==2)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.property_price', 'DESC');
	    }
	    elseif($sort_by==3)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.id', 'DESC');
	    }
	    elseif($sort_by==4)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.property_rating', 'ASC');
	    }
	    elseif($sort_by==5)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.property_rating', 'DESC');
	    }
	    else{
	    	if($lat!="" && $lng!="")
	    	{
	    		$filterpropertyquery=$filterpropertyquery->orderBy('distance');
	    	}
	    	else{
	    		$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.id', 'DESC');
	    	}
	    	
	    }

	    if($lat!="" && $lng!="")
	    {
	    	$filterpropertyquery=$filterpropertyquery->having('distance', '<=', $radiusvalue);
	    }

	    $perPage = 4;
	    $total = $filterpropertyquery->count();
	    $last_page=ceil($total / $perPage);

	    $filterpropertylist = $filterpropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

	    if($filterpropertylist)
	    {
	    	$filterlistarr=$filterpropertylist->toArray();
	    	$filterpropertylistarr=[];
	    	foreach($filterlistarr as $list)
	    	{
	    		if($list->property_image!="")
		        {
		        	$property_image=url('/').'/images/property/thumbnail/'.$list->property_image;
		        }
		        else{
		        	$property_image=url('/').'/no_image/property.jpg';
		        }

		        if($userid!="")
		        {
		        	$favourite=checkfavproperty($userid,$list->id);
		        }
		        else{
		        	$favourite=0;
		        }

		        if($property_type==1)
		        {
			        $filterpropertylistarr[]=array(
			        	'property_id'=>$list->id,
						'title'=>$list->title,
						'property_address'=>$list->property_address,
						'property_image'=>$property_image,
						'property_price'=>$list->property_price,
						'property_date'=>date('d M Y',strtotime($list->created_at)),
						'property_bedrooms'=>$list->no_of_bedroom,
						'property_description'=>$list->property_description,
						'property_area'=>$list->property_area,
						'favourite'=>$favourite,
						'rating'=>5
					);
		        }
		        else{
			        $filterpropertylistarr[]=array(
			        	'property_id'=>$list->id,
						'title'=>$list->title,
						'property_address'=>$list->property_address,
						'property_image'=>$property_image,
						'property_price'=>$list->property_price,
						'property_date'=>date('d M Y',strtotime($list->created_at)),
						'property_bedrooms'=>$list->no_of_bedroom,
						'property_description'=>$list->property_description,
						'property_area'=>$list->property_area,
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

    public function get_recently_filter_properties_list($property_type,$userid,$page,$sort_by,$category,$min_price,$max_price,$min_area,$max_area,$publish_date,$bed_count,$built_year,$floor_count,$condition,$lat,$lng)
    {
    	$radiusvalue=getdistanceradiusvalue();
    	if($lat!="" && $lng!="")
		{
			$filterpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
                ->WHERE('tbl_pr.property_status','1')
                ->WHERE('tbl_pr.property_type',$property_type);
		}
		else{
			$filterpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type);
		}

		if(isset($category) && $category!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.property_category',$category);
    	}

    	if(isset($min_price) && $min_price!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.property_price','>=',$min_price);
    	}

    	if(isset($max_price) && $max_price!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.property_price','<=',$max_price);
    	}

    	if(isset($min_area) && $min_area!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.property_area','>=',$min_area);
    	}

    	if(isset($max_area) && $max_area!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.property_area','<=',$max_area);
    	}

    	if(isset($publish_date) && $publish_date!="")
    	{
    		$new_publish_date=date('Y-m-d',strtotime($publish_date));
    		$filterpropertyquery=$filterpropertyquery->where('tbl_pr.publish_date',$new_publish_date);
    	}

    	if(isset($bed_count) && $bed_count!="")
    	{
    		if($bed_count==1)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==2)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==3)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_bedroom',$bed_count);
    		}
    		elseif($bed_count==4)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_bedroom','>=',$bed_count);
    		}
    	}

    	if(isset($floor_count) && $floor_count!="")
    	{
    		if($floor_count==1)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_floors',$floor_count);
    		}
    		elseif($floor_count==2)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_floors',$floor_count);
    		}
    		elseif($floor_count==3)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_floors',$floor_count);
    		}
    		elseif($floor_count==4)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_floors',$floor_count);
    		}
    		elseif($floor_count==5)
    		{
    			$filterpropertyquery=$filterpropertyquery->where('tbl_pr.no_of_floors','>=',$floor_count);
    		}
    	}

    	if(isset($built_year) && $built_year!="")
    	{
    		$new_built_year=date('Y-m',strtotime($built_year));
    		$filterpropertyquery=$filterpropertyquery->where('built_in_year',$new_built_year);
    	}

    	if(isset($condition) && $condition!="")
    	{
    		$filterpropertyquery=$filterpropertyquery->where('property_condition',$condition);
    	}

	   	if($sort_by==1)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.property_price', 'ASC');
	    }
	    elseif($sort_by==2)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.property_price', 'DESC');
	    }
	    elseif($sort_by==3)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.id', 'DESC');
	    }
	    elseif($sort_by==4)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.property_rating', 'ASC');
	    }
	    elseif($sort_by==5)
	    {
	    	$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.property_rating', 'DESC');
	    }
	    else{
	    	$filterpropertyquery=$filterpropertyquery->orderBy('tbl_pr.publish_date', 'DESC');
	    }

	    if($lat!="" && $lng!="")
	    {
	    	$filterpropertyquery=$filterpropertyquery->having('distance', '<=', $radiusvalue);
	    }

	    $perPage = 4;
	    $total = $filterpropertyquery->count();
	    $last_page=ceil($total / $perPage);

	    $filterpropertylist = $filterpropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

	    if($filterpropertylist)
	    {
	    	$filterlistarr=$filterpropertylist->toArray();
	    	$filterpropertylistarr=[];
	    	foreach($filterlistarr as $list)
	    	{
	    		if($list->property_image!="")
		        {
		        	$property_image=url('/').'/images/property/thumbnail/'.$list->property_image;
		        }
		        else{
		        	$property_image=url('/').'/no_image/property.jpg';
		        }

		        if($userid!="")
		        {
		        	$favourite=checkfavproperty($userid,$list->id);
		        }
		        else{
		        	$favourite=0;
		        }

		        if($property_type==1)
		        {
			        $filterpropertylistarr[]=array(
			        	'property_id'=>$list->id,
						'title'=>$list->title,
						'property_address'=>$list->property_address,
						'property_image'=>$property_image,
						'property_price'=>$list->property_price,
						'property_date'=>date('d M Y',strtotime($list->created_at)),
						'property_bedrooms'=>$list->no_of_bedroom,
						'property_description'=>$list->property_description,
						'property_area'=>$list->property_area,
						'favourite'=>$favourite,
						'rating'=>5
					);
		        }
		        else{
			        $filterpropertylistarr[]=array(
			        	'property_id'=>$list->id,
						'title'=>$list->title,
						'property_address'=>$list->property_address,
						'property_image'=>$property_image,
						'property_price'=>$list->property_price,
						'property_date'=>date('d M Y',strtotime($list->created_at)),
						'property_bedrooms'=>$list->no_of_bedroom,
						'property_description'=>$list->property_description,
						'property_area'=>$list->property_area,
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


	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	//user login api
	        	if($lat!="" && $lng!="")
	        	{
	        		$searchpropertydata=$this->get_search_properties_list($property_type,$property_category,$user->id,$page,$sort_by,$search,$lat,$lng);
		        	
	        	}
	        	else{
	        		$searchpropertydata=$this->get_search_properties_list($property_type,$property_category,$user->id,$page,$sort_by,$search,$lat="",$lng="");
	        	}
                
	        }
	        else{
	        	//guest login api

	        	if($lat!="" && $lng!="")
	        	{
	        		$searchpropertydata=$this->get_search_properties_list($property_type,$property_category,$userid="",$page,$sort_by,$search,$lat,$lng);
	        	}
	        	else{
	        		$searchpropertydata=$this->get_search_properties_list($property_type,$property_category,$userid="",$page,$sort_by,$search,$lat="",$lng="");
	        	}

	        }

	        if($searchpropertydata['code']==200)
        	{
        		$success['property_list'] =  $searchpropertydata['searchpropertylist'];
        		$success['total']=(int)$searchpropertydata['total'];
				$success['page']=(int)$searchpropertydata['page'];
				$success['last_page']=(int)$searchpropertydata['last_page'];
        		return $this::sendResponse($success, 'Search Properties List.');
        	}
        	else{
        		return $this::sendError('Unauthorised Exception.', ['error'=>$searchpropertydata['message']]);
        	}
	    }
	    catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>'Something went wrong.']);    
               }
}

public function get_search_properties_list($property_type,$property_category,$userid,$page,$sort_by,$search,$lat,$lng)
{
	$radiusvalue=getdistanceradiusvalue();
	if($property_category!=0)
	{
		if($lat!="" && $lng!="")
		{
			$searchpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->WHERE('tbl_pr.property_category',$property_category);
		}
		else{
			$searchpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->WHERE('tbl_pr.property_category',$property_category);
		}
	}
	else{
		if($lat!="" && $lng!="")
		{
			$searchpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type);
		}
		else{
			$searchpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type);
		}
	}

	if(isset($search) && $search!="")
	{
		$searchpropertyquery=$searchpropertyquery->where('title', 'LIKE', '%' .$search . '%');
	}

	if($sort_by==1)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.property_price', 'ASC');
    }
    elseif($sort_by==2)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.property_price', 'DESC');
    }
    elseif($sort_by==3)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.id', 'DESC');
    }
    elseif($sort_by==4)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.property_rating', 'ASC');
    }
    elseif($sort_by==5)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.property_rating', 'DESC');
    }
    else{
    	if($lat!="" && $lng!="")
    	{
    		$searchpropertyquery=$searchpropertyquery->orderBy('distance');
    	}
    	else{
    		$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.publish_date','DESC');
    	}
    }

    if($lat!="" && $lng!="")
    {
    	$searchpropertyquery=$searchpropertyquery->having('distance', '<=', $radiusvalue);
    }

    $perPage = 4;
    $total = $searchpropertyquery->count();
    $last_page=ceil($total / $perPage);

    $searchpropertylist = $searchpropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

    if($searchpropertylist)
    {
    	$searchlistarr=$searchpropertylist->toArray();
    	$searchpropertylistarr=[];
    	foreach($searchlistarr as $list)
    	{
    		if($list->property_image!="")
	        {
	        	$property_image=url('/').'/images/property/thumbnail/'.$list->property_image;
	        }
	        else{
	        	$property_image=url('/').'/no_image/property.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list->id);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'property_bedrooms'=>$list->no_of_bedroom,
					'property_description'=>$list->property_description,
					'property_area'=>$list->property_area,
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'property_bedrooms'=>$list->no_of_bedroom,
					'property_description'=>$list->property_description,
					'property_area'=>$list->property_area,
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

	        if(isset($request->check_in_date) && $request->check_in_date!="")
	        {
	        	$check_in_date=date('Y-m-d',strtotime($request->check_in_date));
	        }
	        else{
	        	$check_in_date="";
	        }

	        if(isset($request->check_out_date) && $request->check_out_date!="")
	        {
	        	$check_out_date=date('Y-m-d',strtotime($request->check_out_date));
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
                $userlocation->user_category=$property_category;
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
                	$searchrentingdata=$this->get_search_property_renting_list($lat,$lng,$property_type,$property_category,$user->id,$page,$sort_by,$check_in_date,$check_out_date,$adult_count,$children_count);
                }
                else{
                	$searchrentingdata=$this->get_search_property_renting_list($lat="",$lng="",$property_type,$property_category,$user->id,$page,$sort_by,$check_in_date,$check_out_date,$adult_count,$children_count);
                }
	        }
	        else{
	        	//guest user api

	        	if($lat!="" && $lng!="")
                {
                	$searchrentingdata=$this->get_search_property_renting_list($lat,$lng,$property_type,$property_category,$userid="",$page,$sort_by,$check_in_date,$check_out_date,$adult_count,$children_count);
                }
                else{
                	$searchrentingdata=$this->get_search_property_renting_list($lat="",$lng="",$property_type,$property_category,$userid="",$page,$sort_by,$check_in_date,$check_out_date,$adult_count,$children_count);
                }
	        }

	        if($searchrentingdata['code']==200)
        	{
        		$success['property_list'] =  $searchrentingdata['searchpropertylist'];
        		$success['total']=(int)$searchrentingdata['total'];
				$success['page']=(int)$searchrentingdata['page'];
				$success['last_page']=(int)$searchrentingdata['last_page'];
        		return $this::sendResponse($success, 'Search Renting Properties List.');
        	}
        	else{
        		return $this::sendError('Unauthorised Exception.', ['error'=>$searchrentingdata['message']]);
        	}
	}
	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
}



public function get_search_property_renting_list($lat,$lng,$property_type,$property_category,$userid,$page,$sort_by,$check_in_date,$check_out_date,$adult_count,$children_count)
{
	$radiusvalue=getdistanceradiusvalue();
	if($property_category!=0)
	{
		if($lat!="" && $lng!="")
		{
			$searchpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->WHERE('tbl_pr.property_category',$property_category);
		}
		else{
			$searchpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type)
            ->WHERE('tbl_pr.property_category',$property_category);
		}
	}
	else{
		if($lat!="" && $lng!="")
		{
			$searchpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(tbl_pr.property_latitude)) 
                * cos(radians(tbl_pr.property_longitude) - radians(" . $lng . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(tbl_pr.property_latitude))) AS distance"))
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type);
		}
		else{
			$searchpropertyquery = DB::table("tbl_property as tbl_pr")
            ->select("tbl_pr.*")
            ->WHERE('tbl_pr.property_status','1')
            ->WHERE('tbl_pr.property_type',$property_type);
		}
	}

	if(isset($adult_count) && $adult_count!="")
	{
		$searchpropertyquery=$searchpropertyquery->where('guest_count','>=',$adult_count);
	}

	if($sort_by==1)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.property_price', 'ASC');
    }
    elseif($sort_by==2)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.property_price', 'DESC');
    }
    elseif($sort_by==3)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.id', 'DESC');
    }
    elseif($sort_by==4)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.property_rating', 'ASC');
    }
    elseif($sort_by==5)
    {
    	$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.property_rating', 'DESC');
    }
    else{
    	if($lat!="" && $lng!="")
    	{
    		$searchpropertyquery=$searchpropertyquery->orderBy('distance');
    	}
    	else{
    		$searchpropertyquery=$searchpropertyquery->orderBy('tbl_pr.id','DESC');
    	}
    }

    if($lat!="" && $lng!="")
    {
    	$searchpropertyquery=$searchpropertyquery->having('distance', '<=', $radiusvalue);
    }

    $perPage = 4;
    $total = $searchpropertyquery->count();
    $last_page=ceil($total / $perPage);

    $searchpropertylist = $searchpropertyquery->offset(($page - 1) * $perPage)->limit($perPage)->get();

    if($searchpropertylist)
    {
    	$searchlistarr=$searchpropertylist->toArray();
    	$searchpropertylistarr=[];
    	foreach($searchlistarr as $list)
    	{
    		if($list->property_image!="")
	        {
	        	$property_image=url('/').'/images/property/thumbnail/'.$list->property_image;
	        }
	        else{
	        	$property_image=url('/').'/no_image/property.jpg';
	        }

	        if($userid!="")
	        {
	        	$favourite=checkfavproperty($userid,$list->id);
	        }
	        else{
	        	$favourite=0;
	        }

	        if($property_type==1)
	        {
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'property_bedrooms'=>$list->no_of_bedroom,
					'property_description'=>$list->property_description,
					'property_area'=>$list->property_area,
					'favourite'=>$favourite,
					'rating'=>5
				);
	        }
	        else{
		        $searchpropertylistarr[]=array(
		        	'property_id'=>$list->id,
					'title'=>$list->title,
					'property_address'=>$list->property_address,
					'property_image'=>$property_image,
					'property_price'=>$list->property_price,
					'property_date'=>date('d M Y',strtotime($list->created_at)),
					'property_bedrooms'=>$list->no_of_bedroom,
					'property_description'=>$list->property_description,
					'property_area'=>$list->property_area,
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


public function getpropertybookingdetails(Request $request)
{
	try{
		$validator = Validator::make($request->all(), [
		            'property_id' => 'required'
		        ]);

	        if($validator->fails()){
	            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
	        }

	        $property_id=$request->property_id;

	        $checkproperty=Property::where('id',$property_id)->where('property_status',1)->get()->first();
        	if(!$checkproperty)
        	{
        		return $this::sendError('Unauthorised.', ['error'=>'Invalid Property.']);
        	}

	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	$property_type=1;
		        $validator = Validator::make($request->all(), [
		            'location' => 'required',
		            'lat'=>'required',
		            'lng'=>'required',
		            'category'=>'required',
		            'check_in_date'=>'required',
		            'check_out_date'=>'required',
		            'adult_count'=>'required'
		        ]);

			        if($validator->fails()){
			            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
			        }

					if(isset($request->category) && $request->category!="")
			        {
			        	$user_category=$request->category;
			        	if($user_category!=0)
			        	{
			        		$checkpropertycategory=Category::where('category_type',$property_type)->where('id',$user_category)->get()->first();

			        		if(!$checkpropertycategory)
			        		{
			        			return $this::sendError('Unauthorised Exception.', ['error'=>'Something went wrong.']);
			        		}
			        	}
			        }
			        else{
			        	$user_category=0;
			        }

			        $user_location=$request->location;
	        		$user_latitude=$request->lat;
	        		$user_longitude=$request->lng;
	        		$user_checkin_date=date('Y-m-d',strtotime($request->check_in_date));
	        		$user_checkout_date=date('Y-m-d',strtotime($request->check_out_date));
	        		$user_adults_count=$request->adult_count;
	        		$user_children_count=$request->children_count;

	        	$daysdiff=getdaysdiff($user_checkin_date,$user_checkout_date);

	        	$checkpropertyarray=$checkproperty->toArray();

	        	if($checkpropertyarray['property_image']!="")
		        {
		        	$property_image=url('/').'/images/property/thumbnail/'.$checkpropertyarray['property_image'];
		        }
		        else{
		        	$property_image=url('/').'/no_image/property.jpg';
		        }

			$checkpropertycategory=Category::where('category_type',$checkpropertyarray['property_type'])->where('id',$checkpropertyarray['property_category'])->get()->first();

			if($checkpropertycategory)
			{
				$property_category=$checkpropertycategory->name;
			}
			else{
				$property_category='-';
			}

	        $booking_price=$checkpropertyarray['property_price']*$daysdiff;
	        $booking_tax=getbookingtaxprice();
	        $total_booking_price=$booking_price+$booking_tax;

	        $propertyarray=array(
				'property_id'=>$checkpropertyarray['id'],
				'property_image'=>$property_image,
				'property_type'=>$checkpropertyarray['property_type'],
				'title'=>$checkpropertyarray['title'],
				'property_address'=>$checkpropertyarray['property_address'],
				'property_price'=>$checkpropertyarray['property_price'],
				'property_date'=>date('d M Y',strtotime($checkpropertyarray['created_at'])),
				'property_category'=>$property_category,
				'guest_count'=>$checkpropertyarray['guest_count'],
				'no_of_bedroom'=>$checkpropertyarray['no_of_bedroom'],
				'property_area'=>$checkpropertyarray['property_area'],
				'property_description'=>$checkpropertyarray['property_description'],
				'booking_price'=>$booking_price,
				'booking_tax'=>$booking_tax,
				'total_booking_price'=>$total_booking_price,
				'property_rating'=>5
			);	

	        	$searcharray=array(
	        		'user_category'=>$user_category,
	        		'user_location'=>$user_location,
	        		'user_latitude'=>$user_latitude,
	        		'user_longitude'=>$user_longitude,
	        		'user_checkin_date'=>date('d M,Y',strtotime($user_checkin_date)),
	        		'user_checkout_date'=>date('d M,Y',strtotime($user_checkout_date)),
	        		'user_adults_count'=>$user_adults_count,
	        		'user_children_count'=>$user_children_count
	        	);

					$success['propertyarray']=$propertyarray;
					$success['searcharray']=$searcharray;
	            	return $this::sendResponse($success, 'Property Booking Details.');
	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	        }
	}
	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
}

public function insertuserbookinginfo(Request $request)
{
	try{
		$validator = Validator::make($request->all(), [
		            'property_id' => 'required',
		            'name'=>'required',
		            'email'=>'required',
		            'age'=>'required',
		            'gender'=>'required',
		            'number'=>'required'
		        ]);

	        if($validator->fails()){
	            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
	        }

	        $property_id=$request->property_id;
	        $booking_user_name=$request->name;
	        $booking_user_email=$request->email;
	        $booking_user_age=$request->age;
	        $booking_user_gender=$request->gender;
	        $booking_user_number=$request->number;

	        $checkproperty=Property::where('id',$property_id)->where('property_status',1)->get()->first();
        	if(!$checkproperty)
        	{
        		return $this::sendError('Unauthorised.', ['error'=>'Invalid Property.']);
        	}

	        $user = auth()->guard("api")->user();
	        if($user)
	        {
	        	$property_type=1;
	        	$validator = Validator::make($request->all(), [
		            'location' => 'required',
		            'lat'=>'required',
		            'lng'=>'required',
		            'category'=>'required',
		            'check_in_date'=>'required',
		            'check_out_date'=>'required',
		            'adult_count'=>'required',
		        ]);

		        if($validator->fails()){
		            return $this::sendValidationError('Validation Error.',['error'=>$validator->messages()->all()[0]]);       
		        }

			if(isset($request->category) && $request->category!="")
	        {
	        	$user_category=$request->category;
	        	if($user_category!=0)
	        	{
	        		$checkpropertycategory=Category::where('category_type',$property_type)->where('id',$user_category)->get()->first();

	        		if(!$checkpropertycategory)
	        		{
	        			return $this::sendError('Unauthorised Exception.', ['error'=>'Something went wrong.']);
	        		}
	        	}
	        }
	        else{
	        	$user_category=0;
	        }

	        $user_location=$request->location;
			$user_latitude=$request->lat;
			$user_longitude=$request->lng;
			$user_checkin_date=date('Y-m-d',strtotime($request->check_in_date));
			$user_checkout_date=date('Y-m-d',strtotime($request->check_out_date));
			$user_adults_count=$request->adult_count;
			$user_children_count=$request->children_count;

	        $daysdiff=getdaysdiff($user_checkin_date,$user_checkout_date);

	        $checkpropertyarray=$checkproperty->toArray();

	        $booking_price=$checkpropertyarray['property_price']*$daysdiff;
	        $booking_tax=getbookingtaxprice();
	        $total_booking_price=$booking_price+$booking_tax;
	        $booking_id=generatebookingid();

	        $invoice_id=generateinvoiceid();

	        $usertempbooking=new Usertempbooking;
	        $usertempbooking->booking_id=$booking_id;
	        $usertempbooking->invoice_id=$invoice_id;
	        $usertempbooking->user_id=$user->id;
	        $usertempbooking->property_id=$property_id;
	        $usertempbooking->user_name=$booking_user_name;
	        $usertempbooking->user_email=$booking_user_email;
	        $usertempbooking->user_age=$booking_user_age;
	        $usertempbooking->user_gender=$booking_user_gender;
	        $usertempbooking->user_number=$booking_user_number;
	        $usertempbooking->user_checkin_date=$user_checkin_date;
	        $usertempbooking->user_checkout_date=$user_checkout_date;
	        $usertempbooking->booking_property_price=$booking_price;
	        $usertempbooking->booking_tax_price=$booking_tax;
	        $usertempbooking->booking_price=$total_booking_price;
	        $usertempbooking->user_adult_count=$user_adults_count;
	        $usertempbooking->user_children_count=$user_children_count;
	        $usertempbooking->booking_status=0; //ongoing
	        $usertempbooking->save();

	        $this->saveuserbookinginfo($user->id);

			$success=[];
	        return $this::sendResponse($success, 'Property Booking successfully done.');

	        }
	        else{
	        	return $this::sendUnauthorisedError('Unauthorised.', ['error'=>'Please login again.']);
	        }
	}
	catch(\Exception $e){
                  return $this::sendExceptionError('Unauthorised Exception.', ['error'=>$e->getMessage()]);    
               }
}

public function saveuserbookinginfo($userid)
{
		Usertempbooking::query()
		 ->where('user_id',$userid)
		 ->orderBy('id','DESC')
		 ->each(function ($oldPost) {
		  $newPost = $oldPost->replicate();
		  $newPost->setTable('user_booking');
		  $newPost->save();
		  $oldPost->delete();
		});

		return true;
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