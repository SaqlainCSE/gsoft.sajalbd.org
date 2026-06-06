<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerImportRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customers.*.name' => 'required',
            'customers.*.mobile_number' => [
                'required',
                'unique:clients,mobile_number',
                //'phone:BD'
            ],
            'customers.*.address' => ['nullable', 'string'],
            'customers.*.customer_category_id' => ['nullable', 'integer'],
            'customers.*.district_id' => ['nullable', 'integer'],
            'customers.*.zone_id' => ['nullable', 'integer'],
            'customers.*.fb_name' => ['nullable', 'string'],

        ];
    }
    public function prepareForValidation()
    {
        $data = [];

        foreach ($this->customers as $product) {
            $data[]=[
                'name' => @$product['1'],
                'mobile_number' => @$product['2'],
                'address' => @$product['3'],
                'customer_category_id'  => @$product['4'],
                'district_id' => @$product['5'],
                'zone_id' => @$product['6'],
                'fb_name' => @$product['7'] ?: '',
            ];
        }

        $this->merge(['customers' =>  $data]);
    }
}
