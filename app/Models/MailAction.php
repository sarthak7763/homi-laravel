<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailAction extends Model
{
    use HasFactory;
     protected $fillable = [
        'id', 
        'action',
        'options'];
}
