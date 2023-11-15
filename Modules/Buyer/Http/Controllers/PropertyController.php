<?php

namespace Modules\Buyer\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Validation\Rule;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str;



use App\Models\PropertyCondition;


class PropertyController extends Controller
{
    //
    public function index(Request $request)
    {

        $searchData = $request->title_search;
        if(isset($request->title_search) && !empty($request->title_search)){
        $propertyData = Property::where('title','Like','%'.$searchData.'%')->paginate(5); 
      }
        else{
        $propertyData  = Property::paginate(5);

        }   
        return view('buyer::property',compact('propertyData'));
    }
    
    
    
    public function add(Request $request)
    {
        $propertyDetail = Property::all();
        $countryData = Country::all();

        $property_condition = PropertyCondition::where('status',1)->get();
        return view('buyer::add-property',compact('propertyDetail','property_condition','countryData'));
       
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
    
        $data=$request->all();
        $request->validate([
			    
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
                'chk_pool'=>'nullable|numeric',
                'chk_garden'=>'nullable|numeric',
                'chk_lift'=>'nullable|numeric',
                'chk_parking'=>'nullable|numeric',

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

		        'chk_pool.required'=>'No.of pool field can’t be left blank',
		        'chk_pool.numeric'=>'No.of pool field allows only numbers.',

		        'chk_garden.required'=>'No.of garden field can’t be left blank',
		        'chk_garden.numeric'=>'No.of garden field allows only numbers.',

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


              $user_id = Auth::User()->id;
              $user_detail = User::where('id',$user_id)->select('mobile','email')->first();

              
                $imageName = time().'.'.$request->property_image->extension();  
                $image = $request->profile_pic->move(public_path('images/'), $imageName);

                    $property = new Property;
                    $property->title=$data['title'];
                    // $property->title_pt=$title_pt;
                    $property->property_type=$data['property_type'];
                    $property->guest_count=$data['guest_count'];
                    $property->no_of_bedroom=$data['no_of_bedroom'];
                    $property->no_of_kitchen=$data['no_of_kitchen'];
                    $property->no_of_bathroom=$data['no_of_bathroom'];
                    $property->no_of_pool=$data['chk_pool'];
                    $property->no_of_garden=$data['chk_garden'];
                    $property->no_of_lift=$data['chk_lift'];
                    $property->no_of_parking=$data['chk_parking'];
                    $property->no_of_balcony=$data['no_of_balcony'];
                    $property->no_of_floors=$data['no_of_floors'];
                    $property->property_area=$data['property_area'];
                    $property->property_number=$data['property_number'];
                    $property->property_address=$data['property_address'];
                    // $property->property_address_pt=$property_address_pt;
                    // $property->property_latitude=$data['property_latitude'];
                    // $property->property_longitude=$data['property_longitude'];
                    $property->property_email=$data['property_email'];
                    $property->property_price=$data['property_price'];
                    $property->property_price_type=$data['property_price_type'];
                    $property->property_category=$data['property_category'];
                    $property->property_condition=$data['property_condition'];
                    $property->meta_title=$data['meta_title'];
                    // $property->meta_title_pt=$meta_title_pt;
                    $property->meta_keywords=$data['meta_keywords'];
                    // $property->meta_keywords_pt=$meta_keywords_pt;
                    $property->meta_description=$data['meta_description'];
                    // $property->meta_description_pt=$meta_description_pt;
                    $property->property_description=$data['property_description'];
                    // $property->property_description_pt=$property_description_pt;
                    $property->built_in_year=$data['built_in_year'];
                    $property->property_image=$imageName;
                    $property->property_status=1;
                    // $property->publish_date=date('Y-m-d');

                    echo "<pre>";
                    print_r($property);
                    die;

                    $property->save();
        }

           
    
            

        }
        
    
 
