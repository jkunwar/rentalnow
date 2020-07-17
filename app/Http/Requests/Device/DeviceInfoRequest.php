<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomValidationException;
use Illuminate\Contracts\Validation\Validator;

class DeviceInfoRequest extends FormRequest
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
            'fcm_token'     => 'required',
            'device_id'     => 'required',
            'device_type'   => 'required|in:android,ios'
        ];
    }
    protected function failedValidation(Validator $validator) {
        throw new CustomValidationException($validator);
    }

    public function messages()
    {
        return [
            'fcm_token.required' => 'The fcm token field is required',
            'device_id.required'  => 'The device id field is required',
            'device_type.required'  => 'The device type field is required',
            'device_type.in' => 'The selected device type is invalid',
        ];
    }
}
