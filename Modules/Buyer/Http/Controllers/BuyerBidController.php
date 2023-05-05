<?php

namespace Modules\Buyer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\{Storage,File,Password};
use App\Password_reset;
use App\Models\{User,State,Bid,City,FavProperty,Property,PropertyOffer,Country,IntrestedCity,MailAction,MailTemplate,SmsTemplate,CmsPage,Reason,Complaint,Enquiry};
use App\Helpers\Helper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash,Auth,Validator,Exception,DataTables,Mail,Str,Notification;
use Illuminate\Mail\Message;
use Carbon\Carbon;
use Twilio\Rest\Client;
use App\Notifications\{BuyerAddNotification,BuyerAddBidNotification,BuyerUpdateBidNotification,BuyerComplaintNotification,BuyerEnquiryNotification};
use App\Jobs\{SendAddBidMailToBidders,SendAddBidSMSToBidders,SendPropertyMail};

class BuyerBidController extends Controller
{

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

  public function updateBuyerBidPrice(Request $request){
   try{
      if(Auth::user()){ 
        $bid_price = intval(str_replace(array(',', '$', ' '), '', $request->bid_price));
        $price=moneyFormat($bid_price);
        $bid_id=$request->bid_id;
        $bidInfo=Bid::where('id',$bid_id)->where('status',1)->where('delete_status',0)->first();
        if($bidInfo){
          $property_timer=PropertyOffer::where('id',$bidInfo->offer_id)->where('sale_status',1)->where('status',1)->where('delete_status',0)->first();
          if($property_timer){
            $propertyInfo=Property::where('id',$bidInfo->property_id)->where('status',1)->where('delete_status',0)->where('escrow_status','Active')->first();
            if($propertyInfo){
               if($bidInfo->bid_status == "Active" || $bidInfo->bid_status == "Rejected"){  
                  $old_bid_price=$bidInfo->bid_price;
                  $old_price=moneyFormat($old_bid_price);
                  $basePrice=moneyFormat($propertyInfo->base_price);

                  if($bid_price > 0){
                    $update=Bid::where('id',$bid_id)->update(['bid_price'=>$bid_price,"bid_status"=>"Active"]);

                    if($update){
                      $mailParams=[Auth::user()->name,
                                  $bid_id,
                                  $old_price,
                                  $price,
                                  $propertyInfo->title,
                                  $basePrice,
                                  $propertyInfo->property_code,
                                  numberPlaceFormat($propertyInfo->property_size),
                                  $propertyInfo->location,
                      ];
                    
                      $adminInfo=getAdminInfo();
                      $adminInfo->notify(new BuyerUpdateBidNotification(Auth::user(),$bidInfo));

                      $sms_params=[Auth::user()->name,
                      $price,
                      $propertyInfo->title,
                      $propertyInfo->property_code];

                      $receiverNumber = Auth::user()->country_std_code.Auth::user()->mobile_no;
          
                      dispatch(new SendAddBidSMSToBidders([$receiverNumber,"bid_price_update_sms",$sms_params])); 

                      $mail_data_admin=["mail_action_name"=>"buyer_update_bid_price",
                                        "mail_short_code_variable"=>$mailParams,
                                        "email"=>$adminInfo->email,
                                        "username"=>$adminInfo->name,
                                        "property_name"=>$propertyInfo->title,
                                        "location"=>$propertyInfo->location,
                                        "escrow_status"=>$propertyInfo->escrow_status,
                                        "property_image"=>$propertyInfo->image,
                                        "message_top"=>"",
                                        "message_top_heading"=>""
                      ];
                      
                      dispatch(new SendPropertyMail($mail_data_admin));

                      $mail_data_bidder=["mail_action_name"=>"buyer_update_bid_price",
                                        "mail_short_code_variable"=>$mailParams,
                                        "email"=>Auth::user()->email,
                                        "username"=>Auth::user()->name,
                                        "property_name"=>$propertyInfo->title,
                                        "location"=>$propertyInfo->location,
                                        "escrow_status"=>$propertyInfo->escrow_status,
                                        "property_image"=>$propertyInfo->image,
                                        "message_top"=>"",
                                        "message_top_heading"=>""
                      ];
                      
                      dispatch(new SendPropertyMail($mail_data_bidder));
                     
                      $getAllBidsofOffer=Bid::where([['property_id',$bidInfo->property_id],['offer_id',$bidInfo->offer_id],['id','!=',$bid_id]])->get();
            
                      if($getAllBidsofOffer){
                        foreach($getAllBidsofOffer as $li){
                          $getUserPhone=User::where('id',$li->bidder_id)->first();
                       
                          if($getUserPhone){
                            if($li->bid_price <= $bid_price){
                                $receiverNumber1 = $getUserPhone->country_std_code.$getUserPhone->mobile_no;
                                $sms_params=[$getUserPhone->name,Auth::user()->name,$price,$propertyInfo->title,$propertyInfo->property_code];

                                dispatch(new SendAddBidSMSToBidders([$receiverNumber1,"sms_to_all_bidders_for_out_bid",$sms_params])); 

                                $mail_params_out_bid=[$getUserPhone->name,
                                                      moneyFormat($li->bid_price),
                                                      Auth::user()->name, 
                                                      $price,
                                                      $propertyInfo->title,
                                                      $propertyInfo->base_price,
                                                      $propertyInfo->property_code,
                                                      numberPlaceFormat($propertyInfo->property_size),
                                                      $propertyInfo->escrow_status,
                                                      $propertyInfo->image
                                ];

                                $mail_data_out_bid=["mail_action_name"=>"mail_to_all_bidders_for_out_bid",
                                                    "mail_short_code_variable"=>$mail_params_out_bid,
                                                    "email"=>$getUserPhone->email,
                                                    "username"=>$getUserPhone->name,
                                                    "property_name"=>$propertyInfo->title,
                                                    "escrow_status"=>$propertyInfo->escrow_status,
                                                    "property_image"=>$propertyInfo->image,
                                                    "message_top"=>"",
                                                    "message_top_heading"=>""
                                ];

                                dispatch(new SendPropertyMail($mail_data_out_bid));

                                $getUserPhone->notify(new BuyerUpdateBidNotification(Auth::user(),$bidInfo));

                                $title="Offercity-Someone Out Bid Your Placed Bid";
                                $description="Some bidder out bid your bid for ".$price." on Property-".$propertyInfo->title.".";
                                $payload=["property_id"=>$propertyInfo->id];
                              
                                $this->pushNotification($title,$description,$payload,array($getUserPhone->id));
                            }
                           
                          }
                        }
                      }
                     
                      return response()->json(["status" => "success"]);
                    }else{
                      return response()->json(["status" => "error","message"=>"Error! Bid cannot update"]);
                    }
                  }else{
                    return response()->json(["status" => "error","message"=>"Bid Price should be more than entered price"]);
                  }
               
                }else{
                 return response()->json(["status" => $bidInfo->bid_status]);
                }  
             
            }else{
              return response()->json(["status" => "error_sold","message"=>"Error! Cannot Update Bid."]);
            }
          }else{
              return response()->json(["status" => "error","message"=>"Error! Cannot Update Bid."]);
            }

        }else{
          return response()->json(["status" => "error","message"=>"Error! Bid not found"]);
        }
      }else{
        return redirect()->route('buyer-login');
      }
    }
    catch(Exception $e){
      echo $e."Something went wrong";
    }
  }

