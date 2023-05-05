<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BuyerComplaintNotification extends Notification
{
    use Queueable;

   
    public function __construct($user,$complaint)
    {
        $this->user = $user;
         $this->complaint = $complaint;
       

    }

    public function via($notifiable)
    {

        return ['database'];
    }

    public function toDatabase($notifiable){
        $data=[
           
            'user'=>$this->user->getAttributes(),
            'complaint'=>$this->complaint->getAttributes()
        ];

        return $data;
    }

}
