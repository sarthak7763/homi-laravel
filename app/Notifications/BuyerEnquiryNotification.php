<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BuyerEnquiryNotification extends Notification
{
    use Queueable;

   
    public function __construct($user,$enquiry)
    {
        $this->user = $user;
        $this->enquiry = $enquiry;
       

    }

    public function via($notifiable)
    {

        return ['database'];
    }

    public function toDatabase($notifiable){
        $data=[
           
            'user'=>$this->user->getAttributes(),
            'enquiry'=>$this->enquiry->getAttributes()
        ];

        return $data;
    }

}