  public function checkBidExist(Request $request){
    if(Auth::user()){ 
      $data=$request->all();
      $bid_price = intval(str_replace(array(',', '$', ' '), '', $data['bid_price']));
       
      $foundBid=Bid::where([['bidder_id',Auth::user()->id],['property_id',$data['property_id']],['offer_id',$data['offer_id']],['delete_status',0]])->get();
      $propertyInfo=Property::where('id',$data['property_id'])->first();
       if($propertyInfo->status == 0){
         return response()->json(["status" => "property_deactivated"]);
       }          
      if($propertyInfo->delete_status == 1){
         return response()->json(["status" => "property_removed"]);
      }
            
      if($propertyInfo->escrow_status == "Sold"){
        return response()->json(["status" => "property_sold"]);
      }

    
      if($foundBid->count() > 0){
        return response()->json(["status" => "bid_found"]);
      }else{
        return response()->json(["status" => "bid_not_found"]);         
      }
    }else{
      return redirect()->route('buyer-login');
    }
  }

  public function saveBid(Request $request){
    if(Auth::user()){ 
      $data=$request->all();
      $bid_price = intval(str_replace(array(',', '$', ' '), '', $data['bid_price']));
       
      $foundBid=Bid::where([['bidder_id',Auth::user()->id],['property_id',$data['property_id']],['offer_id',$data['offer_id']],['delete_status',0]])->get();

      $propertyInfo=Property::where('id',$data['property_id'])->where('status',1)->where('delete_status',0)->where('escrow_status',"Active")->first();

      $propertyOffer=PropertyOffer::where('id',$data['offer_id'])->where('sale_status',1)->where('status',1)->where('delete_status',0)->first();

      if($foundBid){
        if($foundBid->count() > 0){
            return response()->json(["status" => "bid_found"]);
        }
      }
      
      if($propertyInfo){
        if($propertyOffer){
          if($bid_price > 0){
            
            $bid = new Bid;
            $bid->bid_price=$bid_price;
            $bid->bid_status="Active";
            $bid->property_id=$data['property_id'];
            $bid->offer_id=$data['offer_id'];
            $bid->bidder_id=@Auth::user()->id;
            $bid->save();

            if($bid->id) {
              $adminInfo=getAdminInfo();
              $adminInfo->notify(new BuyerAddBidNotification(Auth::user(),$bid));
           
              $bid_prices=moneyFormat($bid_price);
              $base_price=moneyFormat($propertyInfo->base_price);

              $receiverNumber = Auth::user()->country_std_code.Auth::user()->mobile_no;
              $smsParams=[Auth::user()->name,
                $bid_prices,
                $propertyInfo->title,
                $propertyInfo->property_code,
              ];
            
              dispatch(new SendAddBidSMSToBidders([$receiverNumber,"bid_add_sms",$smsParams]));

              $getAllBidsofOffer=Bid::where([['property_id',$data['property_id']],['offer_id',$data['offer_id']],['bidder_id','!=',Auth::user()->id]])->get();
            
              if($getAllBidsofOffer){
                foreach($getAllBidsofOffer as $li){
                  $getUserPhone=User::where('id',$li->bidder_id)->first();
               
                  if($getUserPhone){
                    if($li->bid_price <= $bid_price){
                        $receiverNumber1 = $getUserPhone->country_std_code.$getUserPhone->mobile_no;
                        $sms_params=[$getUserPhone->name,Auth::user()->name, $bid_prices,$propertyInfo->title,$propertyInfo->property_code];

                        dispatch(new SendAddBidSMSToBidders([$receiverNumber1,"sms_to_all_bidders_for_out_bid",$sms_params])); 

                        $mail_params_out_bid=[$getUserPhone->name,
                                              moneyFormat($li->bid_price),
                                              Auth::user()->name, 
                                              $bid_prices,
                                              $propertyInfo->title,
                                              $propertyInfo->base_price,
                                              $propertyInfo->property_code,
                                              numberPlaceFormat($propertyInfo->property_size),
                                              $propertyInfo->escrow_status,
                                              $propertyInfo->image
                        ];

                        $mail_data_out_bid=["mail_action_name"=>"mail_to_all_bidders_for_out_bid",
                                            "mail_short_code_variable"=>$mail_params_out_bid,
                                            "email"=>$getUserPhone->email,
                                            "username"=>$getUserPhone->name,
                                            "property_name"=>$propertyInfo->title,
                                            "escrow_status"=>$propertyInfo->escrow_status,
                                            "property_image"=>$propertyInfo->image,
                                            "message_top"=>"",
                                            "message_top_heading"=>""
                        ];

                        dispatch(new SendPropertyMail($mail_data_out_bid));

                        $title="Offercity-Someone Out Bid Your Placed Bid";
                        $description="Some bidder out bid your bid for ".$bid_prices."on property-".$propertyInfo->title.".";
                        $payload=["property_id"=>$propertyInfo->id];
                        //$user_id[]=$getUserPhone->id;

                        $getUserPhone->notify(new BuyerAddBidNotification(Auth::user(),$bid));

                        $this->pushNotification($title,$description,$payload,array($getUserPhone->id));
                    }
                   
                  }
                }
              }
              
              $mailParams=[Auth::user()->name,
                          $bid->id,
                          $bid_price,
                          $propertyInfo->title,
                          $base_price,
                          $propertyInfo->property_code,
                          numberPlaceFormat($propertyInfo->property_size),
                          $propertyInfo->location
              ];
            
              $adminInfo=getAdminInfo();
              $mail_data_bidder=["mail_action_name"=>"buyer_add_new_bid",
                                "mail_short_code_variable"=>$mailParams,
                                "email"=>Auth::user()->email,
                                "username"=>Auth::user()->name,
                                "property_name"=>$propertyInfo->title,
                                "location"=>$propertyInfo->location,
                                "escrow_status"=>$propertyInfo->escrow_status,
                                "property_image"=>$propertyInfo->image,
                                "message_top"=>"",
                                "message_top_heading"=>""
              ];
              
              dispatch(new SendPropertyMail($mail_data_bidder));
              $mail_data_admin=["mail_action_name"=>"buyer_add_new_bid",
                                "mail_short_code_variable"=>$mailParams,
                                "email"=>$adminInfo->email,
                                "username"=>$adminInfo->name,
                                "property_name"=>$propertyInfo->title,
                                "location"=>$propertyInfo->location,
                                "escrow_status"=>$propertyInfo->escrow_status,
                                "property_image"=>$propertyInfo->image,
                                "message_top"=>"",
                                "message_top_heading"=>""
              ];
                       
              dispatch(new SendPropertyMail($mail_data_admin));
              return response()->json(["status" => "success","result"=>$bid]);
            }else{
              return response()->json(["status" => "error","result"=>"Error! Bid not save"]);
            }  
          }else{
            return response()->json(["status" => "error","result"=>"The Bid price should be more than entered price"]);
          }
        }else{
          return response()->json(["status" => "error","result"=>"Timer Not Set"]);
        }
      }else{
        return response()->json(["status" => "error","result"=>"Property removed by Offercity"]);
      }
    }else{
      return redirect()->route('buyer-login');
    }
  }

