<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'client_no' => $this->client_no,
            'name' => $this->name,
            'mobile_number' => $this->mobile_number,
            'address' => $this->address,
            'created_at' => formatted_date($this->created_at),
            'category' => optional($this->category)->name,
            'district' => optional($this->district)->name,
            'zone' => optional($this->zone)->name,
            'photo' => optional($this)->getFirstMediaUrl('photo'),
            'fb_name' => $this->fb_name
        ];
    }
}
