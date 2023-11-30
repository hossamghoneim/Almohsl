<?php

namespace App\Http\Requests;

use App\Rules\ValidateCarNumberUniqueness;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMiniTrackerRequest extends FormRequest
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
            'car_number' => ['required', 'string', 'max:255', new ValidateCarNumberUniqueness],
            'type'     => ['nullable','string','max:255'],
            'location'     => ['required','string'],
            'district'     => ['required','string'],
            'url'     => ['required','string'],
        ];
    }
}
