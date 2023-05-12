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

class PropertyController extends Controller {

  	public function index(Request $request) {
        try{  
            if($request->ajax()) {   
                $data = Property::latest();

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
                                $w->Where('title', 'LIKE', "%$search%")
                                ->orWhere('location', 'LIKE', "%$search%")
                                ->orWhere('address', 'LIKE', "%$search%")
                                ->orWhere('zipcode', 'LIKE', "%$search%")
                                ->orWhere('property_size', 'LIKE', "%$search%")
                                ->orWhere('price_from', 'LIKE', "%$search%")
                                ->orWhere('price_to', 'LIKE', "%$search%")
                                ->orWhere('currency_type', 'LIKE', "%$search%") 
                                ->orWhere('no_of_bedroom', 'LIKE', "%$search%")
                                ->orWhere('no_of_bathroom', 'LIKE', "%$search%")
                                ->orWhere('year_from', 'LIKE', "%$search%")
                                ->orWhere('year_to', 'LIKE', "%$search%");
                            });
                        }
                    

                        if(!empty($request->get('property_type'))) {
                            $instance->where('property_type', $request->get('property_type'));
                        }
                     
                        if($request->get('status') == '0' || $request->get('status') == '1') {
                            $instance->where('status', $request->get('status'));
                        }
                        
                        if ($request->get('delete_status') == '0' || $request->get('delete_status') == '1'){
                            $instance->where('delete_status', $request->get('delete_status'));
                        }

                        if(!empty($request->get('base_price_from'))  &&  !empty($request->get('base_price_to'))) {
                            $instance->where(function($w) use($request){
                                $start_price = $request->get('base_price_from');
                                $end_price = $request->get('base_price_to');
                          
                                $w->orwhereRaw("base_price >= '" . $start_price . "' AND base_price <= '" . $end_price . "'");
                            });
                        }


                        if(!empty($request->get('property_location'))  &&  !empty($request->get('property_location'))) {
                            $instance->where(function($w) use($request){
                                $property_location = $request->get('property_location');
                                $w->orwhere('location', 'LIKE', "%$property_location%");
                            });
                        }

