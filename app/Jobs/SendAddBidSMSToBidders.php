<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail,Str;
use App\Models\{User,Bid,Property,PropertyOffer,MailAction,MailTemplate,SmsTemplate}; 
use Twilio\Rest\Client;
use Illuminate\Mail\Message;
class SendAddBidSMSToBidders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $account_sid = getenv("TWILIO_SID");
          $auth_token = getenv("TWILIO_TOKEN");
          $twilio_number = getenv("TWILIO_FROM");

          $sms_action_name=$this->details[1];
          $receiverNumber=$this->details[0];
          $sms_dynamic_params=$this->details[2];

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

    }
}
