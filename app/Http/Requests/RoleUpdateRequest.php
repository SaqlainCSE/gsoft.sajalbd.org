<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('Edit Role');
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
                    ->ignore($this->route('role')->id)
            ],
            'guard_name' => ['required', 'in:web,api']
        ];
    }

    public function prepareForValidation()
    {
        //
    }
}
