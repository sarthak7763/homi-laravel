<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,MailAction,MailTemplate,Property,PropertyOffer,PropertyGallery,IntrestedCity,DeviceToken};
use Modules\Admin\Http\Requests\{OfferSaleRequest,OfferSaleRequestEdit};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str,Notification;
use App\Notifications\{AdminAddOrUpdatePropertyOfferNotification};
use App\Jobs\{SendAddBidMailToBidders,SendAddBidSMSToBidders,SendPropertyMail};
use Carbon\Carbon;

class OfferPropertyController extends Controller {

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
        $data =PropertyOffer::with('OfferPropertyInfo')->whereHas('OfferPropertyInfo', fn($qry) => $qry->where('delete_status', 0)->where('escrow_status','!=','Sold'))->where('delete_status',0)->get();

        return Datatables::of($data)
        ->addColumn('property_name', function ($data) {
              $remainTime=daysLeftToExpireProperty(@$data->date_end,@$data->time_end);
             
              $property_name='<a href="'.route('admin-property-details',$data->OfferPropertyInfo->slug).'" title="'.$data->OfferPropertyInfo->title.'">'.substr($data->OfferPropertyInfo->title,0,30).'</a><br><span class="badge badge-inverse">'.$remainTime.'</badge>';
              return $property_name;   
        })
        ->addColumn('date_start', function($data){
          $time_start=$data->time_start;
          $date_start=date('M d, Y', strtotime($data->date_start)).", ".date('h:i A', strtotime($time_start));
          $time_end=$data->time_end;
          $date_end=date('M d, Y', strtotime($data->date_end)).", ".date('h:i A', strtotime($time_end));
             
          return "<b>From: </b>".$date_start."<br><b> To: </b>".$date_end;   
        }) 
        ->addColumn('sale_status', function($row){
          $sale_status = $row->sale_status;
          if($sale_status==1){
            $sale_status='<span class="badge badge-success badge_publish_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
          }else{
            $sale_status='<span class="badge badge-danger badge_publish_status_change" style="cursor: pointer;" id="'.$row->id.'">Inactive</span>';
          }
          return $sale_status;
        }) 
        ->addColumn('created_at', function ($data) {
          $created_date=date('M d, Y h:i A', strtotime($data->created_at));
          return $created_date;   
        })
        ->addColumn('action__', function($row){
          $route=route('admin-property-sales-edit',$row->id);
          $route_show=route('admin-property-sales-detail-show',$row->id);
          
          $action='<a href="'.$route_show.'" title="View" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a> <a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>';
          return $action;
        })  
        ->make(true);
      }  
    }
    catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }
    return view('admin::offer.index');  
  }

  public function add() {
    try{
      $propertyList = Property::doesnthave('SaleOffer')->where('escrow_status','!=','Sold')->where('delete_status',0)->where('status',1)->get();

      return view('admin::offer.add',compact('propertyList'));
    }
    catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function save(OfferSaleRequest $request) {
    try {
      $data=$request->all();
      $propertyInfo=Property::with('getPropertyCity','getPropertyState')->where('id',$data['property_id'])->first();
      if($propertyInfo->status==0){
        return redirect()->back()->with('error', 'Cannot Place Offer on Inactive Property, Please Activate Property Status');
      }else{
        $start_timestamp=new Carbon($data['date_start'].' '.$data['time_start']);
         $end_timestamp=new Carbon($data['date_end'].' '.$data['time_end']);
       
        $property = new PropertyOffer;
        $property->add_by=Auth::user()->id;
        $property->date_start=date('Y-m-d',strtotime($data['date_start']));
        $property->date_end=date('Y-m-d',strtotime($data['date_end']));
        $property->time_start=date("H:i", strtotime($data['time_start']));
        $property->time_end=date("H:i", strtotime($data['time_end']));
        $property->property_id=$data['property_id'];
        $property->offer_details=$data['offer_details'];
        $property->sale_status=$data['sale_status'];
        $property->start_timestamp=$start_timestamp;
        $property->end_timestamp=$end_timestamp;
        $property->save();

        if($data['sale_status']==1){
          $userIntrestedCity=IntrestedCity::where('city_id',$propertyInfo->city)->pluck('user_id')->all();

          if(!empty($userIntrestedCity)){
            foreach($userIntrestedCity as $li){
              $buyerInfo=User::where([['id',$li],['status',1],['delete_status',0]])->first();
              if($buyerInfo){
                 $mailParams=[$buyerInfo->name,
                              date('M d, Y',strtotime($data['date_start'])),
                              date('M d, Y',strtotime($data['date_end'])),
                              date("H:i A", strtotime($data['time_start'])),
                              date("H:i A", strtotime($data['time_start'])),
                              $propertyInfo->title,
                              $propertyInfo->property_code,
                              moneyFormat($propertyInfo->base_price),
                              numberPlaceFormat($propertyInfo->property_size),
                              $propertyInfo->location
                  ];
                  $mail_data=["mail_action_name"=>"admin_add_property_offer",
                              "mail_short_code_variable"=>$mailParams,
                              "email"=>$buyerInfo->email,
                              "username"=>$buyerInfo->name,
                              "property_name"=>$propertyInfo->title,
                              "location"=>$propertyInfo->location,
                              "escrow_status"=>$propertyInfo->escrow_status,
                              "property_image"=>$propertyInfo->image,
                              "message_top"=>"Welcome",
                              "message_top_heading"=>"New Offer at Offercity."
                  ];       
                dispatch(new SendPropertyMail($mail_data));
                //NOTIFICATION TO BUYERS
                $buyerInfo->notify(new AdminAddOrUpdatePropertyOfferNotification(Auth::user(),$propertyInfo));
              }
            }

            //PUSH NOTIFICATION TO ALL BUYER
            $title="Offercity Placed a New Offer on Property";
            $description="Offercity placed new offer for Property- ".$propertyInfo->title.",Bed-".$propertyInfo->no_of_bedroom.", Bath-".$propertyInfo->no_of_bathroom.", Sqft-".$propertyInfo->property_size.", City-".$propertyInfo->getPropertyCity->name.", State-".$propertyInfo->getPropertyState->name.".";
            $payload=["property_id"=>$data['property_id']];
            $this->pushNotification($title,$description,$payload,$userIntrestedCity);
          }
        }
        toastr()->success('Property Timer added successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
        return redirect()->route('admin-property-sales-list')->with('success',"Timer added successfully");
      }
    }
    catch (\Exception $e){
      return redirect()->back()->with('error', 'something wrong');
    }
  }
  
  public function edit($id){
    try{
      $propertyInfo=PropertyOffer::with('OfferPropertyInfo')->where('id',$id)->first();
      return view('admin::offer.edit', compact('propertyInfo'));
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');            
    }
  }
  //PROPERTY DEATIL PAGE TIMER
  public function editByPropertyID($property_slug){
    try{
        $property=Property::where('slug',$property_slug)->first();
        $propertyInfo=PropertyOffer::where('property_id',$property->id)->first();
        if($propertyInfo){
          return view('admin::property.timer_edit', compact('propertyInfo','property'));
        }else{
          $propertyList = Property::doesnthave('SaleOffer')->where('escrow_status','!=','Sold')->where('delete_status',0)->where('id',$property->id)->get();
          return view('admin::property.timer_add', compact('propertyList','property'));
        } 
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');            
    }
  }
    
  public function update(OfferSaleRequestEdit $request){
    $data = $request->all();
    try {
      $start_timestamp=new Carbon($data['date_start'].' '.$data['time_start']);
      $end_timestamp=new Carbon($data['date_end'].' '.$data['time_end']);
      $propertyData = ["date_start"=>date('Y-m-d',strtotime($data['date_start'])),
                      "time_start"=>date("H:i", strtotime($data['time_start'])),
                      "start_timestamp"=>$start_timestamp,
                      "end_timestamp"=>$end_timestamp,
                      "date_end"=>date('Y-m-d',strtotime($data['date_end'])),
                      "time_end"=>date("H:i", strtotime($data['time_end'])),
                      "offer_details"=>$data['offer_details'],
                      "sale_status"=>$data['sale_status']
      ]; 

      $propertyInfo=Property::with('getPropertyCity','getPropertyState')->where('id',$data['property_id'])->where('escrow_status','!=',"Sold")->first();
      if($propertyInfo){
        if($propertyInfo->status==0){
          return redirect()->back()->with('error', 'Cannot Place Offer on Inactive Property, Please Set Property Status As Active');
        }
        PropertyOffer::where('id',$data['id'])->update($propertyData);
        if((date('Y-m-d',strtotime($data['date_end'])) <= date('Y-m-d')) && (date("H:i") > date("H:i", strtotime($data['time_end'])))){
            Property::where('id',$data['property_id'])->whereIn('escrow_status',["Cancelled","Pending"])->update(['escrow_status'=>"Pending"]);
        }else{
          Property::where('id',$data['property_id'])->whereIn('escrow_status',["Cancelled","Pending"])->update(['escrow_status'=>"Active"]);
          
          if($data['sale_status']==1){
            PropertyOffer::where('id',$data['id'])->update(["notification_status"=>0]);
            $userIntrestedCity=IntrestedCity::where('city_id',$propertyInfo->city)->pluck('user_id')->all();
            
            if(!empty($userIntrestedCity)){
              foreach($userIntrestedCity as $li){
                $buyerInfo=User::where([['id',$li],['status',1],['delete_status',0]])->first();
                if($buyerInfo){
                  $mailParams=[$buyerInfo->name,
                              date('M d, Y',strtotime($data['date_start'])),
                              date('M d, Y',strtotime($data['date_end'])),
                              date("H:i A", strtotime($data['time_start'])),
                              date("H:i A", strtotime($data['time_start'])),
                              $propertyInfo->title,
                              $propertyInfo->property_code,
                              moneyFormat($propertyInfo->base_price),
                              numberPlaceFormat($propertyInfo->property_size),
                              $propertyInfo->location
                  ];

                  $mail_data=["mail_action_name"=>"admin_add_property_offer",
                              "mail_short_code_variable"=>$mailParams,
                              "email"=>$buyerInfo->email,
                              "username"=>$buyerInfo->name,
                              "property_name"=>$propertyInfo->title,
                              "location"=>$propertyInfo->location,
                              "escrow_status"=>$propertyInfo->escrow_status,
                              "property_image"=>$propertyInfo->image,
                              "message_top"=>"Welcome",
                              "message_top_heading"=>"New Offer at Offercity"
                  ];
                  dispatch(new SendPropertyMail($mail_data));

                   //NOTIFICATION TO BUYERS
                  $buyerInfo->notify(new AdminAddOrUpdatePropertyOfferNotification(Auth::user(),$propertyInfo));

                }
              }
               //PUSH NOTIFICATION TO ALL BUYER
              $title="Offercity Placed a New Offer on Property";
              $description="Offercity placed new offer for Property- ".$propertyInfo->title.",Bed-".$propertyInfo->no_of_bedroom.", Bath-".$propertyInfo->no_of_bathroom.", Sqft-".$propertyInfo->property_size.", City-".$propertyInfo->getPropertyCity->name.", State-".$propertyInfo->getPropertyState->name.".";
               $payload=["property_id"=>$data['property_id']];
               $this->pushNotification($title,$description,$payload,$userIntrestedCity);
            }
          }
        }
         
        toastr()->success('Property Sales Timer information updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]); 
        return redirect()->route('admin-property-sales-list')->with('success','Timer info updated successfully');
      }else{
        PropertyOffer::where('id',$data['id'])->update(['sale_status'=>0]);
        toastr()->error('Selected Property is sold property. You cannot update or publish offer on it.','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]); 
        return redirect()->route('admin-property-sales-edit',$data['id'])->with('error','Selected Property is sold property. You cannot update or publish offer on it.');
      }
    }catch (\Exception $e){
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function updateStatus(Request $request){
    try{
        $user=PropertyOffer::where('id', $request->id)->first();
        if($user->status == 1){
          $data = [ "status"=>0];
          PropertyOffer::where('id', $request->id)->update($data);
        }else{
          $data = [ "status"=>1];
          PropertyOffer::where('id', $request->id)->update($data);
        }

      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function updateSaleOfferPublishStatus(Request $request){
    try{
      $propertyOffer=PropertyOffer::where('id', $request->id)->first();
      $propertyInfo=Property::where('id',$propertyOffer->property_id)->where('escrow_status','!=',"Sold")->first();
      if(isset($propertyInfo) && !empty($propertyInfo)){
        if($propertyOffer->sale_status == 1){
          $data = [ "sale_status"=>0];
          PropertyOffer::where('id', $request->id)->update($data);
        }else{
          $data = [ "sale_status"=>1];
          PropertyOffer::where('id', $request->id)->update($data);
        }
        return response()->json(["success" => "1"]);
      }else{
        $data = [ "sale_status"=>0];
        PropertyOffer::where('id', $request->id)->update($data);
        return response()->json(["error" => "1"]);
      }
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
   
  public function editDeleteStatus(Request $request) {
    $data = $request->all();
    try{
      $update = ["delete_status"=>1,"status"=>0];
      if (isset($data['id'])) {
        try {
          PropertyOffer::where('id', $data['id'])->update($update);  
          return json_encode(['status' => 200]);
        } catch (\Exception $e) {
          return json_encode(['status' => 500]);
        }
      } else {
        return json_encode(['status' => 500]);
      }
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function show($id){
    try{
      $saleInfo =  PropertyOffer::with('OfferPropertyInfo')->where('id',$id)->first();
      return view('admin::offer.show',compact('saleInfo'));  
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

}