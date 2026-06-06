<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('Create User');
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
            'username' => ['required', 'string', Rule::unique('users')],
            'email' => ['nullable', 'email', Rule::unique('users')],
            'role' => ['required', 'string'],
            'password' => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'password' => bcrypt('12345678'),
            'is_active' => $this->filled('is_active'),
        ]);
    }
}
