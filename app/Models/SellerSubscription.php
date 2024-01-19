<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerSubscription extends Model
{
    use HasFactory;

    protected $table = "seller_subscription_activation";
    protected $fillable = [
        'user_id',
        'subscription_id',
        'status',
        'fund_amount',
        'fund_screenshot'
    ];
}
