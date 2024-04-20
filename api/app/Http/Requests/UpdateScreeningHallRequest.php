<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateScreeningRequest extends ApiRequest
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
            'cinema_hall_id' => [
                'sometimes',
                'required',
                'string',
                Rule::exists('colors', 'uuid'),
            ],
            'movie_id' => [
                'sometimes',
                'required',
                'string',
                Rule::exists('colors', 'uuid'),
            ],
        ];
    }
}
