<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
{

    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('admin') ? $this->route('admin')->id : auth()->user()->id;

        return [
            'name'     => ['required', 'string', 'max:255'],
            'phone'    => ['required','string','max:255', Rule::unique('admins')->ignore($id)],
            'email'    => ['required','string','email', Rule::unique('admins')->ignore($id)],
            //'roles'    => ['required','array','min:1'],
            'password' => ['nullable','exclude_if:password,null','string','min:6','max:255','confirmed'],
            'password_confirmation' => ['nullable','exclude_if:password_confirmation,null','same:password'],
        ];
    }
}
