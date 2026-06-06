<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatatableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => ['required', 'integer'],
            'length' => ['required', 'integer', 'min:1'],
            'search' => ['array'],
            'search.value' => ['nullable', 'string'],
            'order' => ['array'],
            'order.*.column' => ['nullable', 'integer'],
            'order.*.dir' => ['nullable', 'in:asc,desc'],
        ];
    }

    public function prepareForValidation()
    {
        $page = $this->start ? (int) ceil($this->start / $this->length + 1) : 0;

        $this->merge([
            'page' => $page
        ]);
    }
}
