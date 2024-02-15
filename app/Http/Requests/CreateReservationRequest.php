<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateReservationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'reservation_time' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID field is required.',
            'user_id.exists' => 'The selected user ID is invalid.',
            'reservation_time.required' => 'The reservation time field is required.',
            'reservation_time.date' => 'The reservation time must be a valid date.',
        ];
    }
}
