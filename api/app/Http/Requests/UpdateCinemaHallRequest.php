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
            'cinema_hall_id' => [
                'required',
                'string',
                Rule::exists('cinema_halls', 'uuid'),
            ],
            'movie_id' => [
                'required',
                'string',
                Rule::exists('movies', 'uuid'),
            ],
            'start_at' => [
                'required',
                'date_format:Y-m-d H:i:s',
            ],
        ];
    }
}
