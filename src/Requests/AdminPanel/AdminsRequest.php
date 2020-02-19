<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminsRequest extends FormRequest
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

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(
            response()->json([
                'error'=>$validator->errors()->first(),
                'error_type'=>array_keys($validator->errors()->messages())[0],
            ],422)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(isset($this->id) && !empty($this->id)){
            if(!is_numeric($this->id)){
                throw new HttpResponseException(response()->json([],400));
            }
        }
        
        $rule = [
            'name' => 'required|max:255',
            'family' => 'required|max:255',
            'admin_role' => 'required',
        ];

        switch($this->method()){
            case 'POST':
                $rule['username'] = 'required|unique:admins|regex:/^[a-zA-Z0-9_]+$/|max:255';
                $rule['email'] = 'required|email|max:255|unique:admins,email';
                $rule['phone'] = 'required|numeric|regex:/^(0)(9){1}[0-9]{9}+$/|unique:admins,phone';
                $rule['password'] = 'required|confirmed|min:8';
                break;
            case 'PUT':
                $rule['username'] = 'required|max:255|regex:/^[a-zA-Z0-9_]+$/|unique:admins,username,'.$this->id;
                $rule['email'] = 'required|email|max:255|unique:admins,email,'.$this->id;
                $rule['phone'] = 'required|numeric|regex:/^(0)(9){1}[0-9]{9}+$/|unique:admins,phone,'.$this->id;
                $rule['password'] = 'nullable|confirmed|min:8';
                break;
        }

        return $rule;
    }

}
