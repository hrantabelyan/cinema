<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateCinemaHallRequest extends ApiRequest
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
                'sometimes',
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'color' => [
                'sometimes',
                'required',
                'string',
                Rule::exists('colors', 'slug'),
            ],
        ];
    }
}
