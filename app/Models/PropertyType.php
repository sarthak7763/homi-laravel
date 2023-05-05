<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use File;
use URL;

class PropertyType extends Model
{
    use HasFactory,HasSlug;

    protected $fillable = [
        'name',
        'icon',
        'description',
        'status',
      	'slug',
        'delete_status'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
             ->usingSeparator('_');
    }

    public function getIconAttribute($value){
        $image_path = base_path().'/public/storage/uploads/property_type/'.$value;

        if($value != "" && File::exists($image_path)){
        $value = URL::to('/').'/storage/uploads/property_type/'.$value;
        }else{
        $value = URL::to('/').'/no_image/category.jpg';
        }
        return $value;
    }
}
