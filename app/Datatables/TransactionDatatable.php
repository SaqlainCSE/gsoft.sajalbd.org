<?php

namespace App\Datatables;

use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;

use function Deployer\option;

class TransactionDatatable
{
    public function handel(Request $request)
    {
        try {
            $clients = Transaction::query()
                ->with('client')
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('cash_memo_no', 'like', "%{$request->search['value']}%");
                })
                ->paginate($request->length);

            if ($request->page && $request->page > 1) {
                $no = (((int) $request->page - 1) * $request->length) + 1;
            } else {
                $no = 1;
            }

            $data = $clients->map(function ($row, $index) use ($no) {
                $data_array = [
                    'no' => $index + $no,
                    'id' => $row->id,
                    'date' => formatted_date($row->created_at),
                    'description' => $row->description,
                    'cash_memo_no' => $row->cash_memo_no,
                    'client_no' => $row->client?->client_no,
                    'name' => $row->client?->name,
                    'mobile_number' => $row->client?->mobile_number,
                    'bill_amount' => bd_money_format($row->bill_amount),
                    'payment_amount' => bd_money_format($row->payment_amount),
                    'advance' => bd_money_format($row->advance),
                ];
                return $data_array;
            });
            return dataTableResponse($clients->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}
