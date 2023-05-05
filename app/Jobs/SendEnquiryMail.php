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

class SendEnquiryMail implements ShouldQueue
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
      
      $mail_action_name=$this->details['action_name'];
      $mail_params=$this->details['short_codes_variable'];
      $send_email=$this->details['email'];
      $username=@$this->details['username'];
      

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
        $data_mail=["messageBody"=>$messageBody,"username"=>$username];

        Mail::send('emails.enquiry_template', $data_mail, function ($message) use ($data_mail,$email,$email_subject) {
        $message->subject($email_subject);
        $message->to($email);
        $message->from(env('MAIL_USERNAME'));
        $message->setBody($data_mail);
        });
      }
    

    }
}
