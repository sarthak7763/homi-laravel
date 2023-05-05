<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminPublishPropertyNotification extends Notification
{
    use Queueable;

   
    public function __construct($user,$property)
    {
        $this->user = $user;
        $this->property = $property;
       

    }

    public function via($notifiable)
    {

        return ['database'];
    }

    public function toDatabase($notifiable){
        $data=[
           
            'user'=>$this->user->getAttributes(),
            'property'=>$this->property->getAttributes()
        ];

        return $data;
    }

}
