<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminSoldPropertyNotificationOther extends Notification
{
    use Queueable;

   
     public function __construct($user,$property,$bid)
    {
        $this->user = $user;
        $this->property = $property;
        $this->bid = $bid;
       

    }

    public function via($notifiable)
    {

        return ['database'];
    }

    public function toDatabase($notifiable){
        $data=[
           
            'user'=>$this->user->getAttributes(),
            'property'=>$this->property->getAttributes(),
            'bid'=>$this->bid->getAttributes()

        ];

        return $data;
    }


}
