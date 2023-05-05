<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BuyerUpdateBidNotification extends Notification
{
    use Queueable;

   
    public function __construct($user,$bid)
    {
        $this->user = $user;
        $this->bid = $bid;

    }

    public function via($notifiable)
    {

        return ['database'];
    }

    public function toDatabase($notifiable){
        $data=[
            'bid'=>$this->bid->getAttributes(),
            'user'=>$this->user->getAttributes()
        ];

        return $data;
    }

}
