<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPropertyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|min:5',
            'base_price' =>'required',
            'seller_price'=>'required',
            //'price_to' =>'required',
            'cat_type' => 'required',
            'property_size' => 'required',
             'lot_size' => 'required',
            //'address' => 'required',
            'location' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'image'        =>  'required|image|mimes:jpg,png,jpeg,gif,svg|max:9048|dimensions:min_width=100,min_height=100,max_width=8000,max_height=8000',
            //'latitude'=>'required',
           // 'longitude'=>'required',
        ];
    }

    public function messages(){
        return [
            'title.required'=>'Property Title is required.',
            'title.min'=>'Property Title length should be more than 5 characters.',
            'base_price.required'=>'List Price is required.',
            'seller_price.required'=>'Seller Price is required.',
            //'price_to.required'=>'Max Price is required.',
            'cat_type.required'=>'Property Type is required.',
            'property_size.required'=>'Living SqFt is required.',
              'lot_size.required'=>'Lot Size is required.',
           // 'address.required'=>'Address is required.',
            'location.required'=>'Address is required.',
            'country.required'=>'Country is required.',
            'state.required'=>'State is required.',
            'city.required'=>'City is required.',
            'image.required'=>'Property Featured image is required.',
            'image.image'=>'Select Image file only',
            'image.mimes'=>'Image should be jpeg, jpg, png, gif.',
            //'latitude'=>'latitude is required',
            //'longitude'=>'longtitude is required',
        ];
    }
}
