<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
class CmsPage extends Model
{
    use HasFactory,HasSlug;


     public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('page_name')
            ->saveSlugsTo('page_slug')
            ->slugsShouldBeNoLongerThan(50)
             ->usingSeparator('_');
    }

}
