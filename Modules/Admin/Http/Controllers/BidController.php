<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,SmsTemplate,Bid,PropertyOffer,MailAction,MailTemplate,Property,DeviceToken};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Notification;
use Twilio\Rest\Client;
use App\Notifications\{AdminAwardBidNotification,AdminAwardBidNotificationToOtherBidder,AdminRejectBidNotification,AdminRejectBidNotificationToOtherBidder};
use App\Jobs\{SendAddBidMailToBidders,SendAddBidSMSToBidders,SendPropertyMail};
use HTTP;
class BidController extends Controller{

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
      $propertyList = Bid::with('BidPropertyInfo')->where('delete_status',0)->groupBy('property_id')->get(); 
      $offerList = PropertyOffer::get(); 
      $bidderList = Bid::with('BidderInfo')->groupBy('bidder_id')->get(); 
      $getMax=Bid::where('delete_status',0)->max('bid_price');
      $getMin=Bid::where('delete_status',0)->min('bid_price');
   
    
      if($request->ajax()) {   
        $data =  Bid::with(['BidderInfo','BidPropertyInfo'])->where('delete_status',0)->latest();
        return Datatables::of($data)
            ->addIndexColumn()
  
            ->addColumn('bidder_name', function($row){
                $bidder_name = "<a href=".route('admin-user-details',$row->bidder_id).">".$row->BidderInfo->name."</a>";
                return $bidder_name;
            }) 
            ->addColumn('property_name', function($row){
                $property_name =  '<a title="'.$row->BidPropertyInfo->title.'" href="'.route('admin-property-details',$row->BidPropertyInfo->slug).'">'.substr($row->BidPropertyInfo->title, 0, 15).'...</a>';
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
                $bid_status='<button type="button" class="btn btn-info btn-new btn-sm dropdown-toggle bid_status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$row->bid_status.'</button> <div class="dropdown-menu dropdown-menu-right b-none contact-menu"><button class="dropdown-item bid_status_btn" data-id="'.$row->id.'" data-status="Awarded"><i class="fa fa-check"></i>Awarded</button><button class="dropdown-item bid_status_btn" data-id="'.$row->id.'" data-status="Rejected"><i class="fa fa-times"></i>Rejected</button></div>';
              } else if($row->bid_status=="Awarded"){
                $bid_status='<button type="button" class="btn btn-primary btn-awarded btn-sm dropdown-toggle bid_status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$row->bid_status.'</button> <div class="dropdown-menu dropdown-menu-right b-none contact-menu"><button class="dropdown-item bid_status_btn" data-id="'.$row->id.'" data-status="Rejected"><i class="fa fa-times"></i>Rejected</button></div>';
             

              } else if($row->bid_status=="Closed"){
                $bid_status='<button type="button" class="btn btn-primary btn-closed btn-sm  bid_status">'.$row->bid_status.'</button>';
              }
              else if($row->bid_status=="Cancelled"){
                $bid_status='<button type="button" class="btn btn-primary btn-cancelled btn-sm  bid_status">'.$row->bid_status.'</button>';
              }
              else if($row->bid_status=="Blocked"){
                $bid_status='<button type="button" class="btn btn-primary btn-cancelled btn-sm  bid_status">'.$row->bid_status.'</button>';
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
              
               $route_view=route('admin-bid-view',$row->id);
                $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>';
                return $action;
            })  
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                  $instance->where(function($w) use($request){
                    $search = $request->get('search');
                    $w->Where('bid_price', 'LIKE', "%$search%");
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
      return view('admin::bids.index',compact('propertyList','bidderList','getMax','getMin','offerList'));
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }    
  }

  public function checkAwardedBidForProperty($property_id){
    $bidAwarded=Bid::where('property_id',$property_id)->where('bid_status',"Awarded")->get();
    if(isset($bidAwarded) && $bidAwarded->count() == 1){
      return "awarded_found";
    }else{
      return "awarded_not_found";
    }      
  }

  public function updateBidStatus(Request $request){
    try{
      $bidInfo=Bid::with(['BidderInfo','BidPropertyInfo'])->where('id',$request->id)->first();
      $bidderData=User::where('id',$bidInfo->bidder_id)->first();
      $propertyData=Property::where('id',$bidInfo->property_id)->first();
      // $chkAwarded=$this->checkAwardedBidForProperty($bidInfo->property_id);
      // if($chkAwarded == "awarded_found"){
      //  return response()->json(["error"=>"error", "message" => "Bid already approved for this property"]);
      // }
      $mailParams=[$bidInfo->BidderInfo->name,
                  $bidInfo->id,
                  moneyFormat($bidInfo->bid_price),
                  $bidInfo->BidPropertyInfo->title,
                  moneyFormat($bidInfo->BidPropertyInfo->base_price),
                  $bidInfo->BidPropertyInfo->property_code,
                  numberPlaceFormat($bidInfo->BidPropertyInfo->property_size),
                  $bidInfo->BidPropertyInfo->location,
      ];
      //BIDDER_NAME,BID_ID,BIDPRICE,BID_PROPERTY,PROPERTY_PRICE,PROPERTY_NUMBER,PROPERTYSIZE,PROPERTYLOCATION

      if($request->status=="Awarded"){
        Bid::where('id', $request->id)->update(["bid_status"=>$request->status]);
        Bid::where('id','!=', $request->id)->where('property_id', $bidInfo->property_id)->update(["bid_status"=>"Cancelled"]);
        
        //SEND LARAVEL NOTIFICATIONS TO BUYER
        $bidderData->notify(new AdminAwardBidNotification(Auth::user(),$bidInfo,$propertyData));
        
        $receiverNumber=$bidInfo->BidderInfo->country_std_code.$bidInfo->BidderInfo->mobile_no;
        //BIDDER_NAME,BIDPRICE,PROPERTYNAME,PROPERTYCODE
        $sms_params=[$bidInfo->BidderInfo->name,
                    moneyFormat($bidInfo->bid_price),
                    $bidInfo->BidPropertyInfo->title,
                    $bidInfo->BidPropertyInfo->property_code
        ];
       
        dispatch(new SendAddBidSMSToBidders([$receiverNumber,"bid_awarded_sms_to_bidder",$sms_params]));

        $mail_data=["mail_action_name"=>"admin_award_buyer_bid",
                    "mail_short_code_variable"=>$mailParams,
                    "email"=>$bidInfo->BidderInfo->email,
                    "username"=>$bidInfo->BidderInfo->name,
                    "property_name"=>$propertyData->title,
                    "location"=>$propertyData->location,
                    "escrow_status"=>$propertyData->escrow_status,
                    "property_image"=>$propertyData->image,
                    "message_top"=>"Congratulations",
                    "message_top_heading"=>"Your Bid approved by Offercity"];
          
        dispatch(new SendPropertyMail($mail_data));

        //PUSH NOTIFICATION TO BUYER APP WHEN HIS BID AWARDED
        $title="Bid Awarded By Offercity";
        $description="Congratulations! Offercity awarded your bid for Property ".$propertyData->title.".";
        $payload=["property_id"=>$propertyData->id];
        $this->pushNotification($title,$description,$payload,array($bidInfo->bidder_id));
        
        //PUSH NOTIFICATION TO OTHER BIDDERS WHEN BID AWARDED
        $otherBidderBid=Bid::with(['BidderInfo'])->where([['id','!=',$request->id],['property_id',$bidInfo->property_id],['delete_status',0]])->get();
        foreach($otherBidderBid as $li){
          $title="Offercity Awarded Bid of ".$bidInfo->BidderInfo->name.".";
          $description="Hey ".$li->BidderInfo->name.",  Offercity awarded bid of ".$bidInfo->BidderInfo->name." for Property-".$propertyData->title.".";
          $payload=["property_id"=>$propertyData->id];
          
          //SEND LARAVEL NOTIFICATIONS TO BUYER
          $otherBidderInfo=$li->BidderInfo;
          $otherBidderInfo->notify(new AdminAwardBidNotificationToOtherBidder(Auth::user(),$bidInfo,$propertyData));
 
          $test = $this->pushNotification($title,$description,$payload,array($li->bidder_id));
        }
        return response()->json(["success" => "1","message"=>"Bid Awarded Successfully"]);
      }
      if($request->status=="Rejected"){
        Bid::where('id', $request->id)->update(["bid_status"=>$request->status]);
        Bid::where([['id','!=', $request->id],['bid_status',"Cancelled"]])->where('property_id', $bidInfo->property_id)->update(["bid_status"=>"Active"]);
        
        $bidderData->notify(new AdminRejectBidNotification(Auth::user(),$bidInfo,$propertyData));

        $mail_data=["mail_action_name"=>"admin_rejected_buyer_bid",
                  "mail_short_code_variable"=>$mailParams,
                  "email"=>$bidInfo->BidderInfo->email,
                  "username"=>$bidInfo->BidderInfo->name,
                    "property_name"=>$propertyData->title,
                    "location"=>$propertyData->location,
                    "escrow_status"=>$propertyData->escrow_status,
                    "property_image"=>$propertyData->image,
                    "message_top"=>"",
                    "message_top_heading"=>"Your Bid has been rejected by Offercity"];
          
        dispatch(new SendPropertyMail($mail_data));

        $sms_params=[$bidInfo->BidderInfo->name,
        moneyFormat($bidInfo->bid_price),
        $bidInfo->BidPropertyInfo->title,
        $bidInfo->BidPropertyInfo->property_code];

        $receiverNumber=$bidInfo->BidderInfo->country_std_code.$bidInfo->BidderInfo->mobile_no;
        
        dispatch(new SendAddBidSMSToBidders([$receiverNumber,"sms_buyer_bid_rejected_by_admin",$sms_params]));

         //PUSH NOTIFICATION TO BUYER APP WHEN HIS BID Rejected
        $title="Bid Rejected By Offercity";
        $description="Offercity rejected your bid for Property ".$propertyData->title.".";
        $payload=["property_id"=>$propertyData->id];
       
        $this->pushNotification($title,$description,$payload,array($bidInfo->bidder_id));
      
        
        //PUSH NOTIFICATION TO OTHER BIDDERS WHEN BID Rejected
        $otherBidderBid=Bid::with(['BidderInfo'])->where([['id','!=',$request->id],['property_id',$bidInfo->property_id],['delete_status',0]])->get();
        foreach($otherBidderBid as $li){
         
          $title="Offercity Rejected Bid of ".$bidInfo->BidderInfo->name.".";
          $description="Hey ".$li->BidderInfo->name.",  Offercity rejected bid of ".$bidInfo->BidderInfo->name." for Property-".$propertyData->title.".";
          $payload=["property_id"=>$propertyData->id];
         
          //SEND LARAVEL NOTIFICATIONS TO BUYER
          $otherBidderInfo=$li->BidderInfo;
          $otherBidderInfo->notify(new AdminRejectBidNotificationToOtherBidder(Auth::user(),$bidInfo,$propertyData));

          $this->pushNotification($title,$description,$payload,array($li->bidder_id));
        }
          return response()->json(["success" => "1","message"=>"Bid Rejected Successfully"]);
        }  
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function show($id){
    $bidInfo=Bid::with(['BidderInfo','BidPropertyInfo'])->where('id',$id)->first();
    return view('admin::bids.show',compact('bidInfo'));  
  }
   
  public function editDeleteStatus(Request $request){
    try {
      $data = ["delete_status"=>1];
      Bid::where('id', $request->id)->update($data);  
        
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  } 
  
  public function updateStatus(Request $request){
    try{
      $bid=Bid::where('id', $request->id)->first();
      if($bid->status == 1){
        $data = [ "status"=>0];
        Bid::where('id', $request->id)->update($data);
      }else{
        $data = [ "status"=>1];
        Bid::where('id', $request->id)->update($data);
      }
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
   
  public function getMinMaxBidPrice(Request $request){
    try{
      $property_id=$request->property_id;
      $getMax=Bid::where('property_id',$property_id)->where('bid_status','!=',"Rejected")->max('bid_price');
      $getMin=Bid::where('property_id',$property_id)->where('bid_status','!=',"Rejected")->min('bid_price');
     return response()->json(['min'=>$getMin,'max'=>$getMax]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function getBidsPropertyWise($property_id,$status,Request $request){
    $heading=$status." Bids";
   
    $propertyList = Bid::with('BidPropertyInfo')->where('delete_status',0)->groupBy('property_id')->get(); 
    $offerList = PropertyOffer::get(); 
    $bidderList = Bid::with('BidderInfo')->groupBy('bidder_id')->get(); 
    $getMax=Bid::max('bid_price');
    $getMin=Bid::min('bid_price');
    $property_id=$property_id;
    $status=$status;
    if($request->ajax()) {   
      $data =  Bid::with(['BidderInfo','BidPropertyInfo'])->where('property_id',$property_id)->where('bid_status',$status)->where('delete_status',0)->latest();
        return Datatables::of($data)
      ->addIndexColumn()
       
      ->addColumn('bidder_name', function($row){
          $bidder_name = "<a href=".route('admin-user-details',$row->bidder_id).">".$row->BidderInfo->name."</a>";
          return $bidder_name;
      }) 

      ->addColumn('property_name', function($row){
          $property_name =  "<a title=".$row->BidPropertyInfo->title." href=".route('admin-property-details',$row->BidPropertyInfo->slug).">".substr($row->BidPropertyInfo->title, 0, 15)."...</a>";
          return $property_name;
      })

      ->addColumn('offer_id', function($row){
          $offer_id = $row->offer_id;
          return $offer_id;
      })

      ->addColumn('bid_price', function($row){
          $bid_price =  moneyFormat($row->bid_price);
          return $bid_price;
      })

      ->addColumn('bid_status', function($row){
          $bid_status = $row->bid_status;
          return $bid_status;
      })

      ->addColumn('bid_status', function($row){ 
          if($row->bid_status=="Active"){
            $bid_status='<button type="button" class="btn btn-new btn-primary btn-sm dropdown-toggle bid_status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$row->bid_status.'</button> <div class="dropdown-menu dropdown-menu-right b-none contact-menu"><button class="dropdown-item bid_status_btn" data-id="'.$row->id.'" data-status="Awarded"><i class="fa fa-check"></i>Awarded</button><button class="dropdown-item bid_status_btn" data-id="'.$row->id.'" data-status="Rejected"><i class="fa fa-times"></i>Rejected</button></div>';
             
           

          } else if($row->bid_status=="Awarded"){
            $bid_status='<button type="button" class="btn btn-primary btn-awarded btn-sm dropdown-toggle bid_status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$row->bid_status.'</button> <div class="dropdown-menu dropdown-menu-right b-none contact-menu"><button class="dropdown-item bid_status_btn" data-id="'.$row->id.'" data-status="Rejected"><i class="fa fa-times"></i>Rejected</button></div>';
             

          } else if($row->bid_status=="Closed"){
            $bid_status='<button type="button" class="btn btn-primary btn-closed btn-sm  bid_status">'.$row->bid_status.'</button>';
          }
           else if($row->bid_status=="Cancelled"){
            $bid_status='<button type="button" class="btn btn-primary btn-cancelled btn-sm  bid_status">'.$row->bid_status.'</button>';
          }
          else{
            $bid_status='<button type="button" class="btn btn-primary btn-blocked btn-sm dropdown-toggle bid_status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$row->bid_status.'</button> <div class="dropdown-menu dropdown-menu-right b-none contact-menu"><button class="dropdown-item bid_status_btn" data-id="'.$row->id.'" data-status="Awarded"><i class="fa fa-check"></i>Awarded</button></div>'; 
          }
          return $bid_status;
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
        
         $route_view=route('admin-bid-view',$row->id);
          $action=' <a href="'.$route_view.'" title="Show" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>';
          return $action;
      })  

      ->filter(function ($instance) use ($request) {
        if (!empty($request->get('search'))) {
          $instance->where(function($w) use($request){
            $search = $request->get('search');
            $w->Where('bid_price', 'LIKE', "%$search%");
          });
        }
                          
        if($request->get('status') == '0' || $request->get('status') == '1') {
          $instance->where('status', $request->get('status'));
        }
        
        if ($request->get('delete_status') == '0' || $request->get('delete_status') == '1') {
          $instance->where('delete_status', $request->get('delete_status'));
        }

        if ($request->get('property_offer')) {
          $instance->where('offer_id', $request->get('property_offer'));
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
    return view('admin::bids.bid_property_wise',compact('propertyList','bidderList','getMax','getMin','offerList','heading','property_id','status'));
  }
}
