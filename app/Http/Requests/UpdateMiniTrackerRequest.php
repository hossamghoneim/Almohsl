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
            'type'     => ['nullable','string','max:255'],
            'location'     => ['required','string'],
            'district'     => ['required','string'],
            'url'     => ['required','string'],
        ];
    }
}
