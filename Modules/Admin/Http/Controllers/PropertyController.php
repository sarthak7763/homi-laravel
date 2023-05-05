<?php
namespace Modules\Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,Category,Property,PropertyGallery};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Notification,Image;
use Illuminate\Validation\ValidationException;

class PropertyController extends Controller {
    
    public function pushNotification($title,$description,$payload,$user_id){
        
        $android_registration_ids = DeviceToken::whereIn('user_id',$user_id)
        ->where('device_token','!=','')
        ->where('device_type','Android')
        ->where('status',1)
        ->pluck('device_token')->toArray();

        $ios_registration_ids = DeviceToken::whereIn('user_id',$user_id)
        ->where('device_token','!=','')
        ->where('device_type','IOS')
        ->where('status',1)
        ->pluck('device_token')->toArray();

        $userInfo=User::where('id',$user_id)->first();
        $unreadNotifCount=$userInfo->unreadNotifications->count();

        if (!empty($android_registration_ids)) {
        sendPushNotification($title,$description,$android_registration_ids,$payload,'Android',$unreadNotifCount);
        }

        if (!empty($ios_registration_ids)) {
        sendPushNotification($title,$description,$ios_registration_ids,$payload,'Ios',$unreadNotifCount);
        }    
    }

  	public function index(Request $request) {
        try{  
            if($request->ajax()) {   
                $data = Property::where('property_status',1)->latest();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function($row){
                        $image = '';
                        $route_view=route('admin-property-details',$row->id);
                        $image = '<img class="img-circle" src="'.$row->image.'" height="50" width="50" id="thumbnil">';
                        return $image;
                    })
                    ->addColumn('title', function($row){

                        $title_start = '<a title="'.$row->title.'" href="'.route('admin-property-details',$row->slug).'">'.substr($row->title, 0, 15).'...</a><br>';
                        return $title_start;
                    }) 
                    ->addColumn('status', function($row){
                        $status = $row->status;
                        if($status==1){
                            $status='<span class="badge badge-success badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
                        }else{
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

                        $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a> <a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> <a href="'.$route_gallery.'" title="Upload Gallery" class="btn btn-inverse btn-sm"><i class="fa fa-upload"></i></a><button title="delete" class="btn btn-danger btn-sm badge_delete_status_change" id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
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
             return view('admin::property.index');  
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'something wrong');
        }
  	}
    public function activePropertyList(Request $request) {
        try{
            //$countryList = Country::where('status',1)->get(); 
            $stateList = State::where('delete_status',0)->get(); 
            $propertyTypeList = PropertyType::where('delete_status',0)->get(); 
            
            if($request->ajax()) {   
                $data = Property::with(['SaleOffer','getBids' => function($q){
                            $q->where('delete_status', '=', "0")->get();
                        }])->withCount(['getBids as new_bid_count' => function ($query) {
                            $query->where('bid_status', "Active");
                            $query->where('delete_status', 0);
                        },
                        'getBids as award_bid_count' => function ($query) {
                            $query->where('bid_status', "Awarded");
                            $query->where('delete_status', 0);
                        },
                        'getBids as reject_bid_count' => function ($query) {
                            $query->where('bid_status', "Rejected");
                            $query->where('delete_status', 0);
                        },
                        'getBids as closed_bid_count' => function ($query) {
                            $query->where('bid_status', "Closed");
                            $query->where('delete_status', 0);
                        },
                        'getBids as cancelled_bid_count' => function ($query) {
                            $query->where('bid_status', "Cancelled");
                            $query->where('delete_status', 0);
                        }
                    ])->where([['delete_status',0],['escrow_status','Active']])->latest();

                return Datatables::of($data)

                    ->addIndexColumn()
                    ->addColumn('image', function($row){
                        $image = '';
                        $route_view=route('admin-property-details',$row->id);
                        $image = '<img class="img-circle" src="'.$row->image.'" height="50" width="50" id="thumbnil">';
                        return $image;
                    })
                    ->addColumn('title', function($row){
                        $title_mid="";
                        $new_bid="";
                        $award_bid="";
                        $reject_bid="";
                        $closed_bid="";
                        $cancelled_bid="";

                        $title_start = '<a title="'.$row->title.'" href="'.route('admin-property-details',$row->slug).'">'.substr($row->title, 0, 15).'...</a><br>';
                      
                        if($row->new_bid_count > 0){
                            $new_bid = '<a href="'.route('admin-bid-property-wise-get',[@$row->getBids[0]->property_id,"Active"]).'" title="Active Bid"><label class="badge badge-info" style="cursor:pointer">'.$row->new_bid_count.'</label></a> ';
                        }
                        if($row->award_bid_count > 0){    
                            $award_bid ='<a href="'.route('admin-bid-property-wise-get',[@$row->getBids[0]->property_id,"Awarded"]).'" title="Awarded Bid"><label class="badge badge-success" style="cursor:pointer">'.$row->award_bid_count.'</label></a> ';
                        }
                        
                        if($row->reject_bid_count > 0){
                            $reject_bid ='<a href="'.route('admin-bid-property-wise-get',[@$row->getBids[0]->property_id,"Rejected"]).'" title="Rejected Bid"><label class="badge badge-warning" style="cursor:pointer">'.$row->reject_bid_count.'</label></a> ';
                        }
                        
                        if($row->closed_bid_count > 0){
                            $closed_bid ='<a href="'.route('admin-bid-property-wise-get',[@$row->getBids[0]->property_id,"Closed"]).'" title="Closed Bid"><label class="badge badge-danger" style="cursor:pointer">'.$row->closed_bid_count.'</label></a> ';
                        }
                    
                        if($row->cancelled_bid_count > 0){
                            $cancelled_bid ='<a href="'.route('admin-bid-property-wise-get',[@$row->getBids[0]->property_id,"Cancelled"]).'" title="Cancelled Bid"><label class="badge badge-inverse" style="cursor:pointer">'.$row->cancelled_bid_count.'</label></a>';
                        } 

                     
                        if(!empty(@$row->SaleOffer)){
                            $remainTime=daysLeftToExpireProperty(@$row->SaleOffer->date_end,@$row->SaleOffer->time_end);
                              
                                $timer =' <a href="'.route('admin-property-sales-edit',[@$row->SaleOffer->id]).'" title="Edit Timer"><label class="badge badge-inverse" style="cursor:pointer"><i class="fa fa-timer"></i>'.$remainTime.'</label></a>';
                        }
                           
                        $title=$title_start.$title_mid.$new_bid.$award_bid.$reject_bid.$closed_bid.$cancelled_bid.@$timer;
                        return $title;
                    }) 
                    ->addColumn('state', function($row){
                        $state = @$row->getPropertyState->name ? $row->getPropertyState->name : "";

                        return $state;
                    }) 
                    ->addColumn('city', function($row){
                        $city = @$row->getPropertyCity->name ? $row->getPropertyCity->name : "";

                        return $city;
                    }) 
                    ->addColumn('status', function($row){
                        $status = $row->status;
                        if($status==1){
                            $status='<span class="badge badge-success badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
                        }else{
                             $status='<span class="badge badge-danger badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Inactive</span>';
                        }
                        return $status;
                    }) 
                    ->addColumn('escrow_status', function($row){
                        
                        $escrow_statuss = $row->escrow_status;
                        if($escrow_statuss=="Active"){
                            $escrow_status='<span class="badge badge-success" id="'.$row->id.'">Active</span>';
                        }
                        if($escrow_statuss=="Pending"){
                            $escrow_status='<span class="badge badge-warning" id="'.$row->id.'">Pending</span>';
                        }
                        if($escrow_statuss=="Cancelled"){
                            $escrow_status='<span class="badge badge-inverse"  id="'.$row->id.'">Cancelled</span>';
                        }
                        if($escrow_statuss=="Sold"){
                             $escrow_status='<span class="badge badge-danger" id="'.$row->id.'">Sold</span>';
                        }
                        return $escrow_status;
                    }) 
                    ->addColumn('delete_status', function($row){
                        $delete_status = $row->delete_status;
                        if($delete_status==1){
                            $delete_status='<span class="badge badge-danger" style="cursor: pointer;">Deleted</span>';
                        }else{
                             $delete_status='<span class="badge badge-info badge_delete_status_change" id="'.$row->id.'" style="cursor: pointer;">Not Deleted</span>';
                        }
                        return $delete_status;
                    }) 
                    ->addColumn('created_at', function ($data) {
                        $created_date=date('M d, Y g:i A', strtotime($data->created_at));
                        return $created_date;   
                    })
                    ->addColumn('action__', function($row){
                        $route=route('admin-property-edit',$row->slug);
                        $route_view=route('admin-property-details',$row->slug);
                        $route_gallery=route('admin-property-gallery-view',$row->slug);

                        if(!empty($row->getBids) &&  ($row->award_bid_count  > 0 || $row->closed_bid_count  > 0)){
                            $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a> <a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> <a href="'.$route_gallery.'" title="Upload Gallery" class="btn btn-inverse btn-sm"><i class="fa fa-upload"></i></a><button type="button" class="btn btn-primary btn-sm closeofescrowbtn" data-toggle="modal" data-target="#propertyEscrowModal" data-id="'.$row->id.'" title="Close of Escrow Status"><i class="fa fa-copy"></i></button><button title="delete" class="btn btn-danger btn-sm badge_delete_status_change" id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                            return $action;
                        }else{
                            $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a> <a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> <a href="'.$route_gallery.'" title="Upload Gallery" class="btn btn-inverse btn-sm"><i class="fa fa-upload"></i></a><button title="delete" class="btn btn-danger btn-sm badge_delete_status_change" id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                            return $action; 
                        }  
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
                       
                        // if(!empty($request->get('country'))) {
                        //     $instance->where('country', $request->get('country'));
                        // }

                        if(!empty($request->get('state'))) {
                            $instance->where('state', $request->get('state'));
                        }

                        if(!empty($request->get('property_type'))) {
                            $instance->where('property_type', $request->get('property_type'));
                        }

                        if(!empty($request->get('city'))) {
                            $instance->whereIn('city', $request->get('city'));
                        }
                     
                        if($request->get('status') == '0' || $request->get('status') == '1') {
                            $instance->where('status', $request->get('status'));
                        }

                        if($request->get('escrow_status')) {
                            $instance->where('escrow_status', $request->get('escrow_status'));
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
             return view('admin::property.active_property',compact('stateList','propertyTypeList'));  
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
            return view('admin::property.add',compact('catType','PropOwnerList'));
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
                'built_in_year'=>'required|numeric',
                'no_of_kitchen'=>'required|numeric',
                'no_of_bathroom'=>'required|numeric',
                'no_of_pool'=>'required|numeric',
                'no_of_garden'=>'required|numeric',
                'no_of_balcony'=>'required|numeric',
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

		        'property_area.required'=>'Property area field can’t be left blank',
		        'property_area.numeric'=>'Property area field allows only numbers.',
		        'property_number.required'=>'Property Number field can’t be left blank',

		         'property_email.required'=>'Property email field can not be empty',
        		'property_email.email'=>'Please enter a valid email address',
                'property_address.required'=>'Property address field can’t be left blank',
                'property_price.required'=>'Property address field can’t be left blank',
                'property_price_type.required'=>'Property price type is required.',
		      ]);

           
            $fileNameToStore="";
            //Upload Image
            if($request->hasFile('image')){
                $fileNameToStore=uploadImage($request->file('image'),"images/property/thumbnail",'');
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
            $property->property_area=$data['property_area'];
            $property->property_number=$data['property_number'];
            $property->property_address=$data['property_address'];
            $property->property_latitude=$data['property_latitude'];
            $property->property_longitude=$data['property_longitude'];
            $property->property_email=$data['property_email'];
            $property->property_price=$data['property_price'];
            $property->property_price_type=$data['property_price_type'];
            $property->property_category=$data['property_category'];
            $property->meta_title=$data['meta_title'];
            $property->meta_keywords=$data['meta_keywords'];
            $property->meta_description=$data['meta_description'];
            $property->property_description=$data['property_description'];
            $property->built_in_year=$data['built_in_year'];
            $property->property_image=$fileNameToStore;
            $property->property_status=1;
            $property->save();

            toastr()->success('Property information saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->route('admin-property-gallery-view',$property->id)->with('success',"Property information saved successfully. Now add property Images to publish your property");
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
            $catTypeList = Category::where('status',1)->orderBy('name','ASC')->get();
            return view('admin::property.edit', compact('propertyInfo','catTypeList'));
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');            
        }
    }
    public function update(EditPropertyRequest $request){
        $old_img="";
        $emd_amount="";
        $emd_coe="";
        $data = $request->all();
        try {

            $base_price = intval(str_replace(array(',', '$', ' '), '', $data["base_price"]));

            $seller_price = intval(str_replace(array(',', '$', ' '), '', $data["seller_price"]));
            

            $lot_size = intval(rtrim(str_replace(array(',', ' '), '', $data["lot_size"]),0));
            $property_size = intval(rtrim(str_replace(array(',', ' '), '', $data["property_size"]),0));

            if($data['emd_amount'] != ""){
                $emd_amount = intval(str_replace(array(',', '$', ' '), '', $data["emd_amount"]));
            }

            if($data['emd_coe'] != ""){
                $emd_coe = date('Y-m-d',strtotime($data["emd_coe"]));
            }

            $property=Property::where('slug',$data['slug'])->first();
            
            if($property){
                //Upload User Image
                $old_img=$property->getRawOriginal('image');  
            }
             
            if($request->hasFile('image')){

                $data['image']=uploadImage($request->file('image'),"public/uploads/property/",$old_img);

                Storage::disk('local')->delete('public/uploads/property/'.$old_img);

                $propertyGalleryImage=PropertyGallery::where([['name',"Featured Image"],['property_id',$property->id]])->first();
                $oldimg_gallery=$propertyGalleryImage->getRawOriginal('attachment');
                
                if($propertyGalleryImage->count()>0){

                    $fileNameToStoreGallery=uploadImage($request->file('image'),"public/uploads/PropertyGallery",$oldimg_gallery);
                    Storage::disk('local')->delete('public/uploads/PropertyGallery/'.$oldimg_gallery);

                    PropertyGallery::where('id',$propertyGalleryImage->id)->update(['attachment'=>$fileNameToStoreGallery]);
                }else{

                    $fileNameToStoreGallery=uploadImage($request->file('image'),"public/uploads/PropertyGallery",'');  
                    PropertyGallery::create([
                    'property_id'=>$property->id,
                    'attachment'=>$fileNameToStoreGallery,
                    'type'=>"Image",
                    'name'=>"Featured Image",
                    'is_featured'=>1,
                    'add_by' => auth()->user()->id
                    ]);
                }
            }
            else{
                $data['image'] = $property->getRawOriginal('image');
            }
            
            $propertyData = ["title"=>$data['title'],
            //"address"=>$data['address'],
            "location"=>$data['location'],
            "state"=>$data['state'],
            "city"=>$data['city'],
            "country"=>$data['country'],
            "image"=>$data['image'],
           // "zipcode"=>$data['zipcode'],
            "latitude"=>$data['latitude'],
            "longitude"=>$data['longitude'],
            "property_size"=>$property_size,
            "property_type"=>$data['property_type'],
            "base_price"=>$base_price,
            "lot_size"=>$lot_size,
            "emd_due"=>$data['emd_due'],
            "emd_coe"=>$emd_coe,
            "emd_amount"=>$emd_amount,
            "seller_price"=>$seller_price,
            //"price_from"=>$data['base_price'],
            //"price_to"=>$data['price_to'],
            "currency_type"=>"dollar",
            "year_from"=>$data['year_from'],
            //"year_to"=>$data['year_to'],
            "no_of_bathroom"=>$data['no_of_bathroom'],
           // "no_of_roof"=>$data['no_of_roof'],
            "description"=>$data['description'],
            "no_of_bedroom"=>$data['no_of_bedroom']
            ]; 

            Property::where('id',$property->id)->update($propertyData);
            toastr()->success('Property information updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);    
            return redirect()->route('admin-property-list')->with('success','Property info updated successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'something wrong');
        }
    }
    public function updatePropertyStatus(Request $request){
        try{
            $propertyInfo=Property::with('getPropertyCity','getPropertyState')->where('id', $request->id)->first();
            if($propertyInfo->status == 1){
              $data = [ "status"=>0, "status_type"=>"Manual"];
              Property::where('id', $request->id)->update($data);

                $userIntrestedCity=IntrestedCity::where('city_id',$propertyInfo->city)->pluck('user_id')->all();
                if(!empty($userIntrestedCity)){
                    //PUSH NOTIFICATION TO ALL BUYER
                    $title="Offercity Added a New Property";
                    $description="Offercity Added a New Property- ".$propertyInfo->title.",Bed-".$propertyInfo->no_of_bedroom.", Bath-".$propertyInfo->no_of_bathroom.", Sqft-".$propertyInfo->property_size.", City-".$propertyInfo->getPropertyCity->name.", State-".$propertyInfo->getPropertyState->name.".";
                    $payload=["property_id"=>$propertyInfo->id];
                    $buyersList=User::whereIn('id',$userIntrestedCity)->where('status',1)->where('delete_status',0)->get();
                    if(isset($buyersList) && !empty($buyersList)){
                        foreach($buyersList as $bli){
                            $bli->notify(new AdminPublishPropertyNotification(Auth::user(),$propertyInfo));
                        }
                    }
                    $this->pushNotification($title,$description,$payload,$userIntrestedCity);
                } 
               return response()->json(["status" => "success"]);


            }else{
                $galleryInfo =PropertyGallery::where([['is_featured',1],['property_id',$request->id]])->get();
                if($galleryInfo->count() < 5){
                    return response()->json(["status" => "fail"]);
                }else{
                    $data = ["status"=>1,"status_type"=>""];
                    Property::where('id', $request->id)->update($data);
                  
                    return response()->json(["status" => "success"]);
                }
            }    
        }
        catch(Exception $e){  
            return redirect()->back()->with('error', 'something wrong');     
        }  
    }
    public function deleteProperty(Request $request){
        try{
            $data = ["delete_status"=>1];
            Property::where('id', $request->id)->update($data);  
            return response()->json(["success" => "1"]);
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');     
        }  
    }

    public function ajaxgetcategorylist(Request $request)
    {
        $property_type=$request->property_type;
        if($property_type!="")
        {
            $categorylist=Category::where('status',1)->where('category_type',$property_type)->get();
            if($categorylist)
            {
                $categorylistarr=$categorylist->toArray();
                $categoryhtml='<option value="">Select Category</option>';
                foreach($categorylistarr as $list)
                {
                    $categoryhtml.='<option value="'.$list['id'].'">'.$list['name'].'</option>';
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

    public function show($slug){
        try{

            $propertyInfo=Property::with(['getPropertyType','getBids' => function($q){
                $q->where('delete_status', '=', "0")->get();
            }])->withCount([
                'getBids as new_bid_count' => function ($query) {
                    $query->where('bid_status', "Active");
                    $query->where('delete_status', 0);
                },
                'getBids as award_bid_count' => function ($query) {
                    $query->where('bid_status', "Awarded");
                    $query->where('delete_status', 0);
                },
                'getBids as reject_bid_count' => function ($query) {
                    $query->where('bid_status', "Rejected");
                    $query->where('delete_status', 0);
                },
                'getBids as closed_bid_count' => function ($query) {
                    $query->where('bid_status', "Closed");
                    $query->where('delete_status', 0);
                },
                'getBids as cancelled_bid_count' => function ($query) {
                    $query->where('bid_status', "Cancelled");
                    $query->where('delete_status', 0);
                }
            ])->where('slug',$slug)->first();


              $galleryList=PropertyGallery::where('property_id',$propertyInfo->id)->where('type',"Image")->orderBy('id','DESC')->get();
              $vgalleryList=PropertyGallery::where('property_id',$propertyInfo->id)->where('type',"Video")->orderBy('id','DESC')->get();
              $dgalleryList=PropertyGallery::where('property_id',$propertyInfo->id)->where('type',"Document")->orderBy('id','DESC')->get();

              
              $bids =  Bid::with(['BidderInfo','BidPropertyInfo'])->where('property_id',$propertyInfo->id)->where('delete_status',0)->get();
              $offerTimer =  PropertyOffer::with('OfferPropertyInfo')->where('property_id',$propertyInfo->id)->where('delete_status',0)->get();
              $favProperty =   FavProperty::with('favPropertyUsersInfo')->where('property_id',$propertyInfo->id)->get();

         
            return view('admin::property.show',compact('propertyInfo','galleryList','vgalleryList','dgalleryList','bids','offerTimer','favProperty'));  
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'something wrong');     
        }  
    }
    public function propertyWiseBidList(Request $request){
        $property_id=$request->property_id;

      if($request->ajax()) {   
        $data =  Bid::with(['BidderInfo','BidPropertyInfo'])->where([['delete_status',0],['property_id',$property_id]])->orderBy('bid_price','DESC')->latest();
       
                return Datatables::of($data)
                    ->addIndexColumn()
                  
                    ->addColumn('bidder_name', function($row){
                        $bidder_name = "<a href=".route('admin-user-details',$row->bidder_id).">".$row->BidderInfo->name."</a>";
                        return $bidder_name;
                    }) 
                    ->addColumn('property_name', function($row){
                        $property_name =  "<a href=".route('admin-property-details',$row->BidPropertyInfo->slug).">".$row->BidPropertyInfo->title."</a>";
                        return $property_name;
                    })
                    ->addColumn('offer_id', function($row){
                        $offer_id = $row->offer_id;
                        return $offer_id;
                    })
                    ->addColumn('bid_price', function($row){
                        $bid_price = moneyFormat($row->bid_price);
                        return $bid_price;
                    })
                   
                      ->addColumn('bid_status', function($row){
             
          if($row->bid_status=="Active"){
             $bid_status='<button type="button" class="btn btn-primary btn-new btn-sm dropdown-toggle bid_status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$row->bid_status.'</button> <div class="dropdown-menu dropdown-menu-right b-none contact-menu"><button class="dropdown-item bid_status_btn" data-id="'.$row->id.'" data-status="Awarded"><i class="fa fa-check"></i>Awarded</button><button class="dropdown-item bid_status_btn" data-id="'.$row->id.'" data-status="Rejected"><i class="fa fa-times"></i>Rejected</button></div>';
             
           

          } else if($row->bid_status=="Awarded"){
             $bid_status='<button type="button" class="btn btn-primary btn-awarded btn-sm dropdown-toggle bid_status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$row->bid_status.'</button> <div class="dropdown-menu dropdown-menu-right b-none contact-menu"><button class="dropdown-item bid_status_btn" data-id="'.$row->id.'" data-status="Rejected"><i class="fa fa-times"></i>Rejected</button></div>';
             

          } else if($row->bid_status=="Closed"){
             $bid_status='<button type="button" class="btn btn-primary btn-closed btn-sm  bid_status">'.$row->bid_status.'</button>';
          }
            else if($row->bid_status=="Cancelled"){
             $bid_status='<button type="button" class="btn btn-primary btn-cancelled btn-sm  bid_status">'.$row->bid_status.'</button>';
          }
          else if($row->bid_status=="Blocked"){
             $bid_status='<button type="button" class="btn btn-primary btn-blocked btn-sm  bid_status">'.$row->bid_status.'</button>';
          }
          else{
             $bid_status='<button type="button" class="btn btn-primary btn-rejected btn-sm dropdown-toggle bid_status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$row->bid_status.'</button> <div class="dropdown-menu dropdown-menu-right b-none contact-menu"><button class="dropdown-item bid_status_btn" data-id="'.$row->id.'" data-status="Awarded"><i class="fa fa-check"></i>Awarded</button></div>';
             
          }
           return $bid_status;
           
          }) 
                  ->addColumn('bid_type', function($row){
                        $bid_type = $row->bid_type;
                        if($bid_type=="old"){
                            $bid_type='<span class="badge badge-danger">Old</span>';
                        }else{
                             $bid_type='<span class="badge badge-info">New</span>';
                        }
                        return $bid_type;
                    }) 
                   
                    ->addColumn('status', function($row){
                        $status = $row->status;
                        if($status==1){
                            $status='<span class="badge badge-success bid_badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
                        }else{
                             $status='<span class="badge badge-danger bid_badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Inactive</span>';
                        }
                        return $status;
                    }) 
                    ->addColumn('delete_status', function($row){
                        $delete_status = $row->delete_status;
                        if($delete_status==1){
                            $delete_status='<span class="badge badge-danger" style="cursor: pointer;">Deleted</span>';
                        }else{
                             $delete_status='<span class="badge badge-info badge_delete_status_change" id="'.$row->id.'" style="cursor: pointer;">Not Deleted</span>';
                        }
                        return $delete_status;
                    }) 
                    ->addColumn('created_at', function ($data) {
                        $created_date=date('M d, Y g:i A', strtotime($data->created_at));
                        return $created_date;   
                    })
                    ->addColumn('action__', function($row){
                      
                       $route_view=route('admin-bid-view',$row->id);
                        $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>';
                        return $action;
                    })  

                    ->filter(function ($instance) use ($request) {
                         if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->Where('bid_price', 'LIKE', "%$search%");
                                //->orWhere('bidder', 'LIKE', "%$search%")
                            
                            });
                        }
                       
                     
                        if($request->get('status') == '0' || $request->get('status') == '1') {
                            $instance->where('status', $request->get('status'));
                        }

                         if($request->get('bid_type')) {
                            $instance->where('bid_type', $request->get('bid_type'));
                        }
                        
                        if ($request->get('delete_status') == '0' || $request->get('delete_status') == '1') {
                            $instance->where('delete_status', $request->get('delete_status'));
                        }

                        if ($request->get('bid_status')) {
                          $instance->where('bid_status', $request->get('bid_status'));
                        }

                         if ($request->get('property_offer')) {
                          $instance->where('offer_id', $request->get('property_offer'));
                        }

                        if(!empty($request->get('property_id'))) {
                          $instance->where('property_id', $request->get('property_id'));
                        }

                        if(!empty($request->get('bidder_id'))) {
                          $instance->where('bidder_id', $request->get('bidder_id'));
                        }
                        
                        if(!empty($request->get('bid_price_from'))  &&  !empty($request->get('bid_price_to'))) {
                          $instance->where(function($w) use($request){
                            $start_price = $request->get('bid_price_from');
                            $end_price = $request->get('bid_price_to');
                          
                            $w->orwhereRaw("bid_price >= '" . $start_price . "' AND bid_price <= '" . $end_price . "'");
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
    }
    public function softDeletedProperty(Request $request) {
       try{
            $stateList = State::where([['status',1],['delete_status',0]])->get(); 
            if($request->ajax()) {   
                $data =  Property::where('delete_status',1)->latest();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function($row){
                        $image = '';
                        $route_view=route('admin-property-details',$row->id);
                        $image = '<img class="img-circle" src="'.$row->image.'" height="50" width="50" id="thumbnil">';
                        
                        return $image;
                    })
                    ->addColumn('title', function($row){
                        $title = $row->title;
                        return $title;
                    }) 
                   
                    ->addColumn('state', function($row){
                        $state = @$row->getPropertyState->name ? $row->getPropertyState->name : "";

                        return $state;
                    }) 
                    ->addColumn('city', function($row){
                        $city = @$row->getPropertyCity->name ? $row->getPropertyCity->name : "";

                        return $city;
                    }) 
                   
                    ->addColumn('status', function($row){
                        $status = $row->status;
                        if($status==1){
                            $status='<span class="badge badge-success badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
                        }else{
                             $status='<span class="badge badge-danger badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Inactive</span>';
                        }
                        return $status;
                    }) 
                    ->addColumn('delete_status', function($row){
                        $delete_status = $row->delete_status;
                        if($delete_status==1){
                            $delete_status='<span class="badge badge-danger" style="cursor: pointer;">Deleted</span>';
                        }else{
                             $delete_status='<span class="badge badge-info badge_delete_status_change" id="'.$row->id.'" style="cursor: pointer;">Not Deleted</span>';
                        }
                        return $delete_status;
                    }) 
                    ->addColumn('created_at', function ($data) {
                        $created_date=date('M d, Y g:i A', strtotime($data->created_at));
                        return $created_date;   
                    })
                    ->addColumn('action__', function($row){
                       
                        $route_view=route('admin-property-details',$row->slug);
                        $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a> <button title="restore" class="btn btn-primary btn-sm badge_restore" data-id="'.$row->id.'"> <i class="fa fa-refresh"></i></button><button title="delete" class="btn btn-danger btn-sm badge_delete_status_change" id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                       
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

                        if(!empty($request->get('state'))) {
                            $instance->where('state', $request->get('state'));
                        }

                        if(!empty($request->get('city'))) {
                            $instance->whereIn('city', $request->get('city'));
                        }
                     
                        if($request->get('status') == '0' || $request->get('status') == '1') {
                            $instance->where('status', $request->get('status'));
                        }
                        
                        if ($request->get('delete_status') == '0' || $request->get('delete_status') == '1') {
                            $instance->where('delete_status', $request->get('delete_status'));
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
                return view('admin::property.soft-deleted-property',compact('stateList'));
            }
        catch(Exception $e){
          return redirect()->back()->with('error', 'something wrong');     
        }    
    }
    public function restoreProperty(Request $request){
        try{
          $data = ["delete_status"=>0,"status"=>1];
          Property::where('id', $request->id)->update($data);  
          return response()->json(["success" => "1"]);
        }
        catch(Exception $e){
          return redirect()->back()->with('error', 'something wrong');     
        }  
    }
    public function destroyPropertyData(Request $request){
        try{
          Property::where('id', $request->id)->delete();  
          return response()->json(["success" => "1"]);
        }
        catch(Exception $e){
          return redirect()->back()->with('error', 'something wrong');     
        }  
    }
    public function ajaxGetPropertyInfo(Request $request){
        try{
            $propertyInfo=Property::where('id', $request->property_id)->first();
            $bidInfo=Bid::with('BidderInfo')->where([['property_id',$propertyInfo->id]])->get();
            foreach($bidInfo as $li){
                if($li->bid_status=="Awarded"){
                     return response()->json(["bid_status"=>"Awarded","result"=>$propertyInfo,"bid_info"=>$li,"status"=>"success"]);
                }elseif($li->bid_status=="Closed"){
                     return response()->json(["bid_status"=>"Closed","result"=>$propertyInfo,"bid_info"=>$li,"status"=>"success"]);
                }elseif($li->bid_status=="Blocked"){
                     return response()->json(["bid_status"=>"Blocked","result"=>$propertyInfo,"bid_info"=>$li,"status"=>"success"]);

                }
            }   
        }
        catch(Exception $e){
          return response()->json(["result"=>$propertyInfo,"status"=>"error"]); 
        }   
    }
    //Escrow cancelled only when bidder awarded and escrow status sold.
    //If  escrow cancelled bidder bid blocked from awarded and bidder cant place bid on same property in future.
    public function ajaxSetEscrowStatus1(Request $request){
        try{
            $propertyInfo=Property::where('id', $request->property_id)->first(); 
            $bidInfo=Bid::with('BidderInfo')->where([['id', $request->bid_id]])->first(); 
            $bidderInfo=User::where('id', $request->bidder_id)->first(); 
            $otherBid=Bid::where([['property_id', $request->property_id],['bidder_id','!=',$request->bidder_id]])->get(); 
            if($request->escrow_status == "Cancelled"){

                $update=Property::where('id', $request->property_id)->update(['escrow_status'=>$request->escrow_status]); 
                Bid::where('id',$request->bid_id)->update(["bid_status"=>"Blocked"]);
                Bid::where('property_id',$request->property_id)->where('bid_status',"Cancelled")->update(["bid_status"=>"Active","bid_type"=>"old"]);

                //NOTIFICATION TO BUYER
                $bidderInfo->notify(new AdminCancelledPropertyNotification(Auth::user(),$propertyInfo));

                $sms_dynamic_params=[$bidderInfo->name,$propertyInfo->title,$propertyInfo->base_price,$propertyInfo->property_code];

                $receiverNumber = $bidderInfo->country_std_code.$bidderInfo->mobile_no;
                
                dispatch(new SendAddBidSMSToBidders([$receiverNumber,"property_cancel_sms",$sms_dynamic_params]));
                $mailParams=[$bidderInfo->name,moneyFormat($bidInfo->bid_price),$propertyInfo->title,moneyFormat($propertyInfo->base_price),$propertyInfo->property_code,numberPlaceFormat($propertyInfo->property_size),$propertyInfo->location];

                $mail_data=["mail_action_name"=>"property_cancelled_by_admin",
                            "mail_short_code_variable"=>$mailParams,
                            "email"=>$bidderInfo->email,
                            "username"=>$bidderInfo->name,
                            "property_name"=>$propertyInfo->title,
                            "location"=>$propertyInfo->location,
                            "escrow_status"=>$propertyInfo->escrow_status,
                            "property_image"=>$propertyInfo->image,
                            "message_top"=>"",
                            "message_top_heading"=>"The Property has been cancelled to sell"];
                    
                dispatch(new SendPropertyMail($mail_data));
               
                //MAIL SMS TO OTHER BIDDERS
                foreach($otherBid as $li){
                    $bidders=User::where('id',$li->bidder_id)->first();
                    //NOTIFICATION TO BUYER
                    $bidders->notify(new AdminCancelledPropertyNotification(Auth::user(),$propertyInfo));
              
                    //SMS CANCEL BID
                    $message= "Offercity: hey ".$bidders->name." The property you placed bid has cancelled escrow and now the property ready to place bids.";
                    
                    $receiverNumber = $bidders->country_std_code.$bidders->mobile_no;
                    $sms_dynamic_params=[
                    $bidders->name,
                    $propertyInfo->title,
                    $propertyInfo->property_code,
                    moneyFormat($propertyInfo->base_price)];
                    dispatch(new SendAddBidSMSToBidders([$receiverNumber,"property_cancel_sms",$sms_dynamic_params]));
                   
                    $mailParams=[
                        $bidders->name,
                        $li->bid_price,
                        $propertyInfo->title,
                        moneyFormat($propertyInfo->base_price),
                        $propertyInfo->property_code,
                        numberPlaceFormat($propertyInfo->property_size),
                        $propertyInfo->location];

                    $mail_datas=["mail_action_name"=>"property_cancelled_by_admin",
                          "mail_short_code_variable"=>$mailParams,
                          "email"=>$bidders->email,
                          "username"=>$bidders->name,
                          "property_name"=>$propertyInfo->title,
                          "location"=>$propertyInfo->location,
                          "escrow_status"=>$propertyInfo->escrow_status,
                          "property_image"=>$propertyInfo->image,
                          "message_top"=>"",
                          "message_top_heading"=>"Property has been cancelled to sell."];
                        
                    dispatch(new SendPropertyMail($mail_datas));
                }

                return response()->json(["status"=>"success","escrow"=>"Cancelled","message"=>"Property Escrow Cancelled"]);
            }
            if($request->escrow_status=="Sold"){
                $update=Property::where('id', $request->property_id)->update(['escrow_status'=>$request->escrow_status]); 
                Bid::where('id',$request->bid_id)->update(["bid_status"=>"Closed"]);
                ///////////////
                $mailParams=[$bidderInfo->name,moneyFormat($bidInfo->bid_price),$propertyInfo->title,moneyFormat($propertyInfo->base_price),$propertyInfo->property_code,numberPlaceFormat($propertyInfo->property_size),$propertyInfo->location];

                $mail_data_buyer=["mail_action_name"=>"property_sold",
                            "mail_short_code_variable"=>$mailParams,
                            "email"=>$bidderInfo->email,
                            "username"=>$bidderInfo->name,
                            "property_name"=>$propertyInfo->title,
                            "location"=>$propertyInfo->location,
                            "escrow_status"=>$propertyInfo->escrow_status,
                            "property_image"=>$propertyInfo->image,
                            "message_top"=>"Congratulations",
                            "message_top_heading"=>"The property has been sold to you."];
                    
                dispatch(new SendPropertyMail($mail_data_buyer));
                $bidderInfo->notify(new AdminSoldPropertyNotification(Auth::user(),$propertyInfo));

              
                foreach($otherBid as $li){
                    $bidders=User::where('id',$li->bidder_id)->first();
                    //NOTIFICATION TO BUYER
                    $bidders->notify(new AdminSoldPropertyNotificationOther(Auth::user(),$propertyInfo,$bidderInfo));
                    $receiverNumber = $bidders->country_std_code.$bidders->mobile_no;
                    $sms_params=[$bidders->name,
                                $bidderInfo->name
                    ];
                    //USER_NAME,BIDDER_NAME,BIDPRICE,PROPERTYNAME,PROPERTYCODE
                    dispatch(new SendAddBidSMSToBidders([$receiverNumber,"sold_property_sms_to_bidder",$sms_params]));

                    $mailParams=[$bidders->name,moneyFormat($li->bid_price),$propertyInfo->title,moneyFormat($propertyInfo->base_price),$propertyInfo->property_code,numberPlaceFormat($propertyInfo->property_size),$propertyInfo->location];

                    $mail_data=["mail_action_name"=>"property_sold",
                    "mail_short_code_variable"=>$mailParams,
                    "email"=>$bidders->email,
                    "username"=>$bidders->name,
                    "property_name"=>$propertyInfo->title,
                    "location"=>$propertyInfo->location,
                    "escrow_status"=>$propertyInfo->escrow_status,
                    "property_image"=>$propertyInfo->image,
                    "message_top"=>"Congratulations",
                    "message_top_heading"=>"The Property has been sold"];
                    
                    dispatch(new SendPropertyMail($mail_data));
                }
                return response()->json(["status"=>"success","escrow"=>"Sold","message"=>"Property Sold to ".$bidderInfo->name]);
            }
        }
        catch(Exception $e){
          return response()->json(["status"=>"error"]); 
        }    
    }
    public function ajaxSetEscrowStatus(Request $request){
        try{
            $propertyInfo=Property::where('id', $request->property_id)->first(); 
            $bidInfo=Bid::with('BidderInfo')->where([['id', $request->bid_id]])->first(); 
            $bidderInfo=$bidInfo->BidderInfo;
            $otherBid=Bid::with('BidderInfo')->where([['property_id', $request->property_id],['bidder_id','!=',$request->bidder_id]])->get(); 
            
            if($request->escrow_status == "Cancelled"){

               $propertyInfo->escrow_status=$request->escrow_status;
               $propertyInfo->save();
               $propertyInfo->refresh();

               $bidInfo->bid_status="Blocked";
               $bidInfo->save();
               $bidInfo->refresh();

                //RE-ACTIVE OTHER BIDS OF THIS PROPERTY 
                Bid::where('property_id',$request->property_id)->where('bid_status',"Cancelled")->update(["bid_status"=>"Active","bid_type"=>"old"]);

                //NOTIFICATION TO BUYER
                $bidderInfo->notify(new AdminCancelledPropertyNotification(Auth::user(),$propertyInfo));

                $sms_dynamic_params=[$bidderInfo->name,$propertyInfo->title,$propertyInfo->base_price,$propertyInfo->property_code];

                $receiverNumber = $bidderInfo->country_std_code.$bidderInfo->mobile_no;
               
                dispatch(new SendAddBidSMSToBidders([$receiverNumber,"property_cancel_sms",$sms_dynamic_params]));
                
                $mailParams=[$bidderInfo->name,
                            moneyFormat($bidInfo->bid_price),
                            $propertyInfo->title,
                            moneyFormat($propertyInfo->base_price),
                            $propertyInfo->property_code,
                            numberPlaceFormat($propertyInfo->property_size),
                            $propertyInfo->location
                ];

                $mail_data=["mail_action_name"=>"property_cancelled_by_admin",
                            "mail_short_code_variable"=>$mailParams,
                            "email"=>$bidderInfo->email,
                            "username"=>$bidderInfo->name,
                            "property_name"=>$propertyInfo->title,
                            "location"=>$propertyInfo->location,
                            "escrow_status"=>$propertyInfo->escrow_status,
                            "property_image"=>$propertyInfo->image,
                            "message_top"=>"",
                            "message_top_heading"=>"The Property has been cancelled to sell"
                ];
                    
                dispatch(new SendPropertyMail($mail_data));
                //PUSH NOTIFICATION TO BUYER APP WHEN HIS BID AWARDED
                $title="Offercity Cancelled Property to Sold";
                $description="Offercity cancelled escrow to sold property ".$propertyInfo->title.".";
                

                $payload=["property_id"=>$propertyInfo->id];

                $this->pushNotification($title,$description,$payload,array($bidderInfo->id));
               
                //MAIL SMS TO OTHER BIDDERS
                foreach($otherBid as $li){
                    $bidders=$li->BidderInfo;
                    //NOTIFICATION TO BUYER
                    $bidders->notify(new AdminCancelledPropertyNotificationOther(Auth::user(),$propertyInfo));
                    $receiverNumber = $bidders->country_std_code.$bidders->mobile_no;
                    $sms_dynamic_params=[
                    $bidders->name,
                    $propertyInfo->title,
                    $propertyInfo->property_code,
                    moneyFormat($propertyInfo->base_price)];
                    dispatch(new SendAddBidSMSToBidders([$receiverNumber,"property_cancel_sms",$sms_dynamic_params]));
                    $mailParams=[
                        $bidders->name,
                        moneyFormat($li->bid_price),
                        $propertyInfo->title,
                        moneyFormat($propertyInfo->base_price),
                        $propertyInfo->property_code,
                        numberPlaceFormat($propertyInfo->property_size),
                        $propertyInfo->location
                    ];
                    $mail_datas=["mail_action_name"=>"property_cancelled_by_admin",
                          "mail_short_code_variable"=>$mailParams,
                          "email"=>$bidders->email,
                          "username"=>$bidders->name,
                          "property_name"=>$propertyInfo->title,
                          "location"=>$propertyInfo->location,
                          "escrow_status"=>$propertyInfo->escrow_status,
                          "property_image"=>$propertyInfo->image,
                          "message_top"=>"",
                          "message_top_heading"=>"Property has been cancelled to sell."];
                        
                    dispatch(new SendPropertyMail($mail_datas));
                  
                    //PUSH NOTIFICATION
                    $title="Offercity Cancelled Property to Sold";
                    $description="Offercity cancelled escrow to sold property ".$propertyInfo->title.".";
                    $payload=["property_id"=>$propertyInfo->id];
                   
                    $this->pushNotification($title,$description,$payload,array($li->bidder_id));
                    
                }

                return response()->json(["status"=>"success","escrow"=>"Cancelled","message"=>"Property Escrow Cancelled"]);
            }
            if($request->escrow_status=="Sold"){
                $propertyInfo->escrow_status=$request->escrow_status;
                $propertyInfo->save();
                $propertyInfo->refresh();

                $bidInfo->bid_status="Closed";
                $bidInfo->save();
                $bidInfo->refresh();

                //UPDATE SALE STATUS 0 WHEN PROPERTTY SOLD OUT
                 $offer=PropertyOffer::where('property_id', $request->property_id)->first(); 
                $offer->sale_status=0;
                $offer->save();
                $offer->refresh();

                $mailParams=[$bidderInfo->name,moneyFormat($bidInfo->bid_price),$propertyInfo->title,moneyFormat($propertyInfo->base_price),$propertyInfo->property_code,numberPlaceFormat($propertyInfo->property_size),$propertyInfo->location];

                $mail_data_buyer=["mail_action_name"=>"property_sold",
                                "mail_short_code_variable"=>$mailParams,
                                "email"=>$bidderInfo->email,
                                "username"=>$bidderInfo->name,
                                "property_name"=>$propertyInfo->title,
                                "location"=>$propertyInfo->location,
                                "escrow_status"=>$propertyInfo->escrow_status,
                                "property_image"=>$propertyInfo->image,
                                "message_top"=>"Congratulations",
                                "message_top_heading"=>"The property has been sold to you."
                ];
                    
                dispatch(new SendPropertyMail($mail_data_buyer));
                //NOTIFICATION TO BUYER WHO BUY PROPERTY
                $bidderInfo->notify(new AdminSoldPropertyNotification(Auth::user(),$propertyInfo,$bidderInfo));
               
                foreach($otherBid as $li){
                    $bidders=$li->BidderInfo;
                    //NOTIFICATION TO OTHER BUYER
                    $bidders->notify(new AdminSoldPropertyNotificationOther(Auth::user(),$propertyInfo,$bidderInfo));
                  
                    $sms_params_bid_sold_other=[$bidders->name,
                        $bidderInfo->name,
                        moneyFormat($bidInfo->bid_price),
                        $propertyInfo->title,
                        $propertyInfo->property_code
                    ];
                    
                    $receiverNumber = $bidders->country_std_code.$bidders->mobile_no;
                    dispatch(new SendAddBidSMSToBidders([$receiverNumber,"sold_property_sms_to_bidder",$sms_params_bid_sold_other]));

                    $mailParams=[$bidders->name,
                        moneyFormat($li->bid_price),
                        $propertyInfo->title,
                        moneyFormat($propertyInfo->base_price),
                        $propertyInfo->property_code,
                        numberPlaceFormat($propertyInfo->property_size),
                        $propertyInfo->location
                    ];

                    $mail_data=["mail_action_name"=>"property_sold",
                        "mail_short_code_variable"=>$mailParams,
                        "email"=>$bidders->email,
                        "username"=>$bidders->name,
                        "property_name"=>$propertyInfo->title,
                        "location"=>$propertyInfo->location,
                        "escrow_status"=>$propertyInfo->escrow_status,
                        "property_image"=>$propertyInfo->image,
                        "message_top"=>"Congratulations",
                        "message_top_heading"=>"The Property has been sold"
                    ];
                    
                    dispatch(new SendPropertyMail($mail_data));
                    //PUSH NOTIFICATION
                    $title="Offercity Sold Property to Other Bidder.";
                    $description="Offercity sold property-".$propertyInfo->title.".to bidder ".$bidderInfo->name.".";
                   
                    $payload=["property_id"=>$propertyInfo->id];
                    $this->pushNotification($title,$description,$payload,array($bidders->id));
                }

                 //PUSH NOTIFICATION TO BUYER APP WHEN HIS BID AWARDED
                $title="Congratulations! Offercity Property Sold to you.";
                $description="Congratulations! ".$bidderInfo->name." Offercity sold property to you.";
                $payload=["property_id"=>$propertyInfo->id];
               
                $this->pushNotification($title,$description,$payload,array($bidderInfo->id));

                return response()->json(["status"=>"success","escrow"=>"Sold","message"=>"Property Sold to ".$bidderInfo->name]);
            }
        }
        catch(Exception $e){
          return response()->json(["status"=>"error"]); 
        }    
    }
    public function getRevenue(Request $request){
        try{
            $stateList = State::where('delete_status',0)->get(); 
            $propertyTypeList = PropertyType::where('delete_status',0)->get(); 
           
            if ($request->ajax()) {
                $data = Property::with(['getBids'=>function($q){
                    $q->where('status',1);
                    $q->where('bid_status',"Closed");
                     $q->where('delete_status',0);
                }])->whereHas('getBids',function($q){
                    $q->where('status',1);
                    $q->where('bid_status',"Closed");
                    $q->where('delete_status',0);
                })->where('escrow_status',"Sold")->where('delete_status',0)->latest();


                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('title ', function ($data) {
               
                 $property_title = '<a title="'.$data->title.'" href="'.route('admin-property-details',$data->slug).'">'.substr($data->title, 0, 15).'...</a>';
                  return $property_title;
                })
             
                ->addColumn('base_price', function ($data) {
                return moneyFormat($data->base_price);
                })

                ->addColumn('seller_price', function ($data) {
                return moneyFormat($data->seller_price);
                })
               
                ->addColumn('bid_price', function ($data) {
                    return moneyFormat($data->getBids[0]->bid_price);
                    })
              
               
                ->addColumn('difference', function($data){
                    $difference=($data->getBids[0]->bid_price)-($data->seller_price);
                        
                    return moneyFormat($difference);
                    })


                ->filter(function ($instance) use ($request) {
                    
                        if(!empty($request->get('property_type'))) {
                            $instance->where('property_type', $request->get('property_type'));
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
           
            return view('admin::property.revenue_list',compact('stateList','propertyTypeList'));
        }
        catch (\Exception $e){
            //dd($e);
            return redirect()->back()->with('error', 'something wrong');
        }
    }
}