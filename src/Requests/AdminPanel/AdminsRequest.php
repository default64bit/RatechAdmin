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

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['error'=>$validator->errors()->first()],422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()){
            case 'POST':
                return [
                    'name' => 'required|max:255',
                    'username' => 'required|unique:admins|max:255',
                    'email' => 'required|email|max:255|unique:admins',
                    'password' => 'required|confirmed|min:8',
                    'admin_roles' => 'required',
                ]; break;
            case 'PUT':
                return [
                    'name' => 'required|max:255',
                    'username' => 'required|max:255|unique:admins,username,'.$this->id,
                    'email' => 'required|email|max:255|unique:admins,email,'.$this->id,
                    'password' => 'nullable|confirmed|min:8',
                    'admin_roles' => 'required',
                ]; break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'نام ادمین اجباری است',

            'username.required' => 'نام کاربری ادمین اجباری است',
            'username.unique' => 'نام کاربری ادمین قبلا استفاده شده',

            'email.required' => 'ایمیل اجباری است',
            'email.email' => 'ایمیل معتبر نیست',
            'email.unique' => 'ایمیل ادمین قبلا استفاده شده',

            'password.required' => 'گذرواژه اجباری است',
            'password.min' => 'گذرواژه باید حداقل 8 کاراکتر باشد',

            'admin_roles.required' => 'حداقل یک دسترسی باید انتخاب شود',
        ];
    }

}
