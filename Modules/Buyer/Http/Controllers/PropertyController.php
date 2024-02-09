<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Category;
use App\Models\Country;
use App\Models\PropertyGallery;
use App\Models\UserSubscription;
use App\Models\Subcription;
use App\Models\User;
use Illuminate\Validation\Rule;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,DB,Str,Redirect,session;
use App\Models\PropertyCondition;


class PropertyController extends Controller
{
    //
    public function index(Request $request)
    {
      $access_module= sellermoduleaccess();
    if($access_module=='false')
    {
      return redirect()->route('buyer.subscription-plans');
    }
        
       try
       {                                        
        $user_id = Auth::User()->id;
        $search_title = $request->title_search;
        $search_status = $request->status_search;
        if($request->segment(3))
        {
        	$segmentvalue=$request->segment(3);
        }
        else{
        	$segmentvalue="";
        }
       
        //DB::enableQueryLog();
        $propertyDetail = Property::where('add_by',$user_id)->latest(); 


        if($search_title!="" || $search_status!="" || $segmentvalue!="") {

          $propertyDetail->where(function($query) use ($search_title, $search_status,$segmentvalue)
              {
                if($search_title!=""){
                  $query->where('title', 'like', '%' . $search_title . '%');
                }

                
                if ($search_status!="") {
                  $query->where('property_status',$search_status );
              	}

              if($segmentvalue!="" && $segmentvalue!="all")
              {
              	if($segmentvalue=="buying")
              	{
              		$query->where('property_type',2);
              	}
              	else{
              		$query->where('property_type','1');
              	}
              }
               
              });
            }
        
        
            $propertyData = $propertyDetail->Paginate(6);




     
        //dd(DB::getQueryLog());
        foreach($propertyData as $key=>$list)
        {
        	$categorydet=Category::where('id',$list['property_category'])->get()->first();
        	if($categorydet)
        	{
        		$propertyData[$key]['category_name']=$categorydet->name;
        	}
        	else{
        		$propertyData[$key]['category_name']='';
        	}
        }

        return view('buyer::property',compact('propertyData','search_title','search_status'));
      }
      catch(Exception $e){  
        return redirect()->back()->with('error', 'something wrong');     
      }
    }

    
    
    public function add(Request $request)
    {
      
      $access_module= sellermoduleaccess();
      $property_access  =$this->propertyAccess();

    if( $access_module && $property_access=='true' )
    {
      return redirect()->route('buyer.subscription-plans');
    }
        try{
        $country_list=getcountrylist();
        $propertyDetail = Property::all();
        $user_id = Auth::User()->id;
       $userData = DB::table('users')->where('users.id',$user_id)
                                       ->select('users.email','users.mobile')
                                       ->get()
                                       ->first();
      $property_condition = PropertyCondition::where('status',1)->get();
      return view('buyer::add-property',compact('propertyDetail','property_condition','country_list','userData'));
      }
      catch (\Exception $e){
        return response()->json(["status" => 'error','message'=>'Something went wrong.']);
      }
    }


    public function getcategory(Request $request)
    {
        $property_type=$request->property_type;
        
        $property_category=$request->property_category;
       
       if($property_type!="")
        {
            $categorylist=Category::where('status',1)->where('category_type',$property_type)->get();
        
            if($categorylist)
            {
                $categorylistarr=$categorylist->toArray();
                $categoryhtml='<option value="">Select Category</option>';
                foreach($categorylistarr as $list)
                {
                    if($property_category!="")
                    {
                        if($property_category==$list['id'])
                        {
                            $selected="selected";
                        }
                        else{
                            $selected="";
                        }
                    }
                    else{
                        $selected="";
                    }
                    $categoryhtml.='<option '.$selected.' value="'.$list['id'].'">'.$list['name'].'</option>';
                }

                $data=array('code'=>200,'message'=>'success','categoryhtml'=>$categoryhtml);
                $finaldata=json_encode($data);
                return $finaldata;
            }
            else{
                $data=array('code'=>400,'message'=>'Something went wrong.');
                $finaldata=json_encode($data);
                return $finaldata;
            }
        }
        else{
            $data=array('code'=>400,'message'=>'Please select property type.');
            $finaldata=json_encode($data);
            return $finaldata;
        }
    }



