<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomValidationException;
use Illuminate\Contracts\Validation\Validator;

class UserUpdateRequest extends FormRequest
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
            'name'     => 'bail|sometimes|required|string',
            'gender'  => 'bail|sometimes|required|in:male,female,other',
            'dob' => 'bail|sometimes|required|date|date_format:Y-m-d|before:today',
            'phone_number' => 'bail|sometimes|required',
            'email' => 'bail|sometimes|required|email',

            'address'           => 'bail|sometimes|array',
            'address.country'   => 'bail|required_with:address|max:32',
            'address.country_code' => 'bail|required_with:address',
            'address.location_id' => 'bail|required_with:address',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new CustomValidationException($validator);
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required',
            'gender.required'  => 'The gender field is required',
            'gender.in'  => 'The selectd gender is invalid',

            'dob.required' => 'The dob field is required',
            'dob.date' => 'The dob is not a valid date',
            'dob.date_format' => 'The dob does not match the format Y-m-d',
            'dob.after_or_equal' => 'The dob must be after or equal to today',

            'address.required' => 'The address field is required',
            'address.array' => 'The address must be an object',
            'address.country.required_with' => 'country is missing in adddress field',
            'address.country_code.required_with' => 'country code is missing in address field',
            'address.location_id.required_with' => 'location id is missing in address field',
        ];
    }
}
