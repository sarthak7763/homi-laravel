<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BuyerAddNotification extends Notification
{
    use Queueable;

   public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    // public function toArray($notifiable)
    // {
    //     return [
    //         'name' => $this->user->name,
    //         'profile_pic' => $this->user->profile_pic,
    //         'created_at'=> $this->user->created_at,
    //         'buyer_id'=> $this->user->id,


    //     ];
    // }

     public function toDatabase($notifiable){
        $data=[
            'user'=>$this->user->getAttributes()
        ];

        return $data;
    }

   
}