    public function store(Request $request) {

      $property_access  =$this->propertyAccess();
        if($property_access=='true')
        {
          return redirect()->route('buyer.property','all')->with('error',"Property cant be add more.");;
        }



        $validator = Validator::make($request->all(), [
          'title'=>'required|regex:/^[\pL\s]+$/u',
			     'property_type'=>[
                   'required',
                   Rule::in('1','2'),
                 ],
                 'property_category'=>'required',
                'guest_count'=>'required|numeric',
                'no_of_bedroom'=>'required|numeric',
                'built_in_year'=>'required',
                'no_of_kitchen'=>'required|numeric',
                'no_of_bathroom'=>'required|numeric',
                'no_of_balcony'=>'required|numeric',
                'no_of_floors'=>'required|numeric',
                'property_condition'=>'required',
                'property_features'=>'required',
                'property_area'=>'required|numeric',
                'property_address'=>'required||regex:/^[\pL\s]+$/u',
               
                'property_price'=>'required|numeric',
                'property_price_type'=>'required',
                'property_image' => 'required|mimes:jpeg,png,jpg',
                'property_gallery_image' => 'array|max:7'
],
[
  'title.required'=>'Title field can’t be left blank',
  'title.regex'=>'  Title field only alphabetic characters.',
  'property_type.required' => 'Property type is required.',
  'property_type.in'=>'Invalid property type Value',
  'property_category.required'=>'Property category is required.',
  'guest_count.required'=>'Guest count field can’t be left blank',
  'guest_count.numeric'=>'Guest count field allows only numbers.',
  'no_of_bedroom.required'=>'No.of bedroom field can’t be left blank',
  'no_of_bedroom.numeric'=>'No.of bedroom field allows only numbers.',
  'built_in_year.required'=>'Built in year field can’t be left blank',
  'built_in_year.numeric'=>'Built in year field allows only numbers.',
  'no_of_kitchen.required'=>'No.of kitchen field can’t be left blank',
  'no_of_kitchen.numeric'=>'No.of kitchen field allows only numbers.',
  'no_of_bathroom.required'=>'No.of bathroom field can’t be left blank',
  'no_of_bathroom.numeric'=>'No.of bathroom field allows only numbers.',
  'no_of_balcony.required'=>'No.of balcony field can’t be left blank',
  'no_of_balcony.numeric'=>'No.of balcony field allows only numbers.',
  'no_of_floors.required'=>'Floor no. field can’t be left blank',
  'no_of_floors.numeric'=>'Floor no. field allows only numbers.',
  'property_condition.required'=>'Property condition is required.',
  'property_features.required' => 'Property features is required.',
  'property_area.required'=>'Property area field can’t be left blank',
  'property_area.numeric'=>'Property area field allows only numbers.',
  'property_address.required'=>'Property address field can’t be left blank',
  'property_address.regex'=>'Property address field only alphabetic characters.',
  
  'property_price.required'=>'Property price field can’t be left blank',
  'property_price.numeric'=>'Property price field only allows number',
  'property_price_type.required'=>'Property price type is required.',
  'property_image.required'=>'Image field can not be empty',
  'property_image.mimes'=>'Image extension should be jpg,jpeg,png',

  'property_gallery_image.max'=>'Image should not be greater than 7.',
]);
if($validator->fails()){

return Redirect::back()->withErrors($validator)->withInput();
}
      $data=$request->all();

      
                  
            $checkpropertycategory=Category::where('id',$data['property_category'])->where('category_type',$data['property_type'])->where('status',1)->get()->first();
            if(!$checkpropertycategory)
            {
                return redirect()->back()->with('error', 'Please select another category.');
            }
            $checkpropertycondition=PropertyCondition::where('id',$data['property_condition'])->where('status',1)->get()->first();
            if(!$checkpropertycondition)
            {
                return redirect()->back()->with('error', 'Please select another condition.');
            }
            $title_pt=GoogleTranslate::trans($data['title'],'pt');
            $property_address_pt="";
            if($data['meta_title']!="")
            {
              $meta_title_pt=GoogleTranslate::trans($data['meta_title'],'pt');
            }
            else{
              $meta_title_pt="";
            }
            if($data['meta_keywords']!="")
            {
              $meta_keywords_pt=GoogleTranslate::trans($data['meta_keywords'],'pt');
            }
            else{
              $meta_keywords_pt="";
            }
            if($data['meta_description']!="")
            {
              $meta_description_pt=GoogleTranslate::trans($data['meta_description'],'pt');
            }
            else{
              $meta_description_pt="";
            }
            if($data['property_description']!="")
            {
              $property_description_pt=GoogleTranslate::trans($data['property_description'],'pt');
            }
            else{
              $property_description_pt="";
            }
            if($request->hasFile('property_image')){      
                          $imageName = time().'.'.$request->property_image->extension();
                        $image = $request->property_image->move(public_path('images/property/thumbnail/'), $imageName);
                         $user_id = Auth::User()->id;
                          $property = new Property;
                          $property->title=$data['title'];
                          $property->add_by=$user_id;
                          $property->title_pt=$title_pt;
                          $property->property_type=$data['property_type'];
                          $property->guest_count=$data['guest_count'];
                          $property->no_of_bedroom=$data['no_of_bedroom'];
                          $property->no_of_kitchen=$data['no_of_kitchen'];
                          $property->no_of_bathroom=$data['no_of_bathroom'];
                          $property->no_of_pool=$data['chk_pool'] ?? 0;
                          $property->no_of_garden=$data['chk_garden'] ?? 0;
                          $property->no_of_lift=$data['chk_lift'] ?? 0;
                          $property->no_of_parking=$data['chk_parking'] ?? 0;
                          $property->no_of_balcony=$data['no_of_balcony'];
                          $property->no_of_floors=$data['no_of_floors'];
                          $property->property_area=$data['property_area'];
                          $property->property_address=$data['property_address'];
                          $property->property_address_pt=$property_address_pt;
                          $property->property_latitude=$data['property_latitude'] ?? "";
                          $property->property_longitude=$data['property_longitude'] ?? "";
                          $property->property_email=$data['property_email'];
                          $property->property_number=$data['property_number'];
                          $property->property_price=$data['property_price'];
                          $property->property_price_type=$data['property_price_type'];
                          $property->property_category=$data['property_category'];
                          $property->property_condition=$data['property_condition'];
                          $property->property_features=json_encode($data['property_features']);
                          $property->meta_title=$data['meta_title'];
                          $property->meta_title_pt=$meta_title_pt;
                          $property->meta_keywords=$data['meta_keywords'];
                          $property->meta_keywords_pt=$meta_keywords_pt;
                          $property->meta_description=$data['meta_description'];
                          $property->meta_description_pt=$meta_description_pt;
                          $property->property_description=$data['property_description'];
                          $property->property_description_pt=$property_description_pt;
                          $property->built_in_year=$data['built_in_year'];
                          $property->property_image=$imageName;
                          $property->property_status=0;
                          // $property->property_status=1;
                          $property->publish_date=date('Y-m-d');
                      
                          $property->save();
                          $property_id = $property->id;


    
                          
                          if($request->hasFile('property_gallery_image')){
                          $allowedfileExtension = ['jpeg','jpg','png'];


                            foreach ($data['property_gallery_image'] as $key => $value ){


                              
                              $image_extension = $value->getClientOriginalExtension();
                              $property_gallery_image= uniqid().$value->extension();

                              

                              $check = in_array($image_extension, $allowedfileExtension);
                              // Checking the image extension
                              if (!$check) {
                                  return redirect()->back()->with('error', 'Images must be png, jpeg or jpg!');
                              }
                              
                              
                               $image = $value->move(public_path('images/property/gallery/'), $property_gallery_image);
                                  
                                    $gallery = new PropertyGallery;
                                        $gallery->property_id = $property_id;
                                        $gallery->type = 1;
                                        $gallery->status = 1;
                                        $gallery->image = $property_gallery_image;
                                        
                                      
                                        $gallery->save();
                                  }
                          }
                          
                      return redirect()->route('buyer.property','all')->with('success', 'Property has been added !');      
                      }
                     else{
                          return back()->with('error','Please choose property thumbnail image.');
                    }
                  }



