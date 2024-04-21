<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateReservationRequest extends ApiRequest
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
            'user_id' => [
                'sometimes',
                'required',
                'string',
                Rule::exists('users', 'uuid'),
            ],
            'screening_id' => [
                'sometimes',
                'required',
                'string',
                Rule::exists('screenings', 'uuid'),
            ],
            'row_number' => [
                'sometimes',
                'required',
                'integer',
                'min:1',
                'max:255',
            ],
            'column_number' => [
                'sometimes',
                'required',
                'integer',
                'min:1',
                'max:255',
            ],
        ];
    }
}
