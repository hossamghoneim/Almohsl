<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_admins');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'phone'     => ['required','string','max:255','unique:admins'],
            'email'     => ['required','string','email','unique:admins'],
            //'roles'     => ['required','array','min:1'],
            'password'  => ['required','string','min:6','max:255','confirmed'],
            'password_confirmation' => ['required','same:password'],
        ];
    }
}
