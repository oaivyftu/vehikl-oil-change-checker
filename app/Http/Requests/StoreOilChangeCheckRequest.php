<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOilChangeCheckRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_odometer' => [
                'required',
                'integer',
                'min:0',
                'gte:previous_oil_change_odometer',
            ],
            'previous_oil_change_date' => [
                'required',
                'date',
                'before:today',
            ],
            'previous_oil_change_odometer' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'current_odometer.gte' => 'The current odometer must be greater than or equal to the previous oil change odometer.',
            'previous_oil_change_date.before' => 'The previous oil change date must be before today.',
        ];
    }
}
