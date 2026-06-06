<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('Edit User');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'username' => ['required', 'string', Rule::unique('users')->ignore($this->route('user')->id)],
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($this->route('user')->id)],
            'role' => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->filled('is_active'),
            'set_new_password' => $this->filled('set_new_password'),
        ]);
    }
}
