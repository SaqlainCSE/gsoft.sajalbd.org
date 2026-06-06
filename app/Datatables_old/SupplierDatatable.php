<?php

namespace App\Datatables;

use App\Models\Client;
use App\Models\Supplier;
use Illuminate\Http\Request;


class SupplierDatatable
{
    public function handel(Request $request)
    {
        try {
            $suppliers = Supplier::query()
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('name', 'like', "%{$request->search['value']}%")
                    ->orWhere('mobile_number', 'like', "%{$request->search['value']}%");
                })
                // ->when($request->due_only, fn($q) => $q->where('due_amount', '>', 0))
                ->paginate($request->length);

            if ($request->page && $request->page > 1) {
                $no = (((int) $request->page - 1) * $request->length) + 1;
            } else {
                $no = 1;
            }

            $data = $suppliers->map(function ($row, $index) use ($no) {
                $data_array = [
                    'no' => $index + $no,
                    'id' => $row->id,
                    'name' => $row->name,
                    'mobile_number' => $row->mobile_number,
                    'due_amount' => bd_money_format($row->due_amount)
                ];
                return $data_array;
            });
            return dataTableResponse($suppliers->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}
