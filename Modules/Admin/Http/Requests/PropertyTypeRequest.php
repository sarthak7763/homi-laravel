<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyTypeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:property_types',
           
            'icon' => 'mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    public function messages(){
        return [
            'name.required'=>'Property Type is required.',
            'name.min'=>'Name length should be more than 5 characters.',
           
      
             'icon.mimes'=>'Image should be jpeg, jpg, png, gif.'
        ];
    }
}
