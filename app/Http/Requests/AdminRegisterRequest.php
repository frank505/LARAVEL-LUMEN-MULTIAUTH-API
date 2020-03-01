<?php

namespace App\Http\Requests;

use Urameshibr\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required",
            "email"=>"required|email|unique:admin",
            "password"=>"required|min:8",
        ];
    }
    /**
     * Custom message for validation
     *
     * @return array
     */
    
    public function messages()
    {
        return [
            'name.required' => 'name field is required',
            'email.required' => 'email field is required',
            'email.email' => 'please enter a valid email',
            'email.unique:admin'=>'this user exists already',
            'password'=>'required',
            'password.min'=>'password must be eight characters and above',
        ];
    }
    

    protected function failedValidation(Validator $validator) 
    { 
        throw new HttpResponseException(response()->json(
            [
                "success"=>false,
                "error"=>$validator->errors(),
                "message"=>"one or more fields are required"
        ], 422));
     }
    

     //end of this class
}
