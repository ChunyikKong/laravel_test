<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestingUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('testing_user');

        return [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:testing_users,email,' . $id,
            'phone_number'=> 'required|string|unique:testing_users,phone_number,' . $id,
            'password'    => $this->isMethod('post') ? 'required|string|min:6' : 'nullable|string|min:6',
            'status'      => 'required|in:active,inactive',
        ];
    }
}
