<?php
namespace App\Datatables;

use App\Models\TransactionCode;
use App\Models\TrxHead;
use Illuminate\Http\Request;

class TransactionCodeDatatable
{
    public function handel(Request $request)
    {
        try {
            $zones = TransactionCode::query()
                ->paginate($request->length);

            if ($request->page && $request->page > 1) {
                $no = (((int) $request->page - 1) * $request->length) + 1;
            } else {
                $no = 1;
            }

            $data = $zones->map(function ($row, $index) use ($no) {
                $data_array = [
                    'no' => $index + $no,
                    'id' => $row->id,
                    'name' => $row->name,
                    'is_active' => $row->is_active ? 'Active' : 'Inactive',
                    'type' => $row->type,
                ];
                return $data_array;
            });
            return dataTableResponse($zones->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}