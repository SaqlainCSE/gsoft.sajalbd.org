<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductInportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('Import Product');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'products.*.product_nr' => [
                'bail','required', 
            ],
            'products.*.product_details' => ['required', 'string'],
            'products.*.weight' => ['required', 'numeric'],
            'products.*.st_dia_price' => ['nullable', 'numeric'],
            'products.*.wage' => ['nullable', 'numeric'],
            'products.*.wage_type' => ['nullable', 'in:Percentage,Fixed'],
            'products.*.st_dia'  => ['nullable', 'numeric'],
            'products.*.supplier_id'  => ['nullable', 'integer']
        ];
    }

    public function prepareForValidation()
    {
        $data = [];

        $products = json_decode($this->products);

        foreach ($products as $product) {
            $data[]=[
                'product_nr' => $product['1'],
                'product_details' => $product['2'],
                'weight' => $product['3'],
                'st_dia'  => $product['4']?: null,
                'st_dia_price' => $product['5']?: null,
                'wage' => $product['6'],
                'wage_type' => $product['7'] ?: 'Fixed',
                'carat' => $product['8']?: null,
                'product_category_id' => $product['9']?: null,
                'purchase_price' => $product['10']?: null,
                'status' => $product['11'],
                'supplier_id' => $product['12']?: null,
                'stock_type' => $product['13']?: null,
                'type' => $product['14']?: null,
            ];
        }

        $this->merge(['products' =>  $data]);
    }

    public function messages()
    {
        return [
            'products.*.product_nr' => 'SL(#:position) product has already added.',
        ];
    }
}
