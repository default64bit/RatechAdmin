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
            'permissions' => 'required|json',
            'permissions.*' => 'required|exists:permissions,id',
        ];

        switch($this->method()){
            case 'POST':
                $rule['name'] = 'required|unique:roles|max:255';
                break;
            case 'PUT':
                $rule['name'] = 'required|max:255|unique:roles,id,'.$this->id;
                break;
        }

        return $rule;
    }
}
