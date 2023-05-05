<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BuyerAddBidNotification extends Notification
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

    // public function toArray($notifiable)
    // {
    //     return [
    //         'name' => $this->user->name,
    //         'profile_pic' => $this->user->profile_pic,
    //         'created_at'=> $this->user->created_at,
    //         'buyer_id'=> $this->user->id,
    //         'bid_price'=>$this->bid->bid_price,
    //         'bid_id'=>$this->bid->id

    //     ];
    // }
}
