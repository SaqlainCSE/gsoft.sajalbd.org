<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('Create Role');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'not_in:Super Admin,Admin',
                Rule::unique('roles', 'name')
                    ->when($this->user()->branch_id, function ($q) {
                        return $q->where('branch_id', $this->user()->branch_id);
                    })
                    ->where('guard_name', $this->guard_name)
            ],
            'guard_name' => ['required', 'in:web,api'],
            'is_active' => ['required'],
            'is_delete_able' => ['required']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'is_delete_able' => 1,
            'is_active' => 1,
        ]);
    }
}
