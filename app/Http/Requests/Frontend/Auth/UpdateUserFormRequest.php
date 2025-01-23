<?php

namespace App\Http\Requests\Frontend\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class UpdateUserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [

            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->guard('user')->user()->id,
            'date_of_birth' => 'required|date',
            'password' => ['nullable', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
            'password_confirmation' => 'same:password',
        ];
    }
}
