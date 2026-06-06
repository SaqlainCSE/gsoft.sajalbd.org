<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleEntryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('Add Sale Entry');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "trx_type" => ['required'],
            "type" => ['required'],
            "date" => ['required', 'date'],
            "memo" => ['required', 'string'],
            "client" => ['required', 'exists:clients,id'],
            "product_nr" =>['required', 'array'],
            "unit_18k" => ['required', 'array'],
            "unit_21k" => ['required', 'array'],
            "unit_22k" => ['required', 'array'],
            "st" => ['required', 'array'],
            "d18k" => ['required', 'array'],
            "dia" => ['required', 'array'],
            "bill_amount" => ['required', 'numeric'],
            "discount" => ['required', 'numeric'],
            "advance" => ['required', 'numeric'],
            "final_bill" => ['required', 'numeric'],
            "gold" => ['required', 'numeric'],
            "cash" => ['required', 'numeric'],
            "dbbl" => ['required', 'numeric'],
            "city_qr" => ['required', 'numeric'],
            "cbbl" => ['required', 'numeric'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'trx_type' => 'out',
            'type' => 2,
        ]);
    }
}
