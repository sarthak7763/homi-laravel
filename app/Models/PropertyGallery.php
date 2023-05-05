<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;
use URL;

class PropertyGallery extends Model
{
    use HasFactory;

     protected $fillable = [
        'property_id',
        'attachment',
        'type',
        'thumbnail',
        'name',
        'description',
        'add_by',
        'status',
        'delete_status'
    ];

    public function getAttachmentAttribute($value){
        $image_path = base_path().'/public/storage/uploads/PropertyGallery/'.$value;

        if($value != "" && File::exists($image_path)){
        $value = URL::to('/').'/storage/uploads/PropertyGallery/'.$value;
        }else{
        $value = URL::to('/').'/property.jpg';
        }
        return $value;
    }

      public function getThumbnailAttribute($value){
        $image_path = base_path().'/public/storage/uploads/PropertyGallery/'.$value;

        if($value != "" && File::exists($image_path)){
        $value = URL::to('/').'/storage/uploads/PropertyGallery/'.$value;
        }else{
        $value = URL::to('/').'/property.jpg';
        }
        return $value;
    }

   



    public function galleryHasProperty()
    {
        return $this->hasOne('App\Models\Property','id','property_id')->select('id','title');
    }
    
}
