<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminCloseBidNotification extends Notification
{
    use Queueable;

   
    public function __construct($user,$bid,$property)
    {
        $this->user = $user;
        $this->bid = $bid;
        $this->property = $property;
        

       

    }

    public function via($notifiable)
    {

        return ['database'];
    }

    public function toDatabase($notifiable){
        $data=[
           
            'user'=>$this->user->getAttributes(),
            'bid'=>$this->bid->getAttributes(),
            'property'=>$this->property->getAttributes()
        ];

        return $data;
    }

}
