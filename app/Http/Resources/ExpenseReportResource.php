<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseReportResource extends JsonResource
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
            'trx_head' => $this->trxHead?->name,
            'amount' => bd_money_format($this->amount),
            'raw_amount' => $this->amount,
            'date' => formatted_date($this->date),
            'payment_method' => $this->paymentMethod?->name,
            'reference_no' => $this->reference_no,
            'note' => $this->trx_head_id,
            'expense_by' => $this->expenseBy?->name,
        ];
    }
}
