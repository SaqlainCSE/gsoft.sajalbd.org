<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('Access Settings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'company_name' => ['required', 'string'],
            'company_cell' => ['required', 'phone:BD'],
            'bin' => ['required', 'string'],
            'jakat_percentage' => ['required', 'numeric'],
        ];
    }

    public function prepareForValidation()
    {
        //
    }
}
