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
class GlobalSms implements ShouldQueue
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

    
    public function handle()
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_TOKEN");
        $twilio_number = getenv("TWILIO_FROM");
        $sms_text =$this->details['sms_text'];
        $receiverNumber=$this->details['receiver_number'];
        
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($receiverNumber, [
              'from' => $twilio_number, 
              'body' => $sms_text]);
    
           }

    }

