<?php

namespace App\Http\Requests;

use App\Rules\CountryCode;
use App\Rules\Timezone;
use Illuminate\Validation\Rule;

class StoreCinemaHallRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'color' => [
                'required',
                'string',
                Rule::exists('colors', 'slug'),
            ],
            'number_of_rows' => [
                'required',
                'min:1',
                'max:255',
            ],
            'number_of_columns' => [
                'required',
                'min:1',
                'max:255',
            ],
        ];
    }
}
