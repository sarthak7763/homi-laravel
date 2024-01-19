<?php
namespace Modules\Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,Category,Property,PropertyGallery,PropertyCondition};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Notification,Image;
use Illuminate\Validation\ValidationException;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PropertyController extends Controller {

  	public function index(Request $request) {
        try{  
            
            if($request->ajax()) {   
                $data = Property::latest();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('title', function($row){

                        $title = '<a title="'.$row->title.'" href="'.route('admin-property-details',$row->slug).'">'.substr($row->title, 0, 15).'...</a><br>';
                        return $title;
                    })
                    ->addColumn('type', function($row){
                        $property_type = $row->property_type;
                        if($property_type==1){
                            $type='<span class="badge badge-warning" style="cursor: pointer;">Renting</span>';
                        }
                        else{
                             $type='<span class="badge badge-danger" style="cursor: pointer;">Buying</span>';
                        }
                        
                        return $type;
                    })
                    ->addColumn('category', function($row){
                        $checkpropertycategory=Category::where('id',$row->property_category)->get()->first();
                        if($checkpropertycategory)
                        {
                            $category=$checkpropertycategory->name;
                        }
                        else{
                            $category="N.A.";
                        }
                        return $category;
                    }) 
                    ->addColumn('status', function($row){
                        $status = $row->property_status;
                        if($status==0){
                            $status='<span class="badge badge-warning" style="cursor: pointer;" id="'.$row->id.'">Pending</span>';
                        }
                        elseif($status==1)
                        {
                            $status='<span class="badge badge-success badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
                        }
                        else{
                             $status='<span class="badge badge-danger badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Inactive</span>';
                        }
                        
                        return $status;
                    }) 
                    ->addColumn('created_at', function ($data) {
                        $created_date=date('M d, Y g:i A', strtotime($data->created_at));
                        return $created_date;   
                    })
                    ->addColumn('action__', function($row){
                        $route=route('admin-property-edit',$row->slug);
                        $route_view=route('admin-property-details',$row->slug);
                        $route_gallery=route('admin-property-gallery-view',$row->slug);

                        $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a> <a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> <a href="'.$route_gallery.'" title="Upload Gallery" class="btn btn-inverse btn-sm"><i class="fa fa-upload"></i></a>';
                        if($row->property_status==0)
                        {
                            $action.='<button title="publish" class="btn btn-sm badge_publish_status_change" style="background-color: aqua;color: black;font-size: 11px;" id="'.$row->id.'">Publish Property</button>';
                        }

                        return $action; 
                    })  
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->Where('title', 'LIKE', "%$search%");
                            });
                        }
                    
                        if(!empty($request->get('property_category'))) {
                            $instance->where('property_category', $request->get('property_category'));
                        }

                        if(!empty($request->get('property_type'))) {
                            $instance->where('property_type', $request->get('property_type'));
                        }

                        if(!empty($request->get('property_condition'))) {
                            $instance->where('property_condition', $request->get('property_condition'));
                        }
                     
                        if(!empty($request->get('status'))) {
                            $instance->where('property_status', $request->get('status'));
                        }


                        if(!empty($request->get('property_location'))  &&  !empty($request->get('property_location'))) {
                            $instance->where(function($w) use($request){
                                $property_location = $request->get('property_location');
                                $w->orwhere('location', 'LIKE', "%$property_location%");
                            });
                        } 
                    })
                    ->make(true);
            }

            $condition = PropertyCondition::where('status','1')->get();
             return view('admin::property.index',compact('condition'));  
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'something wrong');
        }
  	}

    
    public function seller_wise_property(Request $request) {
        try{  
            if($request->ajax()) {   
                $data = Property::where('add_by',$request->owner_id)->get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function($row){
                        if($row->property_image!="")
                        {
                            $imageurl=url('/').'/images/property/thumbnail/'.$row->property_image;
                        }
                        else{
                            $imageurl=url('/').'/no_image/property.jpg';
                        }

                        $route_view=route('admin-property-details',$row->id);
                        $image = '<img class="img-circle" src="'.$imageurl.'" height="50" width="50" id="thumbnil">';
                        return $image;
                    })
                    ->addColumn('title', function($row){

                        $title_start = '<a title="'.$row->title.'" href="'.route('admin-property-details',$row->slug).'">'.substr($row->title, 0, 15).'...</a><br>';
                        return $title_start;
                    }) 
                    ->addColumn('status', function($row){
                        $status = $row->property_status;
                        if($status==0){
                            $status='<span class="badge badge-warning" style="cursor: pointer;" id="'.$row->id.'">Pending</span>';
                        }
                        elseif($status==1)
                        {
                            $status='<span class="badge badge-success badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
                        }
                        else{
                             $status='<span class="badge badge-danger badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Inactive</span>';
                        }
                        
                        return $status;
                    }) 
                    ->addColumn('created_at', function ($data) {
                        $created_date=date('M d, Y g:i A', strtotime($data->created_at));
                        return $created_date;   
                    })
                    ->addColumn('action__', function($row){
                        $route=route('admin-property-edit',$row->slug);
                        $route_view=route('admin-property-details',$row->slug);
                        $route_gallery=route('admin-property-gallery-view',$row->slug);

                        $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a> <a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> <a href="'.$route_gallery.'" title="Upload Gallery" class="btn btn-inverse btn-sm"><i class="fa fa-upload"></i></a>';
                        if($row->property_status==0)
                        {
                            $action.='<button title="publish" class="btn btn-sm badge_publish_status_change" style="background-color: aqua;color: black;font-size: 11px;" id="'.$row->id.'">Publish Property</button>';
                        }

                        return $action; 
                    })  
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->Where('title', 'LIKE', "%$search%");
                            });
                        }
                    
                        if(!empty($request->get('property_category'))) {
                            $instance->where('property_category', $request->get('property_category'));
                        }

                        if(!empty($request->get('property_type'))) {
                            $instance->where('property_type', $request->get('property_type'));
                        }

                        if(!empty($request->get('property_condition'))) {
                            $instance->where('property_condition', $request->get('property_condition'));
                        }
                     
                        if(!empty($request->get('status'))) {
                            $instance->where('property_status', $request->get('status'));
                        }


                        if(!empty($request->get('property_location'))  &&  !empty($request->get('property_location'))) {
                            $instance->where(function($w) use($request){
                                $property_location = $request->get('property_location');
                                $w->orwhere('location', 'LIKE', "%$property_location%");
                            });
                        } 
                    })
                    ->make(true);
            }  
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'something wrong');
        }
    }


    public function add() {
        try{ 
            $country_list=getcountrylist();
            $PropOwnerList = User::where('user_type',3)->where('status',1)->where('email_verified','1')->orderBy('name','ASC')->get();
            $catType = Category::where('status','1')->orderBy('name','ASC')->get();

            $condition = PropertyCondition::where('status','1')->get();
            return view('admin::property.add',compact('catType','PropOwnerList','condition','country_list'));
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function save(Request $request) {
        try {
            $data=$request->all();

            $request->validate([
			    'add_by'=>'required',
			    'title'=>'required',
			    'property_type'=>[
                  'required',
                  Rule::in('1','2'),
                ],
                'property_category'=>'required',
                'guest_count'=>'nullable|numeric',
                'no_of_bedroom'=>'required|numeric',
                'built_in_year'=>'nullable',
                'no_of_kitchen'=>'nullable|numeric',
                'no_of_bathroom'=>'required|numeric',
                'no_of_balcony'=>'nullable|numeric',
                'no_of_floors'=>'required|numeric',
                'property_condition'=>'required',
                'property_area'=>'nullable|numeric',
                'property_number'=>'required',
                'property_email' => 'required|email',
                'property_address'=>'required',
                'property_price'=>'required|numeric',
			    ],
		      [
		        'add_by.required' => 'Owner is required.',
		        'title.required'=>'Title field can’t be left blank',
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

		        'no_of_pool.required'=>'No.of pool field can’t be left blank',
		        'no_of_pool.numeric'=>'No.of pool field allows only numbers.',

		        'no_of_garden.required'=>'No.of garden field can’t be left blank',
		        'no_of_garden.numeric'=>'No.of garden field allows only numbers.',

		        'no_of_balcony.required'=>'No.of balcony field can’t be left blank',
		        'no_of_balcony.numeric'=>'No.of balcony field allows only numbers.',

                'no_of_floors.required'=>'Floor no. field can’t be left blank',
                'no_of_floors.numeric'=>'Floor no. field allows only numbers.',

                'property_condition.required'=>'Property condition is required.',

		        'property_area.required'=>'Property area field can’t be left blank',
		        'property_area.numeric'=>'Property area field allows only numbers.',
		        'property_number.required'=>'Conatct Number field can’t be left blank',

		         'property_email.required'=>'Conatct email field can not be empty',
        		'property_email.email'=>'Please enter a valid conatct email address',
                'property_address.required'=>'Property address field can’t be left blank',
                'property_price.required'=>'Property address field can’t be left blank',
                'property_price_type.required'=>'Property price type is required.',
		      ]);

           
    $fileNameToStore="";
            //Upload Image
    if($request->hasFile('property_image')){
            try{
                $request->validate([
                  'property_image' => 'required|mimes:jpeg,png,jpg'
                ]);
            }
            catch(\Exception $e){
                        if($e instanceof ValidationException){
                            $listmessage=[];
                            foreach($e->errors() as $key=>$list)
                            {
                                $listmessage[$key]=$list[0];
                            }

                            if(count($listmessage) > 0)
                            {
                                return back()->with('valid_error',$listmessage);
                            }
                            else{
                                return back()->with('error','Something went wrong2.');
                            }
                            
                        }
                        else{
                            return back()->with('error','Something went wrong1.');
                        }      
                   }

                $fileNameToStore=uploadImage($request->file('property_image'),"images/property/thumbnail/",'');
            }
            else{
                return back()->with('error','Please choose property thumbnail image.');
            }

            $checkpropertyowner=User::where('id',$data['add_by'])->where('user_type',3)->where('status',1)->where('email_verified',1)->get()->first();
            if(!$checkpropertyowner)
            {
                return redirect()->back()->with('error', 'Please select another owner.');
            }

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

            $checkpropertytitle=Property::where('title',$data['title'])->where('property_type',$data['property_type'])->get()->first();
            if($checkpropertytitle)
            {
            	return redirect()->back()->with('error', 'Property title already exists.');
            }
        if(isset($request->no_of_garden))
        {
            $no_of_garden=$request->no_of_garden;
        }
        else{
            $no_of_garden=0;
        }

        if(isset($request->no_of_pool))
        {
            $no_of_pool=$request->no_of_pool;
        }
        else{
            $no_of_pool=0;
        }

        if(isset($request->no_of_parking))
        {
            $no_of_parking=$request->no_of_parking;
        }
        else{
            $no_of_parking=0;
        }

        if(isset($request->no_of_lift))
        {
            $no_of_lift=$request->no_of_lift;
        }
        else{
            $no_of_lift=0;
        }

        if(isset($request->features))
        {
	        if(count($request->features) > 0)
	        {
	            $features_list=json_encode($request->features);
	        }
	        else{
	            $features_list="";
	        }
        }
        else{
        	$features_list="";
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
        
            $property = new Property;
            $property->title=$data['title'];
            $property->title_pt=$title_pt;
            $property->property_type=$data['property_type'];
            $property->add_by=$data['add_by'];
            $property->guest_count=$data['guest_count'];
            $property->no_of_bedroom=$data['no_of_bedroom'];
            $property->no_of_kitchen=$data['no_of_kitchen'];
            $property->no_of_bathroom=$data['no_of_bathroom'];
            $property->no_of_pool=$no_of_pool;
            $property->no_of_garden=$no_of_garden;
            $property->no_of_lift=$no_of_lift;
            $property->no_of_parking=$no_of_parking;
            $property->no_of_balcony=$data['no_of_balcony'];
            $property->no_of_floors=$data['no_of_floors'];
            $property->property_features=$features_list;
            $property->property_area=$data['property_area'];
            $property->property_number=$data['property_number'];
            $property->property_address=$data['property_address'];
            $property->property_address_pt=$property_address_pt;
            $property->property_latitude=$data['property_latitude'];
            $property->property_longitude=$data['property_longitude'];
            $property->property_email=$data['property_email'];
            $property->property_price=$data['property_price'];
            $property->property_price_type=$data['property_price_type'];
            $property->property_category=$data['property_category'];
            $property->property_condition=$data['property_condition'];
            $property->meta_title=$data['meta_title'];
            $property->meta_title_pt=$meta_title_pt;
            $property->meta_keywords=$data['meta_keywords'];
            $property->meta_keywords_pt=$meta_keywords_pt;
            $property->meta_description=$data['meta_description'];
            $property->meta_description_pt=$meta_description_pt;
            $property->property_description=$data['property_description'];
            $property->property_description_pt=$property_description_pt;
            $property->built_in_year=$data['built_in_year'];
            $property->property_image=$fileNameToStore;
            $property->property_status=1;
            $property->publish_date=date('Y-m-d');
            $property->save();

            toastr()->success('Property information saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);

            $this->uploadpropertyimages($property->id,$request);

            return redirect()->route('admin-property-list')->with('success',"Property information saved successfully.");
        }
        catch (\Exception $e){
	        if($e instanceof ValidationException){
		        $listmessage=[];
		        foreach($e->errors() as $key=>$list)
		        {
		            $listmessage[$key]=$list[0];
		        }

		        if(count($listmessage) > 0)
		        {
		            return back()->with('valid_error',$listmessage);
		        }
		        else{
		            return back()->with('error','Something went wrong4.');
		        }
		        
		    }
		    else{
		        return back()->with('error',$e->getMessage());
		    }
        }
    }

    public function uploadpropertyimages($propertyid,$request)
    {
        $checkproperty=Property::where('id',$propertyid)->get()->first();
        if($checkproperty)
        {
            $property_gallery_files = [];
              if($request->hasfile('property_gallery'))
               {
                  foreach($request->file('property_gallery') as $file)
                  {
                      $name = time().rand(1,50).'.'.$file->extension();
                      $file->move(public_path('/images/property/gallery/'), $name);  
                      $property_gallery_files[] = $name;  
                  }
               }

            foreach($property_gallery_files as $list)
              {
                $propertygallery = new PropertyGallery;
                $propertygallery->property_id=$propertyid;
                $propertygallery->image=$list;
                $propertygallery->status=1;
                $propertygallery->type=1;

                $propertygallery->save();
              }

              return true;
        }
        else{
            return true;
        }
    }

    public function edit($slug){
        try{
            $country_list=getcountrylist();
            $propertyInfo=Property::where('slug',$slug)->first();
            $PropOwnerList = User::where('user_type',3)->where('status',1)->where('email_verified','1')->orderBy('name','ASC')->get();
            $catType = Category::where('status','1')->orderBy('name','ASC')->get();

            $condition = PropertyCondition::where('status','1')->get();

            $galleryList=PropertyGallery::where('property_id',$propertyInfo->id)->where('type',"1")->where('status',1)->orderBy('id','DESC')->get();
            if($galleryList)
            {
                $galleryListarray=$galleryList->toArray();
                if($galleryListarray)
                {
                    $property_gallery=[];
                    foreach($galleryListarray as $list)
                    {
                        $property_gallery[]=array('id'=>$list['id'],'url'=>url('/').'/images/property/gallery/'.$list['image']);
                    }
                }
                else{
                    $property_gallery=[];
                }
            }
            else{
                $property_gallery=[];
            }

            return view('admin::property.edit', compact('propertyInfo','catType','PropOwnerList','condition','country_list','property_gallery'));
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }

    public function update(Request $request)
    {
        try {
            $data=$request->all();

            $request->validate([
                'add_by'=>'required',
                'title'=>'required',
                'property_type'=>[
                  'required',
                  Rule::in('1','2'),
                ],
                'property_category'=>'required',
                'guest_count'=>'nullable|numeric',
                'no_of_bedroom'=>'required|numeric',
                'built_in_year'=>'nullable',
                'no_of_kitchen'=>'nullable|numeric',
                'no_of_bathroom'=>'required|numeric',
                'no_of_balcony'=>'nullable|numeric',
                'no_of_floors'=>'required|numeric',
                'property_condition'=>'required',
                'property_area'=>'nullable|numeric',
                'property_number'=>'required',
                'property_email' => 'required|email',
                'property_address'=>'required',
                'property_price'=>'required|numeric',
                ],
              [
                'add_by.required' => 'Owner is required.',
                'title.required'=>'Title field can’t be left blank',
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

                'no_of_pool.required'=>'No.of pool field can’t be left blank',
                'no_of_pool.numeric'=>'No.of pool field allows only numbers.',

                'no_of_garden.required'=>'No.of garden field can’t be left blank',
                'no_of_garden.numeric'=>'No.of garden field allows only numbers.',

                'no_of_balcony.required'=>'No.of balcony field can’t be left blank',
                'no_of_balcony.numeric'=>'No.of balcony field allows only numbers.',

                'no_of_floors.required'=>'Floor no. field can’t be left blank',
                'no_of_floors.numeric'=>'Floor no. field allows only numbers.',

                'property_condition.required'=>'Property condition is required.',

                'property_area.required'=>'Property area field can’t be left blank',
                'property_area.numeric'=>'Property area field allows only numbers.',
                'property_number.required'=>'Contact Number field can’t be left blank',

                 'property_email.required'=>'Contact email field can not be empty',
                'property_email.email'=>'Please enter a valid contact email address',
                'property_address.required'=>'Property address field can’t be left blank',
                'property_price.required'=>'Property address field can’t be left blank',
                'property_price_type.required'=>'Property price type is required.',
              ]);

              if(!array_key_exists("property_id",$data))
              {
                return redirect('admin/property-list/')->with('error','Something went wrong.');
              }

            $propertyupdate=Property::find($data['property_id']);

            if(is_null($propertyupdate)){
               return redirect()->route('admin-property-list')->with('error',"Something went wrong6.");
            }

            $fileNameToStore="";
                //Upload Image
            if($request->hasFile('property_image')){
                try{
                    $request->validate([
                      'property_image' => 'required|mimes:jpeg,png,jpg'
                    ]);
                }
                catch(\Exception $e){
                            if($e instanceof ValidationException){
                                $listmessage=[];
                                foreach($e->errors() as $key=>$list)
                                {
                                    $listmessage[$key]=$list[0];
                                }

                                if(count($listmessage) > 0)
                                {
                                    return back()->with('valid_error',$listmessage);
                                }
                                else{
                                    return back()->with('error','Something went wrong4.');
                                }
                                
                            }
                            else{
                                return back()->with('error','Something went wrong3.');
                            }      
                       }

                    $fileNameToStore=uploadImage($request->file('property_image'),"images/property/thumbnail/",'');
                }
                else{
                    $fileNameToStore="";
                }

            if($propertyupdate->property_image=="")
            {
                if($fileNameToStore=="")
                {
                    return back()->with('error','Please choose property thumbnail image.');
                }
            }

            $checkpropertyowner=User::where('id',$data['add_by'])->where('user_type',3)->where('status',1)->where('email_verified',1)->get()->first();
            if(!$checkpropertyowner)
            {
                return redirect()->back()->with('error', 'Please select another owner.');
            }

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

        if(isset($request->no_of_garden))
        {
            $no_of_garden=$request->no_of_garden;
        }
        else{
            $no_of_garden=0;
        }

        if(isset($request->no_of_pool))
        {
            $no_of_pool=$request->no_of_pool;
        }
        else{
            $no_of_pool=0;
        }

        if(isset($request->no_of_parking))
        {
            $no_of_parking=$request->no_of_parking;
        }
        else{
            $no_of_parking=0;
        }

        if(isset($request->no_of_lift))
        {
            $no_of_lift=$request->no_of_lift;
        }
        else{
            $no_of_lift=0;
        }

        if(isset($request->features))
        {
	        if(count($request->features) > 0)
	        {
	            $features_list=json_encode($request->features);
	        }
	        else{
	            $features_list="";
	        }
        }
        else{
        	$features_list="";
        }

            if($propertyupdate->title==$data['title'])
            {
                if($fileNameToStore!="")
                {
                    $propertyupdate->property_type=$data['property_type'];
                    $propertyupdate->add_by=$data['add_by'];
                    $propertyupdate->guest_count=$data['guest_count'];
                    $propertyupdate->no_of_bedroom=$data['no_of_bedroom'];
                    $propertyupdate->no_of_kitchen=$data['no_of_kitchen'];
                    $propertyupdate->no_of_bathroom=$data['no_of_bathroom'];
                    $propertyupdate->no_of_pool=$no_of_pool;
                    $propertyupdate->no_of_garden=$no_of_garden;
                    $propertyupdate->no_of_lift=$no_of_lift;
            		$propertyupdate->no_of_parking=$no_of_parking;
            		$propertyupdate->property_features=$features_list;
                    $propertyupdate->no_of_balcony=$data['no_of_balcony'];
                    $propertyupdate->no_of_floors=$data['no_of_floors'];
                    $propertyupdate->property_area=$data['property_area'];
                    $propertyupdate->property_number=$data['property_number'];
                    $propertyupdate->property_address=$data['property_address'];
                    $propertyupdate->property_latitude=$data['property_latitude'];
                    $propertyupdate->property_longitude=$data['property_longitude'];
                    $propertyupdate->property_email=$data['property_email'];
                    $propertyupdate->property_price=$data['property_price'];
                    $propertyupdate->property_price_type=$data['property_price_type'];
                    $propertyupdate->property_category=$data['property_category'];
                    $propertyupdate->property_condition=$data['property_condition'];
                    $propertyupdate->meta_title=$data['meta_title'];
                    $propertyupdate->meta_keywords=$data['meta_keywords'];
                    $propertyupdate->meta_description=$data['meta_description'];
                    $propertyupdate->property_description=$data['property_description'];
                    $propertyupdate->built_in_year=$data['built_in_year'];
                    $propertyupdate->property_image=$fileNameToStore;
                }
                else{
                    $propertyupdate->property_type=$data['property_type'];
                    $propertyupdate->add_by=$data['add_by'];
                    $propertyupdate->guest_count=$data['guest_count'];
                    $propertyupdate->no_of_bedroom=$data['no_of_bedroom'];
                    $propertyupdate->no_of_kitchen=$data['no_of_kitchen'];
                    $propertyupdate->no_of_bathroom=$data['no_of_bathroom'];
                    $propertyupdate->no_of_pool=$no_of_pool;
                    $propertyupdate->no_of_garden=$no_of_garden;
                    $propertyupdate->no_of_lift=$no_of_lift;
            		$propertyupdate->no_of_parking=$no_of_parking;
            		$propertyupdate->property_features=$features_list;
                    $propertyupdate->no_of_balcony=$data['no_of_balcony'];
                    $propertyupdate->no_of_floors=$data['no_of_floors'];
                    $propertyupdate->property_area=$data['property_area'];
                    $propertyupdate->property_number=$data['property_number'];
                    $propertyupdate->property_address=$data['property_address'];
                    $propertyupdate->property_latitude=$data['property_latitude'];
                    $propertyupdate->property_longitude=$data['property_longitude'];
                    $propertyupdate->property_email=$data['property_email'];
                    $propertyupdate->property_price=$data['property_price'];
                    $propertyupdate->property_price_type=$data['property_price_type'];
                    $propertyupdate->property_category=$data['property_category'];
                    $propertyupdate->property_condition=$data['property_condition'];
                    $propertyupdate->meta_title=$data['meta_title'];
                    $propertyupdate->meta_keywords=$data['meta_keywords'];
                    $propertyupdate->meta_description=$data['meta_description'];
                    $propertyupdate->property_description=$data['property_description'];
                    $propertyupdate->built_in_year=$data['built_in_year'];
                }
            }
            else{
                $checkpropertytitle=Property::where('title',$data['title'])->where('property_type',$data['property_type'])->get()->first();
                if($checkpropertytitle)
                {
                    return redirect()->back()->with('error', 'Property title already exists.');
                }
                else{
                    if($fileNameToStore!="")
                    {
                        $propertyupdate->title=$data['title'];
                        $propertyupdate->property_type=$data['property_type'];
                    $propertyupdate->add_by=$data['add_by'];
                    $propertyupdate->guest_count=$data['guest_count'];
                    $propertyupdate->no_of_bedroom=$data['no_of_bedroom'];
                    $propertyupdate->no_of_kitchen=$data['no_of_kitchen'];
                    $propertyupdate->no_of_bathroom=$data['no_of_bathroom'];
                    $propertyupdate->no_of_pool=$no_of_pool;
                    $propertyupdate->no_of_garden=$no_of_garden;
                    $propertyupdate->no_of_lift=$no_of_lift;
            		$propertyupdate->no_of_parking=$no_of_parking;
            		$propertyupdate->property_features=$features_list;
                    $propertyupdate->no_of_balcony=$data['no_of_balcony'];
                    $propertyupdate->no_of_floors=$data['no_of_floors'];
                    $propertyupdate->property_area=$data['property_area'];
                    $propertyupdate->property_number=$data['property_number'];
                    $propertyupdate->property_address=$data['property_address'];
                    $propertyupdate->property_latitude=$data['property_latitude'];
                    $propertyupdate->property_longitude=$data['property_longitude'];
                    $propertyupdate->property_email=$data['property_email'];
                    $propertyupdate->property_price=$data['property_price'];
                    $propertyupdate->property_price_type=$data['property_price_type'];
                    $propertyupdate->property_category=$data['property_category'];
                    $propertyupdate->property_condition=$data['property_condition'];
                    $propertyupdate->meta_title=$data['meta_title'];
                    $propertyupdate->meta_keywords=$data['meta_keywords'];
                    $propertyupdate->meta_description=$data['meta_description'];
                    $propertyupdate->property_description=$data['property_description'];
                    $propertyupdate->built_in_year=$data['built_in_year'];
                    $propertyupdate->property_image=$fileNameToStore;
                    }
                    else{
                        $propertyupdate->title=$data['title'];
                        $propertyupdate->property_type=$data['property_type'];
                    $propertyupdate->add_by=$data['add_by'];
                    $propertyupdate->guest_count=$data['guest_count'];
                    $propertyupdate->no_of_bedroom=$data['no_of_bedroom'];
                    $propertyupdate->no_of_kitchen=$data['no_of_kitchen'];
                    $propertyupdate->no_of_bathroom=$data['no_of_bathroom'];
                    $propertyupdate->no_of_pool=$no_of_pool;
                    $propertyupdate->no_of_garden=$no_of_garden;
                    $propertyupdate->no_of_lift=$no_of_lift;
            		$propertyupdate->no_of_parking=$no_of_parking;
            		$propertyupdate->property_features=$features_list;
                    $propertyupdate->no_of_balcony=$data['no_of_balcony'];
                    $propertyupdate->no_of_floors=$data['no_of_floors'];
                    $propertyupdate->property_area=$data['property_area'];
                    $propertyupdate->property_number=$data['property_number'];
                    $propertyupdate->property_address=$data['property_address'];
                    $propertyupdate->property_latitude=$data['property_latitude'];
                    $propertyupdate->property_longitude=$data['property_longitude'];
                    $propertyupdate->property_email=$data['property_email'];
                    $propertyupdate->property_price=$data['property_price'];
                    $propertyupdate->property_price_type=$data['property_price_type'];
                    $propertyupdate->property_category=$data['property_category'];
                    $propertyupdate->property_condition=$data['property_condition'];
                    $propertyupdate->meta_title=$data['meta_title'];
                    $propertyupdate->meta_keywords=$data['meta_keywords'];
                    $propertyupdate->meta_description=$data['meta_description'];
                    $propertyupdate->property_description=$data['property_description'];
                    $propertyupdate->built_in_year=$data['built_in_year'];
                    }
                }
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

            $propertyupdate->title_pt=$title_pt;
            $propertyupdate->property_address_pt=$property_address_pt;
            $propertyupdate->meta_title_pt=$meta_title_pt;
            $propertyupdate->meta_keywords_pt=$meta_keywords_pt;
            $propertyupdate->meta_description_pt=$meta_description_pt;
            $propertyupdate->property_description_pt=$property_description_pt;


            $propertyupdate->save();

            $this->uploadpropertyimages($propertyupdate->id,$request);

            toastr()->success('Property information updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->route('admin-property-list')->with('success',"Property information updated successfully.");

        }
        catch (\Exception $e){
            if($e instanceof ValidationException){
                $listmessage=[];
                foreach($e->errors() as $key=>$list)
                {
                    $listmessage[$key]=$list[0];
                }

                if(count($listmessage) > 0)
                {
                    return back()->with('valid_error',$listmessage);
                }
                else{
                    return back()->with('error','Something went wrong2.');
                }
                
            }
            else{
                return back()->with('error',$e->getMessage());
            }
        }
    }

    public function ajaxgetcategorylist(Request $request)
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

    public function ajaxgetownderdetails(Request $request)
    {
        $owner_id=$request->owner_id;
        if($owner_id!="")
        {
            $checkowner=User::where('status',1)->where('user_type',3)->where('id',$owner_id)->where('email_verified',1)->get()->first();
            if($checkowner)
            {
                $checkownerdet=$checkowner->toArray();
                $owner_number=$checkownerdet['mobile'];
                $owner_email=$checkownerdet['email'];
                
                $data=array('code'=>200,'owner_number'=>$owner_number,'owner_email'=>$owner_email);
                $finaldata=json_encode($data);
                return $finaldata;
            }
            else{
                $data=array('code'=>200,'owner_number'=>'','owner_email'=>'');
                $finaldata=json_encode($data);
                return $finaldata;
            }
        }
        else{
            $data=array('code'=>200,'owner_number'=>'','owner_email'=>'');
            $finaldata=json_encode($data);
            return $finaldata;
        }
        
    }

    public function updatePropertyStatus(Request $request)
    {
        try {
            $data=$request->all();
            $request->validate([
                'property_id'=>'required',
                ],
              [
                'property_id.required'=>'Property ID is required.',
              ]);

            $propertyupdate=Property::find($data['property_id']);

            if(is_null($propertyupdate)){
               return redirect()->route('admin-property-list')->with('error',"Something went wrong.");
            }

            if($propertyupdate->property_status==1)
            {
                $status=2;
                $publish_date="";
            }
            else{
                $status=1;
                $publish_date=date('Y-m-d');
            }

            $propertyupdate->property_status=$status;
            $propertyupdate->publish_date=$publish_date;
            $propertyupdate->save();

            return response()->json(["status" => 'success','message'=>$status]);

        }
        catch (\Exception $e){
            return response()->json(["status" => 'error','message'=>'Something went wrong.']);
        }
    }


    public function updatePropertyPublishStatus(Request $request)
    {
        try {
            $data=$request->all();

            $request->validate([
                'property_id'=>'required',
                ],
              [
                'property_id.required'=>'Property ID is required.',
              ]);

            $propertyupdate=Property::find($data['property_id']);

            if(is_null($propertyupdate)){
               return redirect()->route('admin-property-list')->with('error',"Something went wrong.");
            }

            if($propertyupdate->property_status==0)
            {
                $status=1;

                $propertyupdate->property_status=$status;
                $propertyupdate->publish_date=date('Y-m-d');
                $propertyupdate->save();

                return response()->json(["status" => 'success','message'=>$status]);
            }
            else{
               return response()->json(["status" => 'error','message'=>'Property has already published.']);
            }
        }
        catch (\Exception $e){
            return response()->json(["status" => 'error','message'=>'Something went wrong.']);
        }
    }


    public function show($slug){
        try{

            $propertyInfo=Property::where('slug',$slug)->first();

            $ownerid=$propertyInfo->add_by;
            $ownerdet=User::where('id',$ownerid)->where('email_verified',1)->where('user_type',3)->where('status',1)->get()->first();
            if($ownerdet)
            {
                $propertyInfo->ownername=$ownerdet->name;
            }
            else{
                $propertyInfo->ownername="N.A.";
            }

            $property_condition=$propertyInfo->property_condition;
            $conditiondet=PropertyCondition::where('id',$property_condition)->where('status',1)->get()->first();
            if($conditiondet)
            {
                $propertyInfo->conditionname=$conditiondet->name;
            }
            else{
                $propertyInfo->conditionname="N.A.";
            }

            $property_category=$propertyInfo->property_category;
            $categorydet=Category::where('id',$property_category)->where('category_type',$propertyInfo->property_type)->where('status',1)->get()->first();
            if($categorydet)
            {
                $propertyInfo->categoryname=$categorydet->name;
            }
            else{
                $propertyInfo->categoryname="N.A.";
            }

            

            $galleryList=PropertyGallery::where('property_id',$propertyInfo->id)->where('type',"1")->where('status',1)->orderBy('id','DESC')->get();
            if($galleryList)
            {
                $galleryListarray=$galleryList->toArray();
                if($galleryListarray)
                {
                    $property_gallery=[];
                    foreach($galleryListarray as $list)
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
         
            return view('admin::property.show',compact('propertyInfo','property_gallery'));  
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');     
        }  
    }

    public function ajaxpropertyimagedelete(Request $request)
    {
        $property_id=$request->property_id;
        $checkproperty=Property::where('id',$property_id)->get()->first();
        if($checkproperty)
        {
            $checkpropertygallery=PropertyGallery::where('id',$request->id)->where('property_id',$property_id)->get()->first();
            if($checkpropertygallery)
            {
                PropertyGallery::where('id',$request->id)->where('property_id',$property_id)->delete();


	           $galleryList=PropertyGallery::where('property_id',$property_id)->where('type',"1")->where('status',1)->orderBy('id','DESC')->get();
	            if($galleryList)
	            {
	                $galleryListarray=$galleryList->toArray();
	                if($galleryListarray)
	                {
	                    $property_gallery=[];
	                    foreach($galleryListarray as $list)
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

                $data=array('code'=>200,'message'=>'Image deleted successfully.','gallery_db_count'=>count($property_gallery));
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
            $data=array('code'=>400,'message'=>'Invalid property.');
            $finaldata=json_encode($data);
            return $finaldata;
        }
    }

}