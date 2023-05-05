<?php

namespace Modules\Buyer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Password_reset;
use App\Models\{User,Property,PropertyGallery,PropertyType,Country,State,City,Bid,FavProperty,PropertyOffer,IntrestedCity,MailAction,MailTemplate,CmsPage};
use App\Helpers\Helper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Password;
use Hash,Auth,Validator,Exception,DataTables,Mail,Str,Notification,DB;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Illuminate\Mail\Message;

use App\Notifications\{BuyerAddNotification,BuyerAddBidNotification,BuyerUpdateBidNotification,BuyerComplaintNotification,BuyerEnquiryNotification};


class BuyerPropertyController extends Controller
{

  public function distance($lat1, $lon1, $lat2, $lon2, $unit) {

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
      } else {
          return $miles;
        }
  }


 public function sendSMS($receiverNumber,$sms_action_name,$sms_dynamic_params)
  {
    try {
          $account_sid = getenv("TWILIO_SID");
          $auth_token = getenv("TWILIO_TOKEN");
          $twilio_number = getenv("TWILIO_FROM");

          //GET SMS TEMPLATE
          $smsActions = MailAction::where('action','=',$sms_action_name)->where('action_type','sms')->get()->toArray();
          $smsTemplates = SmsTemplate::where('action','=',$sms_action_name)->get(array('name','action','body','status'))->toArray();
           if($smsTemplates[0]['status']==1){
              $cons = explode(',',$smsActions[0]['options']);
              $constants = array();
              
              foreach($cons as $key => $val){
                $constants[] = '##'.$val.'##';
              }

              $rep_Array = $sms_dynamic_params;
              $sms_body = $smsTemplates[0]['body'];
              //$change_email = strip_tags($email_body);
              $messageBody = str_replace($constants, $rep_Array,$sms_body);
                //
                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number, 
                    'body' => $messageBody]);
    
           }

         
    } catch (Exception $e) {
      return redirect()->back()->with('error', $e->getMessage());
    }
  }





