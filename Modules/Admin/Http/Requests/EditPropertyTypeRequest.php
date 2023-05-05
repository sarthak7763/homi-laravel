<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPropertyTypeRequest extends FormRequest
{
    public function rules()
    {   
        return [
            'name' => "required|unique:property_types,name, ".$this->get('id'),
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    public function messages(){
        return [
            'name.required'=>'Property Type name is required.',
            'name.unique'=>'Property Type name already exist.',
            'icon.image'=>'Select image file only',
            'icon.mimes'=>'Image should be jpeg, jpg, png, gif.'
        ];
    }
}
