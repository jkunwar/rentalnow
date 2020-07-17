<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomValidationException;
use Illuminate\Contracts\Validation\Validator;

class MessageRequest extends FormRequest
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
            'message'  => 'bail|required|string',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new CustomValidationException($validator);
    }

    public function messages()
    {
        return [
            'message.required' => 'The message field is required',
        ];
    }
}
