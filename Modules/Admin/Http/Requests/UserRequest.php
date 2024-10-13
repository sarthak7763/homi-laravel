<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
   
    // public function authorize()
    // {
    //     return true;
    // }

       public function rules()
    {
        return [
            'name' => 'required|max:30|min:3',
            //'country' => 'required',
           // 'state' => 'required',
            'city' => 'required',
            'city.*' => 'required',
           // 'address'=>'required',
            'mobile_no' => 'required|unique:users,mobile_no',
            'email' => 'required|email|unique:users,email|regex:/(.+)@(.+)\.(.+)/i',
           // 'user_password' => 'required|min:7|same:confirm_password|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
           // 'confirm_password' => 'required|same:user_password',
            'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    public function messages(){
        return [
            'name.required'=>'Full Name is required.',
            'name.max'=>'Full Name length should be less than 30 characters.',
            'name.min'=>'Full Name length should be more than 2 characters.',
            'mobile_no.required'=>'Phone Number is required.',
           
           // 'country.required'=>'Country is required.',
            //'state.required'=>'State is required.',
            'city.*.required'=>'City is required.',
            //'address.required'=>'Address is required.',
           // 'mobile_no.digits_between'=>'Enter number between 4 to 12 digits',
            'mobile_no.unique'=>'Phone Number alreay exist.Try new number.',
            'email.required'=>'Email Field is required.',
            'email.unique'=>'Email alreay exist.Try new email.',
            'email.email'=>'Invalid email address.',
           // 'user_password.required'=>'Password is required.',
           //  'user_password.min'=>'Password should be atleast 7 characters long.',
           // 'user_password.regex'=>'Password should have a minimum of 7 characters with at least 1 special character and alpha numeric characters.',
           // 'confirm_password.required'=>'Confirm Password field is required.',
           // 'confirm_password.same'=>'The password and confirm password must match.',
           // 'user_password.same'=>'The password and confirm password must match.'
        ];
    }
}
