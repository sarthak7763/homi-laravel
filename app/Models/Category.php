<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table="category";
      protected $fillable = [
        'name',
        'name_pt',
        'description',
        'description_pt',
        'category_type',
        'meta_title',
        'meta_title_pt',
        'meta_keywords',
        'meta_keywords_pt',
        'meta_description',
        'meta_description_pt',
        'status',
    ];

   
}