                        if(!empty($request->get('start_date'))  &&  !empty($request->get('end_date'))) {
                            $instance->where(function($w) use($request){
                               $start_date = $request->get('start_date');
                               $end_date = $request->get('end_date');
                               $start_date = date('Y-m-d', strtotime($start_date));
                               $end_date = date('Y-m-d', strtotime($end_date));
                               $w->orwhereRaw("date(created_at) >= '" . $start_date . "' AND date(created_at) <= '" . $end_date . "'");
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

    public function pendingProperty(Request $request) {
        try{
            $stateList = State::where('status',1)->get();    
            if($request->ajax()) { 

                $data = PropertyOffer::whereHas('OfferPropertyInfo', function($has) {
                        $has->where('escrow_status',"Pending");
                        $has->where('delete_status',0);
                    })->with(['OfferPropertyInfo' => function ($has) {
                        $has->where('escrow_status',"Pending");
                    }])->where('delete_status',0)->get();
                             
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function($row){
                        $image = '';
                        $route_view=route('admin-property-details',$row->OfferPropertyInfo->id);
                        $image = '<img class="img-circle" src="'.$row->OfferPropertyInfo->image.'" height="50" width="50" id="thumbnil">';
                        
                        return $image;
                    })
                    ->addColumn('title', function($row){
                        $title = $row->OfferPropertyInfo->title;
                        return $title;
                    }) 
                  
                    ->addColumn('state', function($row){
                        $state = @$row->OfferPropertyInfo->getPropertyState->name ? $row->OfferPropertyInfo->getPropertyState->name : "";

                        return $state;
                    }) 
                    ->addColumn('city', function($row){
                        $city = @$row->OfferPropertyInfo->getPropertyCity->name ? $row->OfferPropertyInfo->getPropertyCity->name : "";

                        return $city;
                    }) 
                   
                    ->addColumn('status', function($row){
                        $status = $row->status;
                        $escrow = $row->OfferPropertyInfo->escrow_status;
                        if($escrow =="Pending"){
                            $status='<span class="badge badge-danger" style="cursor: pointer;" id="'.$row->id.'">Closed or in escrow</span>';
                        }else{
                            if($status==1){
                                $status='<span class="badge badge-success badge_status_change" style="cursor: pointer;" id="'.$row->OfferPropertyInfo->id.'">Active</span>';
                            }else{
                                $status='<span class="badge badge-danger badge_status_change" style="cursor: pointer;" id="'.$row->OfferPropertyInfo->id.'">Inactive</span>';
                            }
                        }
                        return $status;
                    }) 
                     ->addColumn('escrow_status', function($row){
                        $escrow="";
                        $escrow_status = $row->OfferPropertyInfo->escrow_status;
                        if($escrow_status=="Active"){
                            $escrow='<span class="badge badge-success" id="'.$row->id.'">Active</span>';
                        }
                        if($escrow_status=="Pending"){
                            $escrow='<span class="badge badge-warning" id="'.$row->id.'">Pending</span>';
                        }
                        if($escrow_status=="Cancelled"){
                            $escrow='<span class="badge badge-inverse"  id="'.$row->id.'">Cancelled</span>';
                        }
                        if($escrow_status=="Sold"){
                             $escrow='<span class="badge badge-danger" id="'.$row->id.'">Sold</span>';
                        }
                        return $escrow;
                    }) 
                   
                    ->addColumn('action__', function($row){
                        $route=route('admin-property-edit',$row->OfferPropertyInfo->slug);
                        $route_view=route('admin-property-details',$row->OfferPropertyInfo->slug);
                        $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a> <a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                       ';
                        return $action;
                    })  
               
                    ->make(true);
            }  
            return view('admin::property.pending-property',compact('stateList'));  
         }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'something wrong');
        }
    }

