<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactenquiry extends Model
{

    protected $table="contact_enquiry";
    protected $fillable = [
      'name','email','message','status'
    ];
}