  //SHOW BUYER ALL BIDS BY LOAD MORE ON SCROLL BY PAGINATE 
  public function mybids(Request $request) {
    if(Auth::user()){
      $html = '';
      $buyerInfo=User::where('id',@Auth::user()->id)->first();
      
      $myBid=Bid::with(['BidPropertyInfo'=>function($q){
                  $q->where('status',1);
                  $q->where('delete_status',0);
                }])->whereHas('BidPropertyInfo',function($q){
                  $q->where('status',1);
                  $q->where('delete_status',0);
                })->where('bidder_id',@Auth::user()->id)->where('bid_status',"Active")->where('delete_status',0)->where('status',1)->paginate(8);

      $myBidAll=Bid::with(['BidPropertyInfo'=>function($q){
                  $q->where('status',1);
                  $q->where('delete_status',0);
                }])->whereHas('BidPropertyInfo',function($q){
                  $q->where('status',1);
                  $q->where('delete_status',0);
                })->where('bidder_id',@Auth::user()->id)->where('bid_status',"Active")->where('delete_status',0)->where('status',1)->get()->toArray();

      if($request->ajax()){
       
        if($myBid->count() > 0){
          foreach($myBid as $li){
            $base_price=moneyFormat($li->BidPropertyInfo->base_price);
            $bid_price=moneyFormat($li->bid_price);
            $property_size=numberPlaceFormat($li->BidPropertyInfo->property_size);

            $property_timer=PropertyOffer::where('id',$li->offer_id)->where('sale_status',1)->where('status',1)->where('delete_status',0)->first();
            if($property_timer){
              $disabled_class="";
            }else{
              $disabled_class="disabled_offer_time";
            }

            if($li->BidPropertyInfo->escrow_status=="Pending"){
              $html.='<li><div class="d-flex align-items-center justify-content-between"><div class="leftImg"><img class="userBox" src="'.$li->BidPropertyInfo->image.'" /></div><div class="midDtl"><div class="imgDetails w-100"><p class="m-0">'.$li->BidPropertyInfo->title.'</p><div class="priceBx"><span class="float-left mainPrice">'.$base_price.'</span></div><div class="addressBox"><i class="heartIcon"><img src="'.$li->BidPropertyInfo->property_pic.'"></i>'.$li->BidPropertyInfo->location.'</div><div class="accomodation"><div class="row"><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/home.svg"></i><p class="aco_left">Built <span class="d-block">'.$li->BidPropertyInfo->year_from.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/area.svg"></i><p class="aco_left">Sq. Ft <span class="d-block">'.$property_size.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bathroom.svg"></i><p class="aco_left">Bathroom <span class="d-block">'.$li->BidPropertyInfo->no_of_bathroom.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bedroom.svg"></i><p class="aco_left">Bedroom <span class="d-block">'.$li->BidPropertyInfo->no_of_bedroom.'</span></p></div><a href="'.route("buyer-property-detail",$li->BidPropertyInfo->slug).'" class="seeDetails">See Details</a></div></div></div></div><div class="rightPrice"><div class="priceDetails"><h3 class="bidPriceLabel">'.$bid_price.'</h3><input type="text" placeholder="Enter Bid Price" style="display: none" maxlength="12" name="bid_price" maxlength="12" class="inputTextBidPrice autonumber form-control setBox" data-a-sign="$" data-v-min="0" data-v-max="999999999999"><p class="bidPriceP">Your Bid Price</p></div></div></div></li>';
            }
            else{
              $html.='<li><div class="d-flex align-items-center justify-content-between"><div class="leftImg"><img class="userBox" src="'.$li->BidPropertyInfo->image.'" /></div><div class="midDtl"><div class="imgDetails w-100"><p class="m-0">'.$li->BidPropertyInfo->title.'</p><div class="priceBx"><span class="float-left mainPrice">'.$base_price.'</span></div><div class="addressBox"><i class="heartIcon"><img src="'.$li->BidPropertyInfo->property_pic.'"></i>'.$li->BidPropertyInfo->location.'</div><div class="accomodation"><div class="row"><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/home.svg"></i><p class="aco_left">Built <span class="d-block">'.$li->BidPropertyInfo->year_from.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/area.svg"></i><p class="aco_left">Sq. Ft <span class="d-block">'.$property_size.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bathroom.svg"></i><p class="aco_left">Bathroom <span class="d-block">'.$li->BidPropertyInfo->no_of_bathroom.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bedroom.svg"></i><p class="aco_left">Bedroom <span class="d-block">'.$li->BidPropertyInfo->no_of_bedroom.'</span></p></div><a href="'.route("buyer-property-detail",$li->BidPropertyInfo->slug).'" class="seeDetails">See Details</a></div></div></div></div><div class="rightPrice"><div class="priceDetails"><h3 class="bidPriceLabel">'.$bid_price.'</h3><input type="text" placeholder="Enter Bid Price" style="display: none" maxlength="12" name="bid_price" maxlength="12" class="inputTextBidPrice autonumber form-control setBox" data-a-sign="$"  data-v-min="0" data-v-max="999999999999"><p class="bidPriceP">Your Bid Price</p></div><button class="changeLink text-primary changeBidPricebtn '.$disabled_class.'">Change?</button><button class="changeLink text-primary saveBidPricebtn" data-id="'.$li->id.'" style="display: none">Save Price</button> <button class="changeLink text-danger cancelBidPricebtn" data-id="'.$li->id.'" style="display: none">Cancel</button></div></div></li>';
            }
          }
        
           return response()->json(['bid_list'=>$html,'status'=>1,'count_bid'=>$myBid->count()]); 
        }else{
          if(empty($myBidAll)){
               return response()->json(['bid_list'=>"",'status'=>2]); 
          }else{
            return response()->json(['bid_list'=>"",'status'=>0]); 
          }
        }
      } 
      return view('buyer::mybids',compact('buyerInfo')); 
    }else{
      return redirect()->route('buyer-login');
    }   
  }

