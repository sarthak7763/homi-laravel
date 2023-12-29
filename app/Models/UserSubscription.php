<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use File;
use URL;



class UserSubscription  extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

     protected $fillable = [
        'user_id',
        'subscription_id',
        'plan_id',
        'starting_date',
        'ending_date',
        'delete_status',
        'created_at',
        'updated_at',
        'subscription_status'   
        
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
 
   

}
