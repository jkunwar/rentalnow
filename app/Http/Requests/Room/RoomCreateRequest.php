<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomValidationException;
use Illuminate\Contracts\Validation\Validator;

class RoomCreateRequest extends FormRequest
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
            'title'     => 'bail|required|string',
            'currency'  => 'bail|required|in:AUD,USD',
            'rent'  => 'bail|required|numeric|gt:1',
            'move_date' => 'bail|sometimes|required|date|date_format:Y-m-d|after_or_equal:today',
            'leave_date' => 'bail|sometimes|required|date|date_format:Y-m-d|after:move_date',
            'description' => 'bail|sometimes|required|string',

            'address'  => 'bail|required|array',
            'address.latitude'   => [
                                    'bail',
                                    'required_with:address',
                                    'regex:/^(\+|-)?(?:90(?:(?:\.0{1,14})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,14})?))$/u'
                                ],
            'address.longitude' => [
                                    'bail',
                                    'required_with:address',
                                    'regex:/^(\+|-)?(?:180(?:(?:\.0{1,14})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,14})?))$/u'
                                ],
            'address.location' => 'bail|required_with:address',

            'amenities' => 'bail|sometimes|required|array',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new CustomValidationException($validator);
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required',
            'currency.required'  => 'The currency field is required',
            'rent.required'  => 'The rent field is required',

            'move_date.required' => 'The move in date field is required',
            'move_date.date' => 'The move in date is not a valid date',
            'move_date.date_format' => 'The move in does not match the format Y-m-d',
            'move_date.after_or_equal' => 'The move in date must be after or equal to today',

            'leave_date.required' => 'The move out date field is required',
            'leave_date.date' => 'The move out date is not a valid date',
            'leave_date.date_format' => 'The move out does not match the format Y-m-d',
            'leave_date.after' => 'The move out date must be after move in date',

            'address.required' => 'The address field is required',
            'address.array' => 'The address must be an object',
            'address.latitude.required_with' => 'latitude is missing in adddress field',
            'address.latitude.regex' => 'latitude is invalid in adddress field',
            'address.longitude.required_with' => 'longitude is missing in address field',
            'address.longitude.regex' => 'longitude is invalid in adddress field',
            'address.location.required_with' => 'location is missing in address field',

            'amenities.required' => 'The amenities field is required',
            'amenities.array' => 'The amenities must be an array'

        ];
    }
}