    public function edit($id){
      $access_module= sellermoduleaccess();
    if($access_module=='false')
    {
      return redirect()->route('buyer.subscription-plans');
    }

      try{
        $country_list=getcountrylist();
        $propertyDetail = Property::where('id',$id)->get()->first();
        
        $my_property_features = $propertyDetail->property_features;
        $featuresArray = json_decode($my_property_features, true);
        $propertyGallery = PropertyGallery::where('property_id',$id)->where('status',1)->get()->toArray();
        $featuresArray = json_decode($my_property_features, true);
        return view('buyer::editproperty',compact('propertyDetail','propertyGallery','featuresArray','country_list'));
      }
      catch (\Exception $e){
        return response()->json(["status" => 'error','message'=>$e->getMessage()]);
      }
    }



    public function update(Request $request,$id){
          $access_module= sellermoduleaccess();
        if($access_module=='false')
        {
          return redirect()->route('buyer.subscription-plans');
        }

        $data=$request->all();

        $uploaded_images = PropertyGallery::where('property_id',$id)->count();

        $remaining_images = 7-$uploaded_images;


        $validator = Validator::make($request->all(), [
          'title'=>'required|regex:/^[\pL\s]+$/u',
			     'property_type'=>[
                    'required',
                    Rule::in('1','2'),
                  ],
                'property_category'=>'required',
                'guest_count'=>'required|numeric',
                'no_of_bedroom'=>'required|numeric',
                'built_in_year'=>'required',
                'no_of_kitchen'=>'required|numeric',
                'no_of_bathroom'=>'required|numeric',
                'no_of_balcony'=>'required|numeric',
                'no_of_floors'=>'required|numeric',
                'property_condition'=>'required',
                'property_features'=>'required',
                'property_area'=>'required|numeric',
                'property_address'=>'required|regex:/^[\pL\s]+$/u',
                'property_price'=>'required|numeric',
                'property_price_type'=>'required',
                'property_gallery_image' => 'array|max:'.$remaining_images,
                
],
[

  'title.required'=>'Title field can’t be left blank',
  'title.regex'=>'  Title field only alphabetic characters.',
  'property_type.required' => 'Property type is required.',
  'property_type.in'=>'Invalid property type Value',
  'property_category.required'=>'Property category is required.',
  'guest_count.required'=>'Guest count field can’t be left blank',
  'guest_count.numeric'=>'Guest count field allows only numbers.',
  'no_of_bedroom.required'=>'No.of bedroom field can’t be left blank',
  'no_of_bedroom.numeric'=>'No.of bedroom field allows only numbers.',
  'built_in_year.required'=>'Built in year field can’t be left blank',
  'built_in_year.numeric'=>'Built in year field allows only numbers.',
  'no_of_kitchen.required'=>'No.of kitchen field can’t be left blank',
  'no_of_kitchen.numeric'=>'No.of kitchen field allows only numbers.',
  'no_of_bathroom.required'=>'No.of bathroom field can’t be left blank',
  'no_of_bathroom.numeric'=>'No.of bathroom field allows only numbers.',
  'no_of_balcony.required'=>'No.of balcony field can’t be left blank',
  'no_of_balcony.numeric'=>'No.of balcony field allows only numbers.',
  'no_of_floors.required'=>'Floor no. field can’t be left blank',
  'no_of_floors.numeric'=>'Floor no. field allows only numbers.',
  'property_condition.required'=>'Property condition is required.',
  'property_features.required' => 'Property features is required.',
  'property_area.required'=>'Property area field can’t be left blank',
  'property_area.numeric'=>'Property area field allows only numbers.',
  'property_address.required'=>'Property address field can’t be left blank',
  'property_address.regex'=>'  property address field only alphabetic characters.',
  'property_price.required'=>'Property price field can’t be left blank',
  'property_price.numeric'=>'Property price field only allows number',
  'property_price_type.required'=>'Property price type is required.',
 
  'property_gallery_image.max'=>' please upload only'.' '.$remaining_images.' gallery images' 

  ]);
if($validator->fails()){

return Redirect::back()->withErrors($validator)->withInput();
}

       

       
              $property=Property::find($id);
              if(!empty($property))
              {
              $checkpropertycategory=Category::where('id',$data['property_category'])->where('category_type',$data['property_type'])->where('status',1)->get()->first();
              
            if(!$checkpropertycategory)
            {
                return redirect()->back()->with('error', 'Please select another category.');
            }
            $checkpropertycondition=PropertyCondition::where('id',$data['property_condition'])->where('status',1)->get()->first();
            if(!$checkpropertycondition)
            {
                return redirect()->back()->with('error', 'Please select another condition.');
            }
            $title_pt=GoogleTranslate::trans($data['title'],'pt');
             $property_address_pt="";
            
             if($data['meta_title']!="")
            {
              $meta_title_pt=GoogleTranslate::trans($data['meta_title'],'pt');
            }
            else{
              $meta_title_pt="";
            }
            if($data['meta_keywords']!="")
            {
              $meta_keywords_pt=GoogleTranslate::trans($data['meta_keywords'],'pt');
            }
            else{
              $meta_keywords_pt="";
            }
            if($data['meta_description']!="")
            {
              $meta_description_pt=GoogleTranslate::trans($data['meta_description'],'pt');
            }
            else{
              $meta_description_pt="";
            }
            if($data['property_description']!="")
            {
              $property_description_pt=GoogleTranslate::trans($data['property_description'],'pt');
            }
            else{
              $property_description_pt="";
            }
            if($property->title==$data['title'])
            {
              if($request->hasFile('property_image')){      
                $imageName = time().'.'.$request->property_image->extension();
                
                $image = $request->property_image->move(public_path('images/property/thumbnail/'), $imageName);
                          
                          $property->property_type=$data['property_type'];
                          $property->guest_count=$data['guest_count'];
                          $property->no_of_bedroom=$data['no_of_bedroom'];
                          $property->no_of_kitchen=$data['no_of_kitchen'];
                          $property->no_of_bathroom=$data['no_of_bathroom'];
                          $property->no_of_pool=$data['chk_pool'] ?? 0;
                          $property->no_of_garden=$data['chk_garden'] ?? 0;
                          $property->no_of_lift=$data['chk_lift'] ?? 0;
                          $property->no_of_parking=$data['chk_parking'] ?? 0;
                          $property->no_of_balcony=$data['no_of_balcony'];
                          $property->no_of_floors=$data['no_of_floors'];
                          $property->property_area=$data['property_area'];
                          $property->property_address=$data['property_address'];
                          $property->property_address_pt=$property_address_pt;
                          $property->property_latitude=$data['property_latitude'] ?? "";
                          $property->property_longitude=$data['property_longitude'] ?? "";
                          $property->property_email=$data['property_email'];
                          $property->property_number=$data['property_number'];
                          $property->property_price=$data['property_price'];
                          $property->property_price_type=$data['property_price_type'];
                          $property->property_category=$data['property_category'];
                          $property->property_condition=$data['property_condition'];
                          $property->property_features=json_encode($data['property_features']);
                          $property->meta_title=$data['meta_title'];
                          $property->meta_title_pt=$meta_title_pt;
                          $property->meta_keywords=$data['meta_keywords'];
                          $property->meta_keywords_pt=$meta_keywords_pt;
                          $property->meta_description=$data['meta_description'];
                          $property->meta_description_pt=$meta_description_pt;
                          $property->property_description=$data['property_description'];
                          $property->property_description_pt=$property_description_pt;
                          $property->built_in_year=$data['built_in_year'];
                          $property->property_image=$imageName;
                          $property->property_status=0;
                          // $property->property_status=1;
                          $property->publish_date=date('Y-m-d');
              }
              else{
                  $property->property_type=$data['property_type'];
                  $property->guest_count=$data['guest_count'];
                  $property->no_of_bedroom=$data['no_of_bedroom'];
                  $property->no_of_kitchen=$data['no_of_kitchen'];
                  $property->no_of_bathroom=$data['no_of_bathroom'];
                  $property->no_of_pool=$data['chk_pool'] ?? 0;
                  $property->no_of_garden=$data['chk_garden'] ?? 0;
                  $property->no_of_lift=$data['chk_lift'] ?? 0;
                  $property->no_of_parking=$data['chk_parking'] ?? 0;
                  $property->no_of_balcony=$data['no_of_balcony'];
                  $property->no_of_floors=$data['no_of_floors'];
                  $property->property_area=$data['property_area'];
                  $property->property_address=$data['property_address'];
                  $property->property_address_pt=$property_address_pt;
                  $property->property_latitude=$data['property_latitude'] ?? "";
                  $property->property_longitude=$data['property_longitude'] ?? "";
                  $property->property_email=$data['property_email'];
                  $property->property_number=$data['property_number'];
                  $property->property_price=$data['property_price'];
                  $property->property_price_type=$data['property_price_type'];
                  $property->property_category=$data['property_category'];
                  $property->property_condition=$data['property_condition'];
                  $property->property_features=json_encode($data['property_features']);
                  $property->meta_title=$data['meta_title'];
                  $property->meta_title_pt=$meta_title_pt;
                  $property->meta_keywords=$data['meta_keywords'];
                  $property->meta_keywords_pt=$meta_keywords_pt;
                  $property->meta_description=$data['meta_description'];
                  $property->meta_description_pt=$meta_description_pt;
                  $property->property_description=$data['property_description'];
                  $property->property_description_pt=$property_description_pt;
                  $property->built_in_year=$data['built_in_year'];
                   $property->property_status=0;
                  // $property->property_status=1;
                  $property->publish_date=date('Y-m-d');
              }
            }
            else{
              $checkpropertytitle=Property::where('title',$data['title'])->where('property_type',$data['property_type'])->get()->first();
              if($checkpropertytitle)
              {
                  return redirect()->back()->with('error', 'Property title already exists.');
              }
              else{
                if($request->hasFile('property_image')){      
                  $imageName = time().'.'.$request->property_image->extension();
                  $image = $request->property_image->move(public_path('images/property/thumbnail/'), $imageName);
                          $property->title=$data['title'];
                          $property->property_type=$data['property_type'];
                          $property->guest_count=$data['guest_count'];
                          $property->no_of_bedroom=$data['no_of_bedroom'];
                          $property->no_of_kitchen=$data['no_of_kitchen'];
                          $property->no_of_bathroom=$data['no_of_bathroom'];
                          $property->no_of_pool=$data['chk_pool'] ?? 0;
                         
                          $property->no_of_garden=$data['chk_garden'] ?? 0;
                          $property->no_of_lift=$data['chk_lift'] ?? 0;
                          $property->no_of_parking=$data['chk_parking'] ?? 0;
                          $property->no_of_balcony=$data['no_of_balcony'];
                          $property->no_of_floors=$data['no_of_floors'];
                          $property->property_area=$data['property_area'];
                          $property->property_address=$data['property_address'];
                          $property->property_address_pt=$property_address_pt;
                          $property->property_latitude=$data['property_latitude'] ?? "";
                          $property->property_longitude=$data['property_longitude'] ?? "";
                          $property->property_email=$data['property_email'];
                          $property->property_number=$data['property_number'];
                          $property->property_price=$data['property_price'];
                          $property->property_price_type=$data['property_price_type'];
                          $property->property_category=$data['property_category'];
                          $property->property_condition=$data['property_condition'];
                          $property->property_features=json_encode($data['property_features']);
                          $property->meta_title=$data['meta_title'];
                          $property->meta_title_pt=$meta_title_pt;
                          $property->meta_keywords=$data['meta_keywords'];
                          $property->meta_keywords_pt=$meta_keywords_pt;
                          $property->meta_description=$data['meta_description'];
                          $property->meta_description_pt=$meta_description_pt;
                          $property->property_description=$data['property_description'];
                          $property->property_description_pt=$property_description_pt;
                          $property->built_in_year=$data['built_in_year'];
                          $property->property_image=$imageName;
                          $property->property_status=0;
                          // $property->property_status=1;
                          $property->publish_date=date('Y-m-d');
                      }
                  else{
                    $property->title=$data['title'];
                    $property->property_type=$data['property_type'];
                    $property->guest_count=$data['guest_count'];
                    $property->no_of_bedroom=$data['no_of_bedroom'];
                    $property->no_of_kitchen=$data['no_of_kitchen'];
                    $property->no_of_bathroom=$data['no_of_bathroom'];
                    $property->no_of_pool=$data['chk_pool'] ?? 0;
                  
                    $property->no_of_garden=$data['chk_garden'] ?? 0;
                    $property->no_of_lift=$data['chk_lift'] ?? 0;
                    $property->no_of_parking=$data['chk_parking'] ?? 0;
                    $property->no_of_balcony=$data['no_of_balcony'];
                    $property->no_of_floors=$data['no_of_floors'];
                    $property->property_area=$data['property_area'];
                    $property->property_address=$data['property_address'];
                    $property->property_address_pt=$property_address_pt;
                    $property->property_latitude=$data['property_latitude'] ?? "";
                    $property->property_longitude=$data['property_longitude'] ?? "";
                    $property->property_email=$data['property_email'];
                    $property->property_number=$data['property_number'];
                    $property->property_price=$data['property_price'];
                    $property->property_price_type=$data['property_price_type'];
                    $property->property_category=$data['property_category'];
                    $property->property_condition=$data['property_condition'];
                    $property->property_features=json_encode($data['property_features']);
                    $property->meta_title=$data['meta_title'];
                    $property->meta_title_pt=$meta_title_pt;
                    $property->meta_keywords=$data['meta_keywords'];
                    $property->meta_keywords_pt=$meta_keywords_pt;
                    $property->meta_description=$data['meta_description'];
                    $property->meta_description_pt=$meta_description_pt;
                    $property->property_description=$data['property_description'];
                    $property->property_description_pt=$property_description_pt;
                    $property->built_in_year=$data['built_in_year'];
                    $property->property_status=0;

                    // $property->property_status=1;
                    $property->publish_date=date('Y-m-d');
                  }
              }
          } 
                        $property->save();



                       
                        $property_id = $property->id;

                        if($remaining_images==0)
                        {
                            return redirect()->back()->with('error', 'you cant upload  new gallery image.');
                        }
                       
                          if($request->hasFile('property_gallery_image')){

                            $allowedfileExtension = ['jpeg','jpg','png'];
                            
                        foreach ($data['property_gallery_image'] as $key => $value ){

                              $image_extension = $value->getClientOriginalExtension();
                              $property_gallery_image= uniqid().$value->extension();
                              $check = in_array($image_extension, $allowedfileExtension);
                              // Checking the image extension
                              if (!$check) {
                                  return redirect()->back()->with('error', 'Images must be png, jpeg or jpg!');
                              }
                              
                              $image = $value->move(public_path('images/property/gallery/'), $property_gallery_image);
                                        $gallery = new PropertyGallery;
                                        $gallery->property_id = $property_id;
                                        $gallery->type = 1;
                                        $gallery->status = 1;
                                        $gallery->image = $property_gallery_image;
                                        $gallery->save();
                                  }
                            }
                          // toastr()->success('Property information saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
                          return redirect()->route('buyer.property','all')->with('success', 'Property has been updated !'); 
                }
                
                else
                {
                  return redirect()->back()->with('error', 'id does not found !'); 
                }
              }



