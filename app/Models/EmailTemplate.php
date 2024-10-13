<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use File;
use URL;


class EmailTemplate extends Model
{
      use HasFactory,HasSlug;

    protected $fillable = [
        'title',
        'subject',
        'slug',
        'content',
      	'instruction',
        'status',
        'created_at',
        'updated_at'

    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
             ->usingSeparator('_');
    }
}