    public function add() {
        try{ 
            $PropOwnerList = User::where('user_type',3)->where('status',1)->where('email_verified','1')->orderBy('name','ASC')->get();
            $catType = Category::where('status','1')->orderBy('name','ASC')->get();

            $condition = PropertyCondition::where('status','1')->get();
            return view('admin::property.add',compact('catType','PropOwnerList','condition'));
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
                'guest_count'=>'required|numeric',
                'no_of_bedroom'=>'required|numeric',
                'built_in_year'=>'required',
                'no_of_kitchen'=>'required|numeric',
                'no_of_bathroom'=>'required|numeric',
                'no_of_pool'=>'required|numeric',
                'no_of_garden'=>'required|numeric',
                'no_of_balcony'=>'required|numeric',
                'no_of_floors'=>'required|numeric',
                'property_condition'=>'required',
                'property_area'=>'required|numeric',
                'property_number'=>'required',
                'property_email' => 'required|email',
                'property_address'=>'required',
                'property_price'=>'required|numeric',
                'property_price_type'=>'required',
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
                                return back()->with('error','Something went wrong.');
                            }
                            
                        }
                        else{
                            return back()->with('error','Something went wrong.');
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
        
            $property = new Property;
            $property->title=$data['title'];
            $property->property_type=$data['property_type'];
            $property->add_by=$data['add_by'];
            $property->guest_count=$data['guest_count'];
            $property->no_of_bedroom=$data['no_of_bedroom'];
            $property->no_of_kitchen=$data['no_of_kitchen'];
            $property->no_of_bathroom=$data['no_of_bathroom'];
            $property->no_of_pool=$data['no_of_pool'];
            $property->no_of_garden=$data['no_of_garden'];
            $property->no_of_balcony=$data['no_of_balcony'];
            $property->no_of_floors=$data['no_of_floors'];
            $property->property_area=$data['property_area'];
            $property->property_number=$data['property_number'];
            $property->property_address=$data['property_address'];
            $property->property_latitude=$data['property_latitude'];
            $property->property_longitude=$data['property_longitude'];
            $property->property_email=$data['property_email'];
            $property->property_price=$data['property_price'];
            $property->property_price_type=$data['property_price_type'];
            $property->property_category=$data['property_category'];
            $property->property_condition=$data['property_condition'];
            $property->meta_title=$data['meta_title'];
            $property->meta_keywords=$data['meta_keywords'];
            $property->meta_description=$data['meta_description'];
            $property->property_description=$data['property_description'];
            $property->built_in_year=$data['built_in_year'];
            $property->property_image=$fileNameToStore;
            $property->property_status=1;
            $property->publish_date=date('Y-m-d');
            $property->save();

            toastr()->success('Property information saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->route('admin-property-gallery-view',$property->slug)->with('success',"Property information saved successfully. Now add property Images to publish your property");
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
		            return back()->with('error','Something went wrong.');
		        }
		        
		    }
		    else{
		        return back()->with('error','Something went wrong.');
		    }
        }
    }
    public function edit($slug){
        try{
           
            $propertyInfo=Property::where('slug',$slug)->first();
            $PropOwnerList = User::where('user_type',3)->where('status',1)->where('email_verified','1')->orderBy('name','ASC')->get();
            $catType = Category::where('status','1')->orderBy('name','ASC')->get();

            $condition = PropertyCondition::where('status','1')->get();

            return view('admin::property.edit', compact('propertyInfo','catType','PropOwnerList','condition'));
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
                'property_id'=>'required',
                'add_by'=>'required',
                'title'=>'required',
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
                'no_of_pool'=>'required|numeric',
                'no_of_garden'=>'required|numeric',
                'no_of_balcony'=>'required|numeric',
                'no_of_floors'=>'required|numeric',
                'property_condition'=>'required',
                'property_area'=>'required|numeric',
                'property_number'=>'required',
                'property_email' => 'required|email',
                'property_address'=>'required',
                'property_price'=>'required|numeric',
                'property_price_type'=>'required',
                ],
              [
                'property_id.required'=>'Property ID is required.',
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
                    $propertyupdate->no_of_pool=$data['no_of_pool'];
                    $propertyupdate->no_of_garden=$data['no_of_garden'];
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
                    $propertyupdate->save();
                }
                else{
                    $propertyupdate->property_type=$data['property_type'];
                    $propertyupdate->add_by=$data['add_by'];
                    $propertyupdate->guest_count=$data['guest_count'];
                    $propertyupdate->no_of_bedroom=$data['no_of_bedroom'];
                    $propertyupdate->no_of_kitchen=$data['no_of_kitchen'];
                    $propertyupdate->no_of_bathroom=$data['no_of_bathroom'];
                    $propertyupdate->no_of_pool=$data['no_of_pool'];
                    $propertyupdate->no_of_garden=$data['no_of_garden'];
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
                    $propertyupdate->save();
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
                    $propertyupdate->no_of_pool=$data['no_of_pool'];
                    $propertyupdate->no_of_garden=$data['no_of_garden'];
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
                    $propertyupdate->save();
                    }
                    else{
                        $propertyupdate->title=$data['title'];
                        $propertyupdate->property_type=$data['property_type'];
                    $propertyupdate->add_by=$data['add_by'];
                    $propertyupdate->guest_count=$data['guest_count'];
                    $propertyupdate->no_of_bedroom=$data['no_of_bedroom'];
                    $propertyupdate->no_of_kitchen=$data['no_of_kitchen'];
                    $propertyupdate->no_of_bathroom=$data['no_of_bathroom'];
                    $propertyupdate->no_of_pool=$data['no_of_pool'];
                    $propertyupdate->no_of_garden=$data['no_of_garden'];
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
                    $propertyupdate->save();
                    }
                }
            }

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

}