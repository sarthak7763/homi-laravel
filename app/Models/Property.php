<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use File;
use URL;


class Property extends Model
{

    use HasFactory,HasSlug;
        protected $table="tbl_property";
        protected $fillable = [
        'title',
        'title_pt',
        'slug',
        'add_by',
        'property_type',
        'property_description',
        'property_category',
        'guest_count',
        'no_of_bathroom',
        'no_of_bedroom',
        'no_of_kitchen',
        'no_of_pool',
        'no_of_garden',
        'no_of_balcony',
        'no_of_floors',
        'property_area',
        'property_condition',
        'property_address',
        'property_address_pt',
        'property_latitude',
        'property_longitude',
        'property_email',
        'property_number',
        'property_image',
        'property_price',
        'property_price_type',
        'meta_title',
        'meta_title_pt',
        'meta_description',
        'meta_description_pt',
        'meta_keywords',
        'meta_keywords_pt',
        'property_description',
        'property_description_pt',
        'property_status',
        'delete_status'
    ];

      public function scopeNearestInMiles($query, $mi, $centerLat, $centerLng)
    {
        return $query
            ->select(\DB::raw("*,(3958.8  *
                                acos(
                                        cos( radians(" . $centerLat . ") ) *
                                        cos( radians( latitude ) ) *
                                        cos( radians( longitude ) - radians(" . $centerLng . ") ) +
                                        sin( radians(" . $centerLat . ")) *
                                        sin( radians( latitude ) )
                                    )
                            )
                            AS distance"))
            ->having('distance', '<', $mi)
            ->orderBy('distance');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
             ->usingSeparator('_');
    }

    public function getImageAttribute($value){
        $image_path = base_path().'/public/storage/uploads/property/'.$value;

        if($value != "" && File::exists($image_path)){
        $value = URL::to('/').'/storage/uploads/property/'.$value;
        }else{
        $value = URL::to('/').'/no_image/property.jpg';
        }
        return $value;
    }

}
