<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use File;
use URL;


class Email extends Model
{
      use HasFactory;

      protected $table="email_templates";

    protected $fillable = [
        'name',
        'subject',
        'message',
        'email_type',
      	'created_at',
        'updated_at'

    ];

    }
