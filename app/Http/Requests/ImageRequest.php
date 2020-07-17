<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomValidationException;
use Illuminate\Contracts\Validation\Validator;

class ImageRequest extends FormRequest
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
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:3072'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new CustomValidationException($validator);
    }

    public function messages()
    {
        return [
            'image.max' => 'The image may not be greater than 3 megabytes',
        ];
    }
}
