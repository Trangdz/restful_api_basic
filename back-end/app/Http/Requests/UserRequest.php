<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = optional($this->route('user'))->id ?? $this->route('id');

        $rules = [];

        if ($this->has('email')) {
            $rules['email'] = 'required|email|unique:users,email' . ($id ? ",$id" : '');
        }

        if ($this->has('name')) {
            $rules['name'] = 'required|min:4|unique:users,name' . ($id ? ",$id" : '');
        }

        if ($this->has('password')) {
            $rules['password'] = 'required|min:6';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required',
            'min' => 'The :attribute field must be at least :min characters',
            'email' => 'The :attribute field must be a valid email address',
            'unique' => 'The :attribute field must be unique',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'name',
            'email' => 'email address',
            'password' => 'password',
        ];
    }
}
