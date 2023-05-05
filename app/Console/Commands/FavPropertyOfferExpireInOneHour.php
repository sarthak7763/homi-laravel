<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{User,Property,PropertyOffer,Bid,DeviceToken,FavProperty};
use Illuminate\Support\Facades\Log;
use App\Helpers\Helper;
use Exception,HasRoles,Mail,Notification;
use Twilio\Rest\Client;
use App\Notifications\{AdminOfferExpireInOneHoueNotification};
use App\Jobs\{SendAddBidSMSToBidders};
use HTTP;

class FavPropertyOfferExpireInOneHour extends Command
{
    protected $signature = 'favpropertyofferexpireinonehour:name';

    protected $description = 'If a buyer has marked few Active properties as their favorites and if from those favorite property has time almost going to end, last hour we push notify the buyer - to tell hey the property you marked as favorite has 1 hour left to bid';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
      \Log::info("Cron Fav Property Offer Expire in 1 hour!");
        
      $q = PropertyOffer::where([
        "sale_status"=>1,
        "notification_status"=>0,
        "delete_status"=>0
      ])
      ->whereRaw("TIMEDIFF(end_timestamp, CURRENT_TIMESTAMP()) > 0")
      ->whereRaw("HOUR(TIMEDIFF(end_timestamp, CURRENT_TIMESTAMP()))=1")
      ->with('OfferPropertyInfo.favProperty.favPropertyUserInfo')
      ->get();
   
      $updateIds=[];
      if(!empty($q)){
        foreach($q as $li){
          $updateIds[]=$li->id;
          $title="Offer On Your favorite Property Expire in 1 hour";
          $description="Offer on your favorite property ".$li->OfferPropertyInfo->title." has going to be expire within one hour.";
          $payload=["property_id"=>$li->property_id];
          $unreadNotifCount=0;
          foreach($li->OfferPropertyInfo->fav_property as $pli){
            $userInfo=$pli->fav_property_user_info;
            if(!empty($userInfo->unreadNotifications)){
              $unreadNotifCount=@$userInfo->unreadNotifications->count();
            }   
            $deviceToken = DeviceToken::where('user_id',$pli->buyer_id)
            ->where('device_token','!=','')
            ->where('status',1)
            ->get();

            $userInfo->notify(new AdminOfferExpireInOneHoueNotification($userInfo,  $li->OfferPropertyInfo));
            foreach($deviceToken as $dli){
              if($dli->device_type=="Android"){
                $device_type = 'Android';
                sendPushNotification($title,$description,array($dli->device_token),$payload,$device_type,$unreadNotifCount);
              }else{
                  $device_type = 'IOS';
                  sendPushNotification($title,$description,array($dli->device_token),$payload,$device_type,$unreadNotifCount);
              }
            } 
          }
        }
         PropertyOffer::whereIn('id',$updateIds)->update(['notification_status'=>1]);
      }
     
    }
}
