<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use File;
use URL;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles,HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'slug',
        'buyer_id',
        'profile_pic',
        'status',
        'delete_status',
        'created_at',
        'updated_at',   
        'remember_token',
        'email_verified',
        'email_verification_token',
        'is_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

     public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
             ->usingSeparator('_');
    }
}