public function sendDynamicMail($mail_action_name,$mail_params,$send_email){

    $emailActions = MailAction::where('action','=',$mail_action_name)->get()->toArray();
    $emailTemplates = MailTemplate::where('action','=',$mail_action_name)->get(array('name','subject','action','body','status'))->toArray();
    if($emailTemplates[0]['status']==1){
      $email=$send_email;
    
      $cons = explode(',',$emailActions[0]['options']);
      $constants = array();
      
      foreach($cons as $key => $val){
        $constants[] = '##'.$val.'##';
      }

      $email_subject = $emailTemplates[0]['subject'];
      
      $rep_Array = $mail_params;
      
      $email_body = $emailTemplates[0]['body'];
      //$change_email = strip_tags($email_body);

      
      $messageBody = str_replace($constants, $rep_Array,$email_body);
      
      $response=$this->sendMailForDynamicBody($messageBody,$email_subject,$email);
      return $response;

    }else{
      return $response;
    }

   
  
  }

  public function sendMailForDynamicBody($messageBody,$email_subject,$email)
  {
    try
    {
      Mail::send('emails.email_template', array('messageBody'=> $messageBody), function ($message) use ($messageBody,$email,$email_subject) {
      $message->subject($email_subject);
      // $message->to("kiran.kumari@emails.emizentech.com");
      $message->to($email);
      $message->from(env('MAIL_USERNAME'));
      $message->setBody($messageBody);
      });
       if(Mail::failures() != 0) {
        return 1;
       }else{
        return 0;
       }

    }catch(\Exception $e){
      //echo "Something went wrong";
    }
  }



  public function displayDistanceWiseProperty(Request $request){

    $lat = @$request->center_lat ? $request->center_lat : 29.7878003;
    $long = @$request->center_long ? $request->center_long : -95.6928635;

    //$lat= (double)$lat;
    //$long= (double)$long;

    // $property_list = DB::select(DB::raw("SELECT * ,ACOS( SIN( RADIANS( 'latitude' ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( 'latitude' ) ) * COS( RADIANS( $lat )) * COS( RADIANS( 'longitude' ) - RADIANS( $long )) ) * 6380 AS distance FROM properties WHERE ACOS( SIN( RADIANS( 'latitude' ) ) * SIN( RADIANS( $lat ) ) + COS( RADIANS( 'latitude' ) ) * COS( RADIANS( $lat )) * COS( RADIANS( 'longitude' ) - RADIANS( $long )) ) * 6380 < 20000000 ORDER BY distance"));

    //dd([$lat,$long]);

 

    $property=Property::nearestInMiles(30,$lat,$long)->with(['getPropertyCity','favProperty' => function ($hasMany) {
        $hasMany->where('buyer_id', @Auth::user()->id);
      }])->where([['status',1],['delete_status',0]])->whereIn('escrow_status',$request->status)->orderBy('base_price','DESC')->get();


                 
          // dd($property);
          // \DB::enableQueryLog();
          //   $property=Property::select(['*', DB::RAW("ACOS( SIN( RADIANS('latitude' ) ) * SIN( RADIANS( ".$lat." ) ) + COS( RADIANS('latitude') ) * COS( RADIANS( ".$lat." )) * COS( RADIANS('longitude') - RADIANS( ".$long." )) ) * 6380  as distance")])->with('getPropertyCity')->whereIn('escrow_status',[$request->status])->where('status',1)->where('delete_status',0)->where("ACOS( SIN( RADIANS('latitude' ) ) * SIN( RADIANS( ".$lat." ) ) + COS( RADIANS( 'latitude') ) * COS( RADIANS( ".$lat." )) * COS( RADIANS('longitude') - RADIANS( ".$long." )) ) * 6380","<",20000000)->orderBy('id',$request->sort_by)->get();
          // dd(\DB::getQueryLog());
    if(!$property->isEmpty()){
      foreach($property as $li){
        $property_city_arr[]=$li->getPropertyCity->name;
      }
          
      $property_city_arr = array_unique($property_city_arr);

      $propertyInfo=Property::nearestInMiles(30,$lat,$long)->with(['getPropertyCity','favProperty' => function ($hasMany) {
            $hasMany->where('buyer_id', @Auth::user()->id);
          }])->where([['status',1],['delete_status',0]])->whereIn('escrow_status',$request->status)->orderBy('base_price',"DESC")->get();

      if(!$propertyInfo->isEmpty()){
            
        $result_count=$propertyInfo->count(); 
        $result_city=array_values($property_city_arr);
       
        $active_count=0;
        $pending_count=0;
        if($result_count > 0){
          foreach($propertyInfo as $li){
            if($li->escrow_status=="Active"){
              $active_count++;
            }else if($li->escrow_status=="Pending"){
              $pending_count++;
            }
             $base_price=moneyFormat($li->base_price);
              $property_size=numberPlaceFormat($li->property_size);
            $searchProperty[]=[$li->location,$li->longitude,$li->latitude,$li->title,$li->image,$base_price,$li->year_from,$li->no_of_bedroom,$li->no_of_bathroom,$li->slug,$li->id,$property_size];  
            $property_counter["active"]= $active_count;
            $property_counter["pending"]= $pending_count;
          }

          $propertyArr=$propertyInfo->toArray();
          foreach($propertyArr as $key=>$pli){
            if(!empty($pli['fav_property'])){
              $fav=1;
              $fav_id=$pli['fav_property'][0]['id'];
            }else{
              $fav=0;
              $fav_id="";
            }
            $propertyArr[$key]['fav']=$fav;
            $propertyArr[$key]['fav_id']=$fav_id;
          }
        }

        return response()->json(["status" => "success","mapData"=>$searchProperty,"result"=>$propertyArr,"result_city"=>$result_city,"result_count"=>$result_count,"property_counter"=>$property_counter]);

      }else{
        
        return response()->json(["status" => "error","mapData"=>[],"result"=>[],"result_city"=>[],"result_count"=>0,'property_counter'=>[]]);
      }
    }else{
      return response()->json(["status" => "error","mapData"=>[],"result"=>[],"result_city"=>[],"result_count"=>0,'property_counter'=>[]]);
    }
  }

    public function index()
    {
        if(Auth::user()){
          
            return view('buyer::search-property');
        }
        else{
            return redirect()->route('buyer-login');
        }
       
    }

    public function propertyDetail($slug) 
    {
     
        if(Auth::user()){
           $terms_conditions=CmsPage::where([['page_slug',"terms_and_conditions"],['status',1],['delete_status',0]])->first();

        	$propertyInfo=Property::where([['slug',$slug],['status',1],['delete_status',0]])->first();
            
            if(isset($propertyInfo) && !empty($propertyInfo))
            {
                $favProperty=FavProperty::where([['buyer_id',Auth::user()->id],['property_id',$propertyInfo->id]])->first();

            
              //  $propertyOffer=PropertyOffer::where([['property_id',$propertyInfo->id],['status',1],['delete_status',0],['sale_status',1]])->where('date_start', '<=', date('Y-m-d'))->where('date_end', '>=', date('Y-m-d'))->first();

                $propertyOffer=PropertyOffer::where([['property_id',$propertyInfo->id],['status',1],['delete_status',0],['sale_status',1]])->first();

                


                $mybid=bid::where([['property_id',$propertyInfo->id],['bidder_id',Auth::user()->id],['status',1],['delete_status',0]])->first();

               
                $adminInfo=User::role('Admin')->first();

                $galleryList=PropertyGallery::where([['property_id',$propertyInfo->id],['type','Image'],['is_featured',1],['status',1],['delete_status',0]])->orderBy('id','DESC')->take(4)->orderBy('updated_at','ASC')->get();

                $allgalleryList=PropertyGallery::where([['property_id',$propertyInfo->id],['type','Image'],['is_featured',1],['status',1],['delete_status',0]])->orderBy('id','DESC')->orderBy('id','ASC')->get();
               // dd($allgalleryList);
                // $vgalleryList=PropertyGallery::where('property_id',$propertyInfo->id)->where('type',"Video")->orderBy('id','DESC')->get();
                
                $document=PropertyGallery::where([['property_id',$propertyInfo->id],['type',"Document"],['status',1],['delete_status',0]])->orderBy('id','DESC')->get();

                $video=PropertyGallery::where([['property_id',$propertyInfo->id],['type',"Video"],['status',1],['delete_status',0]])->orderBy('id','DESC')->first();
                 return view('buyer::property-detail',compact('propertyInfo','adminInfo','propertyOffer','galleryList','mybid','document','video','favProperty','allgalleryList','terms_conditions'));  

            }else{
                   toastr()->error("Property inactive by offercity.",'',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"3000",]);
                return redirect()->route('buyer-search-property');
            }
        }else{
            return redirect()->route('buyer-login');
        }
    }


  //SHOW BUYER ALL FAV PROPERTY BY LOAD MORE ON SCROLL BY PAGINATE 
  public function myfavproperty(Request $request) {

    if(Auth::user()){  
      $buyerInfo=User::where('id',@Auth::user()->id)->first();
     
      $favProperty=FavProperty::whereHas('getFavPropertyInfo', function ($has) {
        $has->where([['status',1],['delete_status',0]])->whereIn('escrow_status',["Active","Pending"]);
      })->with('getFavPropertyInfo')->where('buyer_id',@Auth::user()->id)->where('delete_status',0)->where('status',1)->paginate(8);

        $favPropertyAll=FavProperty::whereHas('getFavPropertyInfo', function ($has) {
          $has->where([['status',1],['delete_status',0]])->whereIn('escrow_status',["Active","Pending"]);
      })->with('getFavPropertyInfo')->where('buyer_id',@Auth::user()->id)->where('delete_status',0)->where('status',1)->get()->toArray();

      $html = '';
      if($request->ajax()){
        if($favProperty->count() > 0)
        {
          foreach ($favProperty as $k=>$li) 
          {
             $keys=$k+1;
             $base_price=moneyFormat($li->getFavPropertyInfo->base_price);
             $property_size=numberPlaceFormat($li->getFavPropertyInfo->property_size);

           
            $html.='<ul class="tabPane border-0 d-flex justify-content-between"><li class="float-left"><div class="d-flex align-items-center justify-content-between"><div class="leftImg"><img class="userBox" src="'.$li->getFavPropertyInfo->image.'" /></div><div class="midDtl"><div class="imgDetails w-100"><p class="m-0">'.$li->getFavPropertyInfo->title.'</p><div class="priceBx"><span class="float-left mainPrice">'.$base_price.'</span><span class="float-right"><i class="search_pro_heart"><input class="form-check-input favPropertyCheckBox" type="checkbox" id="checkboxfav'.$keys.'" data-propertyid="'.$li->getFavPropertyInfo->id.'" data-favid="'.$li->id.'" checked="checked"><label class="form-check-label" for="checkboxfav'.$keys.'"></label></i></span></div><div class="addressBox"><i class="heartIcon"><img src="/assets_front/images/icons/location.svg"></i>'.$li->getFavPropertyInfo->location.'</div><div class="accomodation"><div class="row"><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/home.svg"></i><p class="aco_left">Built <span class="d-block">'.$li->getFavPropertyInfo->year_from.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/area.svg"></i><p class="aco_left">Sq. Ft <span class="d-block">'.$property_size.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bathroom.svg"></i><p class="aco_left">Bathroom <span class="d-block">'.$li->getFavPropertyInfo->no_of_bathroom.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bedroom.svg"></i><p class="aco_left">Bedroom <span class="d-block">'.$li->getFavPropertyInfo->no_of_bedroom.'</span></p></div></div></div></div></div></div></li><div class="rightPrice float-left d-flex align-items-center justify-content-center"><a href="'.route('buyer-property-detail',$li->getFavPropertyInfo->slug).'" class="priceDetails"><i class="fa_eye"><img class="userBox" src="/assets_front/images/icons/eyeIcon.svg" /></i><div>See Details</div></a></div></ul>';
          }
           return response()->json(['bid_list'=>$html,'status'=>1,'fav_count'=>$favProperty->count()]); 
        }else{
            if(empty($favPropertyAll)){
               return response()->json(['bid_list'=>"",'status'=>2]); 
            }else{
              return response()->json(['bid_list'=>"",'status'=>0]); 
            }

           
          }
         
      }
      return view('buyer::favproperty',compact('buyerInfo'));
    }else{
      return redirect()->route('buyer-login');
    } 
  }

 // MAke escrow pending or active according to timer when timer expired escrow pending when timer running escrow active and default escrow active for property.
 //when escrow not sold when the status update as active pending from cancelled.
 //cancelled escrow means the bidder cannot fullfill documents and property not sold to him when bidder awarded.
  
 public function  closeOfEscrowStatusPending(Request $request){
    try
    {
      $id =$request->property_id;
      $propertyInfo=Property::where('id',$id)->where('escrow_status','!=','Sold')->first();
     
      if(@$propertyInfo->count() > 0){
        $response=Property::where("id",$id)->update(["escrow_status"=>$request->escrow_status]);
        if($response){
           return response()->json(["status" => "success"]);
        }else{
           return response()->json(["status" => "error"]);
        }
      }else{
         return response()->json(["status" => "sold_escrow_property"]);
      }
    }
    catch(Exception $e)
    {
       return response()->json(["status" => "error"]);   
    }  
  }


 //SEARCH PROPERTY VIEW PAGE
  public function searchProperty(){
    if(Auth::user()){


     // $stateList =  Property::groupBy("state")->with('getPropertyState')->whereIn('escrow_status',["Active","Pending"])->get();
      $stateList = DB::table('properties')
          ->selectRaw('properties.id as propertyID,count(properties.id) as count_property,cities.*,cities.id as cityID,cities.name as cityName,states.name as stateName,states.id as stateID')
          ->join('cities', 'properties.city', '=', 'cities.id')
          ->join('states', 'cities.state_id', '=', 'states.id')
          ->where('properties.status',1)
          ->where('properties.delete_status',0)
          ->where('cities.status',1)
          ->where('cities.delete_status',0)
          ->where('states.status',1)
          ->where('states.delete_status',0)
          ->whereIn('properties.escrow_status',["Active","Pending"])
          ->groupBy('properties.city')
          ->orderBy('cities.name')
          ->get();

          


            //$stateList = DB::raw("SELECT A.title,C.name,count(A.id),C.id FROM `properties` as A left join cities as C on A.city=C.id where A.status=1 and A.delete_status=0 and C.status=1 and C.delete_status=0 and A.escrow_status in ("Active","Pending") group by A.city order by C.name");




        return view('buyer::search-property',compact('stateList'));
      }else{
          return redirect()->route('buyer-login');
      }
    }

  //DEFAULT MAP PROPERTY SHOW AT PAGE LOAD
  public function searchPropertyPost(Request $request){

    $property=[];
    $searchProperty=[];
    $propertyInfo=[];
    $intrestedcity_arr=[];
    $result_city=[];
    $result_count=0;
    $base_prices="";
    $propertyArr=[];
    $property_counter=[];
    if(Auth::user()){

    $intrestedCity=IntrestedCity::whereHas('getIntrestedCity',function ($hasMany) {
          $hasMany->where('status',1);
          $hasMany->where('delete_status',0);
      })->where('user_id',Auth::user()->id)->get();
  
    if(!$intrestedCity->isEmpty()){
      foreach ($intrestedCity as $key => $value) {
        $intrestedcity_arr[]=$value->city_id;
      }
    }
   

      //WHEN INTRESTED CITY FOUND->SHOW INTRESTED CITY PROPERTY
      $property=Property::with('getPropertyCity')->where('escrow_status',"Active")->where([['status',1],['delete_status',0]])->orderBy('id','DESC')->whereIn('city',$intrestedcity_arr)->get();


      if(!$property->isEmpty()){

        foreach($property as $li){
          $property_city_arr[]=$li->getPropertyCity->name;
        }
        $property_city_arr = array_unique($property_city_arr);

        $propertyInfo=Property::with(['favProperty' => function ($hasMany) {
          $hasMany->where('buyer_id', @Auth::user()->id);
          }])->where('escrow_status',"Active")->where('status',1)->where('delete_status',0)->whereIn('city',$intrestedcity_arr)->orderBy('updated_at', 'DESC')->orderBy('base_price','DESC')->get();

      }else{

          //WHEN NOT INTRESTED CITY FOUND->SHOW ALL ACTIVE PROPERTY
         $property=Property::with('getPropertyCity')->where('escrow_status',"Active")->where('status',1)->where('delete_status',0)->orderBy('id','DESC')->get();
       
         if(!$property->isEmpty()){
             foreach($property as $li){
              $property_city_arr[]=$li->getPropertyCity->name;
            }
            $property_city_arr = array_unique($property_city_arr);

             $propertyInfo=Property::with(['favProperty' => function ($hasMany) {
              $hasMany->where('buyer_id', @Auth::user()->id);
            }])->where('escrow_status',"Active")->where([['status',1],['delete_status',0]])->orderBy('updated_at', 'DESC')->orderBy('base_price','DESC')->get();

         }else{
 
           return response()->json(["status" => "error","mapData"=>[],"result"=>[],"result_city"=>[],"result_count"=>0,'property_counter'=>[]]);
         }
        
       


      }
     
      
      //if($property->count() > 0){
      
        //  foreach($property as $li){
        //   $property_city_arr[]=$li->getPropertyCity->name;
        //  }
        //  $property_city_arr = array_unique($property_city_arr);

        //   $propertyInfo=Property::with(['favProperty' => function ($hasMany) {
        //   $hasMany->where('buyer_id', @Auth::user()->id);
        // }])->whereIn('escrow_status',["Active","Pending"])->where([['status',1],['delete_status',0]])->whereIn('city',$intrestedcity_arr)->orderBy('base_price','DESC')->get();
      
     // }else{
      
        // $property=Property::with('getPropertyCity')->whereIn('escrow_status',["Active","Pending"])->where([['status',1],['delete_status',0]])->orderBy('id','DESC')->get();
        
        // foreach($property as $li){
        //   $property_city_arr[]=$li->getPropertyCity->name;
        // }
        // $property_city_arr = array_unique($property_city_arr);

        //  $propertyInfo=Property::with(['favProperty' => function ($hasMany) {
        //   $hasMany->where('buyer_id', @Auth::user()->id);
        // }])->whereIn('escrow_status',["Active","Pending"])->where([['status',1],['delete_status',0]])->orderBy('base_price','DESC')->get();
     // }



      
        $result_count=$propertyInfo->count(); 
        $result_city=array_values($property_city_arr);
        $active_count=0;
        $pending_count=0;
        if($result_count > 0){
          foreach($propertyInfo as $li){
            if($li->escrow_status=="Active"){
              $active_count++;
            }else if($li->escrow_status=="Pending"){
              $pending_count++;
            }
            $base_prices=moneyFormat($li->base_price);
            $property_size=numberPlaceFormat($li->property_size);
            $searchProperty[]=[$li->location,$li->longitude,$li->latitude,$li->title,$li->image,$base_prices,@$li->year_from ? $li->year_from : "",@$li->no_of_bedroom ? $li->no_of_bedroom :'',@$li->no_of_bathroom ? $li->no_of_bathroom :'',$li->slug,$li->id,$property_size];
            $property_counter["active"]= $active_count;
            $property_counter["pending"]= $pending_count;

          }

          $propertyArr=$propertyInfo->toArray();
          if(isset($propertyArr) && (!empty($propertyArr))){
            foreach($propertyArr as $key=>$pli)  {
              if(!empty($pli['fav_property'])){
                $fav=1;
                $fav_id=$pli['fav_property'][0]['id'];
              }else{
                $fav=0;
                $fav_id="";
              }
              $propertyArr[$key]['fav']=$fav;
              $propertyArr[$key]['fav_id']=$fav_id;
            }
          }
         
        }
        
      return response()->json(["status" => "success","mapData"=>$searchProperty,"result"=>$propertyArr,"result_city"=>$result_city,"result_count"=>$result_count,"property_counter"=>$property_counter]);
    }else{
      return redirect()->route('buyer-login');
    }
  }
    
  //SEARCH PROPERTY BY TEXT INPUT LOCATION
  public function searchPropertyByAddress(Request $request){
      
    $sort_by=$request->sort_by;
    $searchProperty=[];
    $propertyArr=[];
    $result_city=[];
    $property_counter=[];

    
    if(Auth::user()){
      if(!empty($request->searchLoc) && !empty($request->status)){
        $propertyInfo=Property::with(['favProperty' => function ($hasMany) {
          $hasMany->where('buyer_id', @Auth::user()->id);
        }])->where([['status',1],['delete_status',0],['location','like', '%' .$request->searchLoc . '%']])->whereIn('escrow_status',$request->status)->orderBy('updated_at', 'DESC')->orderBy('base_price',$sort_by)->get();

      }else{
        $propertyInfo=Property::with(['favProperty' => function ($hasMany) {
          $hasMany->where('buyer_id', @Auth::user()->id);
        }])->where([['status',1],['delete_status',0],['location','like', '%' .$request->searchLoc . '%']])->whereIn('escrow_status',["Active","Pending"])->orderBy('updated_at', 'DESC')->orderBy('base_price',$sort_by)->get();

      }
     
      if(!$propertyInfo->isEmpty()){
          $result_count=$propertyInfo->count();
          $active_count=0;
          $pending_count=0; 
          if($result_count > 0){
            foreach($propertyInfo as $li){
              if($li->escrow_status=="Active"){
                $active_count++;
              }else if($li->escrow_status=="Pending"){
                $pending_count++;
              }
              $base_price=moneyFormat($li->base_price);
              $property_size=numberPlaceFormat($li->property_size);
              $citySelected=City::select('name')->where('id',$li->city)->get();
              $searchProperty[]=[$li->location,$li->longitude,$li->latitude,$li->title,$li->image,$base_price,$li->year_from,$li->no_of_bedroom,$li->no_of_bathroom,$li->slug,$li->id,$property_size];  
              $property_counter["active"]= $active_count;
              $property_counter["pending"]= $pending_count;
            }

            $result_city=($citySelected->toArray());
            $result_city = array_column($result_city, 'name');

            $propertyArr=$propertyInfo->toArray();
            foreach($propertyArr as $key=>$pli){
              if(!empty($pli['fav_property'])){
                $fav=1;
                $fav_id=$pli['fav_property'][0]['id'];
              }else{
                $fav=0;
                $fav_id="";
              }
              $propertyArr[$key]['fav']=$fav;
              $propertyArr[$key]['fav_id']=$fav_id;
            }
          }
          return response()->json(["status" => "success","mapData"=>$searchProperty,"result"=>$propertyArr,"result_city"=>$result_city,"result_count"=>$result_count,"property_counter"=>$property_counter]);

      }else{
          return response()->json(["status" => "error","mapData"=>[],"result"=>[],"result_city"=>[],"result_count"=>0,"property_counter"=>[]]);
      }
     
    }else{
      return redirect()->route('buyer-login');
    } 
  }

  //SEARCH PROPERTY BY CITY CHECKBOX
  public function searchPropertyCityWise(Request $request){

    $result_city=[];
    $sort_by=$request->sort_by;
    $searchProperty=[];
    $property_city_arr=[];
    $propertyArr=[];
    $property_counter=[];
    if(Auth::user()){
      if(empty($request->city_id) && !empty($request->status)){
        
        $propertyInfo=Property::with(['favProperty' => function ($hasMany) {
          $hasMany->where('buyer_id', @Auth::user()->id);
        }])->where([['status',1],['delete_status',0]])->whereIn('escrow_status',$request->status)->orderBy('updated_at', 'DESC')->orderBy('base_price',$sort_by)->get();

          $property=Property::with('getPropertyCity')->whereIn('escrow_status',$request->status)->where('delete_status',0)->orderBy('updated_at', 'DESC')->orderBy('base_price',$sort_by)->get();
          if(!$property->isEmpty()){
            foreach($property as $li){
              $property_city_arr[]=$li->getPropertyCity->name;
            }
          }
         
          $property_city_arr = array_unique($property_city_arr);
          $result_city = array_values($property_city_arr);


      }else if(empty($request->status) && !empty($request->city_id)){

          $propertyInfo=Property::with(['favProperty' => function ($hasMany) {
            $hasMany->where('buyer_id', @Auth::user()->id);
          }])->where([['status',1],['delete_status',0]])->whereIn('escrow_status',["Active","Pending"])->whereIn('city',$request->city_id)->orderBy('updated_at', 'DESC')->orderBy('base_price',$sort_by)->get();
          
          $citySelected=City::select('name')->whereIn('id',$request->city_id)->get();
          $result_city=($citySelected->toArray());
          $result_city = array_column($result_city, 'name');
      }
      else if(!empty($request->city_id) && !empty($request->status)){
          
          $propertyInfo=Property::with(['favProperty' => function ($hasMany) {
            $hasMany->where('buyer_id', @Auth::user()->id);
          }])->where([['status',1],['delete_status',0]])->whereIn('city',$request->city_id)->whereIn('escrow_status',$request->status)->orderBy('updated_at', 'DESC')->orderBy('base_price',$sort_by)->get();

            $citySelected=City::select('name')->whereIn('id',$request->city_id)->get();
            $result_city=($citySelected->toArray());
            $result_city = array_column($result_city, 'name');
      }
      else{
         

          $propertyInfo=Property::with(['favProperty' => function ($hasMany) {
            $hasMany->where('buyer_id', @Auth::user()->id);
          }])->where([['status',1],['delete_status',0]])->whereIn('escrow_status',["Active","Pending"])->orderBy('updated_at', 'DESC')->orderBy('base_price',$sort_by)->get();

           $property=Property::with('getPropertyCity')->where([['status',1],['delete_status',0]])->whereIn('escrow_status',["Active","Pending"])->orderBy('updated_at', 'DESC')->orderBy('base_price',$sort_by)->get();
       
          if(!$property->isEmpty()){
            foreach($property as $li){
              $property_city_arr[]=$li->getPropertyCity->name;
            }
          }

         
          $property_city_arr = array_unique($property_city_arr);
          $result_city = array_values($property_city_arr);

      }

      if(!$propertyInfo->isEmpty()){
        $result_count=$propertyInfo->count(); 
        $active_count=0;
        $pending_count=0;
        if($result_count > 0){
          foreach($propertyInfo as $li){
            if($li->escrow_status=="Active"){
              $active_count++;
            }else if($li->escrow_status=="Pending"){
              $pending_count++;
            }
             $base_price=moneyFormat($li->base_price);
              $property_size=numberPlaceFormat($li->property_size);
            $searchProperty[]=[$li->location,$li->longitude,$li->latitude,$li->title,$li->image,$base_price,$li->year_from,$li->no_of_bedroom,$li->no_of_bathroom,$li->slug,$li->id,$property_size];  
            $property_counter["active"]= $active_count;
            $property_counter["pending"]= $pending_count;
          }

          $propertyArr=$propertyInfo->toArray();
          foreach($propertyArr as $key=>$pli){
            if(!empty($pli['fav_property'])){
              $fav=1;
              $fav_id=$pli['fav_property'][0]['id'];
            }else{
              $fav=0;
              $fav_id="";
            }
            $propertyArr[$key]['fav']=$fav;
            $propertyArr[$key]['fav_id']=$fav_id;
          }
        }

        return response()->json(["status" => "success","mapData"=>$searchProperty,"result"=>$propertyArr,"result_city"=>$result_city,"result_count"=>$result_count,"property_counter"=>$property_counter]);

      }else{
          return response()->json(["status" => "error","mapData"=>[],"result"=>[],"result_city"=>[],"result_count"=>0,'property_counter'=>[]]);
      }

        
    }else{
      return redirect()->route('buyer-login');
    } 
  }



