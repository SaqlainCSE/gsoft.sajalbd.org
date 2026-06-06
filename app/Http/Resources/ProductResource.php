<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_nr' => $this->product_nr,
            'product_details' => $this->product_details,
            'weight' => "{$this->weight}",
            'price' => bd_money_format($this->price),
            'st_dia' => "{$this->st_dia}",
            'st_dia_price' => bd_money_format($this->st_dia_price),
            'status' => $this->status,
            'wage' => $this->wage ? ($this->wage . ($this->wage_type === 'Percentage' ? '(%)' : 'BDT')) : '--',
            'created_at' => formatted_date_time($this->created_at)
        ];
    }
}