           public function updatePropertyStatus(Request $request){
            try {
              $access_module= sellermoduleaccess();
              if($access_module=='false')
              {
                return redirect()->route('buyer.subscription-plans');
              }

              $data=$request->all();
              $request->validate([
                  'property_id'=>'required',
                  ],
                [
                  'property_id.required'=>'Property ID is required.',
                ]);
  
              $propertyupdate=Property::find($data['property_id']);
              
              if(is_null($propertyupdate)){
                 return redirect()->route('buyer.property','all')->with('error',"Something went wrong.");
              }
              if($propertyupdate->property_status==1)
              {
                  $status=2;
              }
                  else
                  {
                    $status =1;
                  }
                  $propertyupdate->property_status=$status;
                  $propertyupdate->save();
                  return redirect()->route('buyer.property','all')->with('success',"Property status updated successfully.");
                }
          catch (\Exception $e){
              return response()->json(["status" => 'error','message'=>$e->getMessage()]);
          }
            
    }                 

     
                      
  

    public function view($id)
    {
      $access_module= sellermoduleaccess();
    if($access_module=='false')
    {
      return redirect()->route('buyer.subscription-plans');
    }

      try {
                                                          

      $propertyData = Property::where('id',$id)->get()->first();
      $my_property_features = $propertyData->property_features;
      $featuresArray = json_decode($my_property_features, true);
    
     
      
      $property_gallery = PropertyGallery :: where('property_id',$id)->get()->toArray();
      $property_conditionData = DB::table('tbl_property')->join('property_condition','property_condition.id','=','tbl_property.property_condition')
                                                          ->select('property_condition.name')
                                                          ->where('tbl_property.id',$id)
                                                          ->get()
                                                          ->first();
        return view('buyer::viewproperty',compact('propertyData','property_gallery','property_conditionData','featuresArray')); 
      }
      catch (\Exception $e){
        return response()->json(["status" => 'error','message'=>'Something went wrong.']);
    }
    }

     


