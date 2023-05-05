<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserValidateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:30|min:3',
            'mobile_no' => 'required|unique:users,mobile_no,' .$this->get('id'),  
            'contact_code' => 'required',
            //'mobile_no' => 'required|digits_between:4,12|unique:users,mobile_no,'.$this->get('id'),
            'email' => 'required|email|unique:users,email,'.$this->get('id').'|regex:/(.+)@(.+)\.(.+)/i',
            'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'city' => 'required',
            'city.*' => 'required',
           
        ];
    }

    public function messages(){
        return [
            'name.required'=>'Name filed is required.',
            'name.max'=>'Full Name length should be less than 30 characters.',
            'name.min'=>'Full Name length should be more than 2 characters.',
            'mobile_no.required'=>'Phone Number is required.',
           // 'mobile_no.digits_between'=>'Enter number between 4 to 12 digits',
            'mobile_no.unique'=>'Phone Number alreay exist.Try new number.',
            'email.required'=>'Email filed is required.',
            'email.unique'=>'Email alreay exist.Try new email.',
            'email.email'=>'Invalid email address.',
            'city.*.required'=>'City is required.'
           
        ];
    }
}
