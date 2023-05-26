<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelReasons extends Model
{

    protected $table="cancel_reasons";
    protected $fillable = [
      'reason_name','reason_description','reason_status'
    ];
}