public function propertyGalleryGet($property_id){
    if(Auth::user()){
    $propertyInfo=Property::where([['id',$property_id],['status',1],['delete_status',0]])->first();
    if(isset($propertyInfo) && !empty($propertyInfo))
    {
        $galleryList=PropertyGallery::where([['property_id',$property_id],['type','Image'],['status',1],['delete_status',0]])->orderBy('id','ASC')->get();

      return view('buyer::gallery',compact('galleryList','propertyInfo'));   
    }else{
        toastr()->error("Property inactive by offercity.",'',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"3000",]);
        return redirect()->route('buyer-search-property');
    } 
    }else{
        return redirect()->route('buyer-login');
    } 

}
     //SHOW BUYER ALL BIDS BY LOAD MORE ON SCROLL BY PAGINATE 
    public function propertyVideo($property_id) {
        if(Auth::user()){
            $propertyInfo=Property::where([['id',$property_id],['status',1],['delete_status',0]])->first();
            if(isset($propertyInfo) && !empty($propertyInfo))
            {
                $videoList=PropertyGallery::where([['property_id',$property_id],['type','Video'],['status',1],['delete_status',0]])->orderBy('id','ASC')->get();

                return view('buyer::videos_gallery',compact('videoList','propertyInfo'));   
            }else{
                toastr()->error("Property inactive by offercity.",'',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"3000",]);
                return redirect()->route('buyer-search-property');
            }
        }else{
            return redirect()->route('buyer-login');
        }   
    } 


     public function propertyAddToFav(Request $request){
    try{
      if(Auth::user()){ 
        $status="error";
        $data=$request->all();
        if($request->status=="check"){
          $favProperty = new FavProperty;
          $favProperty->buyer_id = @Auth::user()->id; 
          $favProperty->property_id=$data['property_id'];
          $favProperty->save();
          $status="success";
          if($favProperty){
            return response()->json(["status" =>$status,"result"=>$favProperty->id]);
          }else{
            return response()->json(["status" => $status,"result"=>""]);
          }
        }else{
          return response()->json(["status" => $status,"result"=>""]);
        }
      }else{
      return redirect()->route('buyer-login');
      }
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function propertyRemoveFromFav(Request $request){
    try{
      if(Auth::user()){ 
        if($request->fav_id!="" && $request->status=="uncheck"){
          FavProperty::where('id', $request->fav_id)->delete();  
          return response()->json(["status" => "success"]);
        }else{
          return response()->json(["status" => "error"]);
        }
       }else{
        return redirect()->route('buyer-login');
        }

    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
  
  public function postmyfavproperty(Request $request){

    $html = '';
    if(Auth::user()){ 
      $posts=FavProperty::whereHas('getFavPropertyInfo', function ($has) {
        $has->where('status',1);
      })->with('getFavPropertyInfo')->where('buyer_id',@Auth::user()->id)->where('delete_status',0)->where('status',1)->paginate(8);
    
      if ($request->ajax()) {
        foreach ($posts as $li) {
          $base_price=moneyFormat($li->getFavPropertyInfo->base_price);
           $property_size=numberPlaceFormat($li->getFavPropertyInfo->property_size);

          

          $html.='<ul class="tabPane border-0 d-flex justify-content-between"><li class="float-left"><div class="d-flex align-items-center justify-content-between"><div class="leftImg"><img class="userBox" src="'.$li->getFavPropertyInfo->image.'" /></div><div class="midDtl"><div class="imgDetails w-100"><p class="m-0">'.$li->getFavPropertyInfo->title.'</p><div class="priceBx"><span class="float-left mainPrice">'.$base_price.'</span></div><div class="addressBox"><i class="heartIcon"><img src="/assets_front/images/icons/location.svg"></i>'.$li->getFavPropertyInfo->location.'</div><div class="accomodation"><div class="row"><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/home.svg"></i><p class="aco_left">Built <span class="d-block">'.$li->getFavPropertyInfo->year_from.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/area.svg"></i><p class="aco_left">Sq. Ft <span class="d-block">'.$property_size.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bathroom.svg"></i><p class="aco_left">Bathroom <span class="d-block">'.$li->getFavPropertyInfo->no_of_bathroom.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bedroom.svg"></i><p class="aco_left">Bedroom <span class="d-block">'.$li->getFavPropertyInfo->no_of_bedroom.'</span></p></div></div></div></div></div></div></li><div class="rightPrice float-left d-flex align-items-center justify-content-center"><a href="'.route('buyer-property-detail',$li->getFavPropertyInfo->slug).'" class="priceDetails"><i class="fa_eye"><img class="userBox" src="/assets_front/images/icons/eyeIcon.svg" /></i><div>See Details</div></a></div></ul>';
        }
        return response()->json(["status" => $html]);  
      }
       return view('buyer::favproperty');
     }else{
      return redirect()->route('buyer-login');
      }
   
  }


   //DEFAULT MAP PROPERTY SHOW AT PAGE LOAD
  public function searchPropertyPost1(Request $request){
    $property=[];
    $searchProperty=[];
    $propertyInfo=[];
    $result_city=[];
    $result_count=0;

    $property=Property::with('getPropertyCity')->where([['status',1],['delete_status',0]])->orderBy('id','DESC')->first();
    if(!empty($property)){
      $propertyInfo=Property::with(['favProperty' => function ($hasMany) {
      $hasMany->where('buyer_id', @Auth::user()->id);
      }])->where([['status',1],['delete_status',0]])->orderBy('base_price','DESC')->get();
    
      $result_count=$propertyInfo->count(); 
      $result_city=$property->getPropertyCity->name;

      if($result_count > 0){
        foreach($propertyInfo as $li){
           $base_price=moneyFormat($li->base_price);


          $searchProperty[]=[$li->location,$li->longitude,$li->latitude,$li->title,$li->image,$base_price,$li->year_from,$li->no_of_bedroom,$li->no_of_bathroom,$li->slug,$li->id,$li->property_size];  
        }
     
        $propertyArr=$propertyInfo->toArray();
        foreach($propertyArr as $key=>$pli){
          if(!empty($pli['fav_property'])){
            $fav=1;
            $fav_id=$pli['fav_property'][0]['id'];
          }else{
            $fav=0;
            $fav_id="";
          }
          $propertyArr[$key]['fav']=$fav;
          $propertyArr[$key]['fav_id']=$fav_id;
        }
      }
    }  
    return response()->json(["status" => "success","mapData"=>$searchProperty,"result"=>$propertyArr,"result_city"=>$result_city,"result_count"=>$result_count]);
  }

}