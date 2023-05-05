<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferSaleRequest extends FormRequest
{
   
    

       public function rules()
    {
        return [
            'date_start' => 'required',
            'date_end' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'property_id'=>'required|unique:property_offers,property_id'
        ];
    }

    public function messages(){
        return [
            'date_start.required'=>'Start Date is required.',
            'date_end.required'=>'End Date is required.',
            'time_start.required'=>'Start Time is required.',
            'time_end.required'=>'End Time is required.',
            'property_id.required'=>'Property is required.',
            'property_id.unique'=>'Offer already placed on this property.',

            
        ];
    }
}
