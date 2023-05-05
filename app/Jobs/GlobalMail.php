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
use Illuminate\Mail\Message;

class GlobalMail implements ShouldQueue
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
      
      $username=$this->details['username'];
      $email_subject=$this->details['subject'];
      $messageBody=$this->details['mail_body'];
      $email=@$this->details['email'];
     
        Mail::send('emails.email_template', array('messageBody'=> $messageBody,'username'=>@$username), function ($message) use ($messageBody,$email,$email_subject) {
        $message->subject($email_subject);
        $message->to($email);
        $message->from(env('MAIL_USERNAME'));
        $message->setBody($messageBody);
        });
      }
    

    }