  //SHOW BUYER ALL BIDS BY LOAD MORE ON SCROLL BY PAGINATE 
  public function mybidsByStatus(Request $request) {
    if(Auth::user()){ 
      $html = '';
      $bid_status="Active";
      if($request->bid_status!=""){
         $bid_status=$request->bid_status;
      }
      $buyerInfo=User::where('id',@Auth::user()->id)->first();
      $myBidAll=Bid::with(['BidPropertyInfo'=>function($q){
                  $q->where('status',1);
                  $q->where('delete_status',0);
                }])->whereHas('BidPropertyInfo',function($q){
                  $q->where('status',1);
                  $q->where('delete_status',0);
                })->where([['bidder_id',@Auth::user()->id],['bid_status',$bid_status],['delete_status',0],['status',1]])->get()->toArray();

      $myBid=Bid::with(['BidPropertyInfo'=>function($q){
                  $q->where('status',1);
                  $q->where('delete_status',0);
                }])->whereHas('BidPropertyInfo',function($q){
                  $q->where('status',1);
                  $q->where('delete_status',0);
                })->where([['bidder_id',@Auth::user()->id],['bid_status',$bid_status],['delete_status',0],['status',1]])->paginate(8);
       
        if($request->ajax()){
          if($myBid->count() > 0){
            foreach ($myBid as $li){
              $base_price=moneyFormat($li->BidPropertyInfo->base_price);
              $bid_price=moneyFormat($li->bid_price);
              $property_size=numberPlaceFormat($li->BidPropertyInfo->property_size);
              $property_timer=PropertyOffer::where('id',$li->offer_id)->where('sale_status',1)->where('status',1)->where('delete_status',0)->first();
              if($property_timer){
                $disabled_class="";
              }else{
                $disabled_class="disabled_offer_time";
              }
              if($li->bid_status=="Awarded" || $li->bid_status=="Closed" || $li->bid_status=="Blocked"|| $li->bid_status=="Cancelled"){
                $html.='<li><div class="d-flex align-items-center justify-content-between"><div class="leftImg"><img class="userBox" src="'.$li->BidPropertyInfo->image.'" /></div><div class="midDtl"><div class="imgDetails w-100"><p class="m-0">'.$li->BidPropertyInfo->title.'</p><div class="priceBx"><span class="float-left mainPrice">'.$base_price.'</span></div><div class="addressBox"><i class="heartIcon"><img src="'.$li->BidPropertyInfo->property_pic.'"></i>'.$li->BidPropertyInfo->location.'</div><div class="accomodation"><div class="row"><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/home.svg"></i><p class="aco_left">Built <span class="d-block">'.$li->BidPropertyInfo->year_from.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/area.svg"></i><p class="aco_left">Sq. Ft <span class="d-block">'.$property_size.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bathroom.svg"></i><p class="aco_left">Bathroom <span class="d-block">'.$li->BidPropertyInfo->no_of_bathroom.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bedroom.svg"></i><p class="aco_left">Bedroom <span class="d-block">'.$li->BidPropertyInfo->no_of_bedroom.'</span></p></div><a href="'.route("buyer-property-detail",$li->BidPropertyInfo->slug).'" class="seeDetails">See Details</a></div></div></div></div><div class="rightPrice"><div class="priceDetails"><h3 class="bidPriceLabel">'.$bid_price.'</h3></div></div></div></li>';
              }else{
                $html.='<li><div class="d-flex align-items-center justify-content-between"><div class="leftImg"><img class="userBox" src="'.$li->BidPropertyInfo->image.'" /></div><div class="midDtl"><div class="imgDetails w-100"><p class="m-0">'.$li->BidPropertyInfo->title.'</p><div class="priceBx"><span class="float-left mainPrice">'.$base_price.'</span></div><div class="addressBox"><i class="heartIcon"><img src="'.$li->BidPropertyInfo->property_pic.'"></i>'.$li->BidPropertyInfo->location.'</div><div class="accomodation"><div class="row"><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/home.svg"></i><p class="aco_left">Built <span class="d-block">'.$li->BidPropertyInfo->year_from.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/area.svg"></i><p class="aco_left">Sq. Ft <span class="d-block">'.$property_size.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bathroom.svg"></i><p class="aco_left">Bathroom <span class="d-block">'.$li->BidPropertyInfo->no_of_bathroom.'</span></p></div><div class="col-sm d-flex align-items-center"><i class="heartIcon"><img src="/assets_front/images/icons/bedroom.svg"></i><p class="aco_left">Bedroom <span class="d-block">'.$li->BidPropertyInfo->no_of_bedroom.'</span></p></div><a href="'.route("buyer-property-detail",$li->BidPropertyInfo->slug).'" class="seeDetails">See Details</a></div></div></div></div><div class="rightPrice"><div class="priceDetails"><h3 class="bidPriceLabel">'.$bid_price.'</h3><input type="text" placeholder="Enter Bid Price" style="display: none" maxlength="12" name="bid_price" maxlength="12" class="inputTextBidPrice autonumber form-control setBox" data-a-sign="$"  data-v-min="0" data-v-max="999999999999"><p class="bidPriceP">Your Bid Price</p></div><button class="changeLink text-primary changeBidPricebtn '.$disabled_class.'">Change?</button><button class="changeLink text-primary saveBidPricebtn" data-id="'.$li->id.'" style="display: none">Save Price</button> <button class="changeLink text-danger cancelBidPricebtn" data-id="'.$li->id.'" style="display: none">Cancel</button></div></div></li>';
              } 
            }
             return response()->json(['bid_list'=>$html,'status'=>1,'count_bid'=>$myBid->count()]); 
          }else{
            if(empty($myBidAll)){
              return response()->json(['bid_list'=>"",'status'=>2]); 
            }else{
              return response()->json(['bid_list'=>"",'status'=>0]); 
            }
          }
        }
    }else{
       return redirect()->route('buyer-login');
    }   
  }
}