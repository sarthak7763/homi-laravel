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

class SendPropertyMail implements ShouldQueue
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
     
      $mail_action_name=$this->details['mail_action_name'];
      $mail_params=$this->details['mail_short_code_variable'];
      $send_email=$this->details['email'];
      $username=@$this->details['username'];
      $property_name=@$this->details['property_name'];
      $location=@$this->details['location'];
      $escrow_status=@$this->details['escrow_status'];
      $property_image=@$this->details['property_image'];
      $message_top=@$this->details['message_top'];
      $message_top_heading=@$this->details['message_top_heading'];

    
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

        $mail_message= array('messageBody'=> $messageBody,
          'username'=>@$username,
          'property_name'=>@$property_name,
          'location'=>@$location,
          'escrow_status'=>@$escrow_status,
          'property_image'=>$property_image,
          'message_top'=>$message_top,
          'message_top_heading'=>$message_top_heading);
      
        Mail::send('emails.property_template',$mail_message, function ($message) use ($mail_message,$email,$email_subject) {
            $message->subject($email_subject);
            $message->to($email);
            $message->from(env('MAIL_USERNAME'));
            $message->setBody($mail_message);
          });
      }
    

    }
}
