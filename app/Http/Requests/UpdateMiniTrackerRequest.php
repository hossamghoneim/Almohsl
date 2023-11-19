<?php

namespace App\Http\Requests;

use App\Rules\ValidateCarNumberUniqueness;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMiniTrackerRequest extends FormRequest
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
        $id = $this->route('mini_tracker');

        return [
            'car_number' => ['required', 'string', 'max:255', new ValidateCarNumberUniqueness($id)],
            'type'     => ['required','string','max:255'],
            'location'     => ['required','string'],
            'lat' => ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'lng' => ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'district'     => ['required','string'],
        ];
    }
}
