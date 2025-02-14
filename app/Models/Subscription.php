<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Sluggable\SlugOptions;

use Spatie\Sluggable\HasSlug;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use File;
use URL;



class Subscription  extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles,HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

     protected $fillable = [
        'name',
        'plan_title',
        'slug',
        'plan_duration',
        'plan_price',
        'product_listing',
        'plan_description',
        'status',
        'delete_status',
        'created_at',
        'updated_at',   
        
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
 
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
             ->usingSeparator('_');
    }


}
