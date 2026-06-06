<?php

namespace App\Datatables;

use App\Models\Booking;
use Illuminate\Http\Request;

class StockDatatable
{
    public function handel(Request $request)
    {
        try {
            $orders = Booking::query()
                ->with('client', 'meta')
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('id', 'like', "%{$request->search['value']}%");
                })
                ->latest()
                ->paginate($request->length);

            if ($request->page && $request->page > 1) {
                $no = (((int) $request->page - 1) * $request->length) + 1;
            } else {
                $no = 1;
            }

            $data = $orders->map(function ($row, $index) use ($no) {
                $vat_amount = $row->meta->sum('vat_amount');
                $itemTotal = $row->meta->sum('total') - $vat_amount;
                $subtotal = $row->meta->sum('total');
                $total = $itemTotal + $vat_amount - $row->discount;

                $data_array = [
                    'no' => $index + $no,
                    'id' => $row->id,
                    'booking_id' => $row->id,
                    'client_no' => $row->client->client_no,
                    'client' => $row->client->name,
                    'paid' => bd_money_format($row->paid),
                    'vat' => bd_money_format($vat_amount),
                    'itemTotal' => bd_money_format($itemTotal),
                    'subtotal' => bd_money_format($subtotal),
                    'discount' => bd_money_format($row->discount),
                    'total' => bd_money_format($total),
                    'due' => bd_money_format($row->due?:0),
                    'date' => formatted_date($row->date),
                ];
                return $data_array;
            });
            return dataTableResponse($orders->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}
