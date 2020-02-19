<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PermissionsRequest extends FormRequest
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
        if(isset($this->id) && !empty($this->id)){
            if(!is_numeric($this->id)){
                throw new HttpResponseException(response()->json([],400));
            }
        }
        
        switch($this->method()){
            case 'POST':
                return [
                    'name' => 'required|unique:permissions|max:255',
                    'label' => 'required|max:255',
                ]; break;
            case 'PUT':
                return [
                    'name' => 'required|max:255|unique:permissions,name,'.$this->id,
                    'label' => 'required|max:255',
                ]; break;
        }
        
    }


    public function messages()
    {
        return [
            'name.required' => 'نام دسترسی اجباری است',
            'name.unique' => 'نام دسترسی قبلا استفاده شده',
            'label.required' => 'عنوان دسترسی اجباری است',
        ];
    }

}
