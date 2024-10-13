<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use File;
use URL;


class SystemSetting extends Model
{
    use HasFactory,HasSlug;

    protected $fillable = [
        'option_name',
        'option_slug',
        'option_value',
        'status',
        'setting_type'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('option_name')
            ->saveSlugsTo('option_slug');
    }
 

    
}
