<?php

namespace App\Datatables;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodDatatable
{
    public function handel(Request $request)
    {
        try {
            $payment_methods = PaymentMethod::query()
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('name', 'like', "%{$request->search['value']}%");
                })
                ->paginate($request->length);

            if ($request->page && $request->page > 1) {
                $no = (((int) $request->page - 1) * $request->length) + 1;
            } else {
                $no = 1;
            }

            $data = $payment_methods->map(function ($row, $index) use ($no) {
                $data_array = [
                    'no' => $index + $no,
                    'id' => $row->id,
                    'name' => $row->name,
                    'status' => $row->status ? 'Active' : 'Inactive',
                    'under_type' => $row->under_type,
                ];
                return $data_array;
            });
            return dataTableResponse($payment_methods->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}