      // using ajax

    public function ajaxdelete(Request $request)
    {
      $access_module= sellermoduleaccess();
    if($access_module=='false')
    {
      return redirect()->route('buyer.subscription-plans');
    }

          $data = $request->all();
          $deleted_gallery  = PropertyGallery::where('property_id',$data['id'])->where('id',$data['gallery_id'])->where('status',1)->delete();
            if($data){
            $data=array('code'=>200,'message'=>'success');
                    $finaldata=json_encode($data);
                    return $finaldata;
            }       
            else{
                    $data=array('code'=>400,'message'=>'Something went wrong.');
                    $finaldata=json_encode($data);
                    return $finaldata;
            }
          }


          public function propertyAccess()
          {
             $user_id = Auth::User()->id;
             $product_listing =   DB::table('user_subscriptions')->leftjoin('subscriptions','subscriptions.id','=','user_subscriptions.plan_id')
                                        ->select('product_listing')
                                          ->where('user_id',$user_id)
                                          ->where('user_subscriptions.subscription_status',1) 
                                          ->first();
                  $total_property = Property::where('add_by',$user_id)->count();

                  if($product_listing==''){
                
                    return true;
                  } 
                  else{
                      if($total_property >= $product_listing->product_listing){
                        return true;
                    }
                    else{
                      return false;
                    }
                  }
                   

           }
                 
      }


    
  
        
    
 
        