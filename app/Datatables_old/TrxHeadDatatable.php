<?php
namespace App\Datatables;

use App\Models\TrxHead;
use Illuminate\Http\Request;

class TrxHeadDatatable
{
    public function handel(Request $request)
    {
        try {
            $zones = TrxHead::query()
                ->with('parent')
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
                    'code'  => $row->parent?->name,
                    'description'  => $row->description,
                ];
                return $data_array;
            });
            return dataTableResponse($zones->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}