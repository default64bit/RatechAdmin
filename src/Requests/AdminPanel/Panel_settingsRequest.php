<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Panel_settingsRequest extends FormRequest
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
                    'logo' => 'image|size:5000',
                    'title' => 'required|max:255|string',
                ]; break;
            case 'PUT':
                return [
                    'logo' => 'image|size:5000',
                    'title' => 'required|max:255|string',
                ]; break;
        }
        
    }


    public function messages()
    {
        return [
            'title.string' => 'عنوان سایت باید یک رشته باشد',
            'title.max' => 'عنوان سایت حداکثر 255 کاراکتر می تواند باشد',
            
            'logo.image' => 'لوگوی سایت باید با یکی از فرمت های  jpeg, png, bmp, gif, svg, webp آپلود شود',
            'logo.size' => 'لوگوی سایت حداکثر می تواند 5 مگابایت باشد',
        ];
    }

}
