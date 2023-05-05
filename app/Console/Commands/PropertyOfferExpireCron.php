<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{User,Property,PropertyOffer,Bid,DeviceToken};
use Illuminate\Support\Facades\Log;
use App\Helpers\Helper;
use Exception,HasRoles,Mail,Notification;
use Twilio\Rest\Client;
use App\Notifications\{AdminEscrowPendingNotification};
use App\Jobs\{SendAddBidSMSToBidders};
use HTTP;
class PropertyOfferExpireCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'propertyofferexpire:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Property Escrow Status As Pending Where Property Timer End-Time Expire';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Cron Esrcow Status Update as pending!");
        $property_timer=PropertyOffer::where(['sale_status'=>1,'delete_status'=>0,'status'=>1])->get();
        $updateIds=[];
        if(!$property_timer->isEmpty()){
            foreach($property_timer as $li){

                //IF TODAY DATE
              //  echo $li->date_end;die;
                if($li->date_end == date('Y-m-d')){
                    //CHECK TIME
                  //  echo $li->time_end ;die;
                    if($li->time_end <= date('H:i')){
                      $updateIds[]=$li->id;
                        $property=Property::where([['id',$li->property_id],['escrow_status','!=',"Sold"]])->update(['escrow_status'=>"Pending"]);
                        
                        $bid=Bid::with('BidderInfo','BidPropertyInfo')->where([['property_id',$li->property_id],['bid_status','Active'],['status',1],['delete_status',0]])->get();

                        foreach($bid as $bli){
                            $userInfo=$bli->BidderInfo;
                            $unreadNotifCount=$userInfo->unreadNotifications->count();
                            
                            $title="Property-".$bli->BidPropertyInfo->title." Offer Expire";
                            $description="The Property-".$bli->BidPropertyInfo->title." offer expired you have placed bid";
                            $payload=["property_id"=>$bli->property_id];
                            $deviceToken = DeviceToken::where('user_id',$bli->bidder_id)
                            ->where('device_token','!=','')
                            ->where('status',1)
                            ->first();

                            $userInfo->notify(new AdminEscrowPendingNotification($userInfo,$bli->BidPropertyInfo));

                            if($deviceToken && $deviceToken->device_type=="Android"){
                                $device_type = 'Android';
                                sendPushNotification($title,$description,array($deviceToken->device_token),$payload,$device_type,$unreadNotifCount);
                            }else{
                                $device_type = 'IOS';
                                sendPushNotification($title,$description,array($deviceToken->device_token),$payload,$device_type,$unreadNotifCount);
                            }
                        }  
                    }
                }elseif($li->date_end < date('Y-m-d')){

                    $property_timers=Property::where([['id',$li->property_id],['escrow_status','!=',"Sold"]])->update(['escrow_status'=>"Pending"]);

                    $bid=Bid::with('BidderInfo','BidPropertyInfo')->where([['property_id',$li->property_id],['bid_status','Active'],['status',1],['delete_status',0]])->get();

                   
                }
            } 
          PropertyOffer::whereIn('id',$updateIds)->update(['notif_status_cron'=>1]);
        }
    }



}
