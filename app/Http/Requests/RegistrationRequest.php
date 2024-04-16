<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email|max:255',
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'password' => 'required|max:255',
        ];
    }
}
