<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RolesRequest extends FormRequest
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
        throw new HttpResponseException(response()->json(['error'=>$validator->errors()],422));
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
                    'name' => 'required|unique:roles|max:255',
                    'permissions' => 'required',
                ]; break;
            case 'PUT':
                return [
                    'name' => 'required|max:255|unique:roles,id,'.$this->id,
                    'permissions' => 'required',
                ]; break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'نام نقش اجباری است',
            'name.unique' => 'نام نقش قبلا استفاده شده',
            'permissions.required' => 'حداقل یک نقش باید انتخاب شود',
        ];
    }
}
