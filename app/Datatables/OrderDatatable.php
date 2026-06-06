<?php

namespace App\Datatables;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderDatatable
{
    public function handel(Request $request)
    {
        try {
            $orders = Order::query()
                ->with('client','saleType:id,name', 'meta')
                ->join('clients','orders.client_id','=','clients.id')
                ->select('clients.name', 'clients.mobile_number', 'orders.*')
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('cash_memo_no', 'like', "%{$request->search['value']}%")
                        ->orWhere('clients.name', 'like', "%{$request->search['value']}%")
                        ->orWhere('clients.mobile_number', 'like', "%{$request->search['value']}%");
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
                    'cash_memo_no' => $row->cash_memo_no,
                    'client_no' => optional($row->client)->client_no,
                    'client' => optional($row->client)->name,
                    'paid' => bd_money_format($row->paid),
                    'vat' => bd_money_format($vat_amount),
                    'itemTotal' => bd_money_format($itemTotal),
                    'subtotal' => bd_money_format($subtotal),
                    'discount' => bd_money_format($row->discount),
                    'total' => bd_money_format($total),
                    'due' => bd_money_format(round($row->total + $row->return_amount - $row->discount - $row->paid)),
                    'date' => formatted_date($row->date),
                    'saleType' => $row->saleType?->name,
                ];
                return $data_array;
            });
            return dataTableResponse($orders->total(), $data);
        } catch (\Throwable $th) {
            if(config('app.env') === 'local'){
                throw $th;
            }
            return dataTableResponse(0);
        }
    }
}
