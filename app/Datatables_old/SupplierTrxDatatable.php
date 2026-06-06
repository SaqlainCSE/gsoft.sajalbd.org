<?php

namespace App\Datatables;

use App\Models\Client;
use App\Models\SupplierTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;

use function Deployer\option;

class SupplierTrxDatatable
{
    public function handel(Request $request)
    {
        try {
            $clients = SupplierTransaction::query()
                ->with('supplier')
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('reference_no', 'like', "%{$request->search['value']}%");
                })
                ->when($request->has("supplier_id"), fn($q)=>$q->where('supplier_id', $request->supplier_id))
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
                    'reference_no' => $row->reference_no,
                    'name' => $row->supplier->name,
                    'mobile_number' => $row->supplier->mobile_number,
                    'bill_amount' => bd_money_format($row->bill_amount),
                    'payment_amount' => bd_money_format($row->payment_amount),
                    'advanced' => bd_money_format($row->advanced),
                ];
                return $data_array;
            });
            return dataTableResponse($clients->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}
