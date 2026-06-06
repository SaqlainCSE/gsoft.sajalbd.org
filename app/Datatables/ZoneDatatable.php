<?php

namespace App\Datatables;

use App\Models\SaleType;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneDatatable
{
    public function handel(Request $request)
    {
        try {
            $zones = Zone::query()
                ->with('district:id,name')
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('name', 'like', "%{$request->search['value']}%");
                })
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
                    'status' => $row->status ? 'Active' : 'Inactive',
                    'district' => $row->district->name,
                    'note'  => $row->note,
                ];
                return $data_array;
            });
            return dataTableResponse($zones->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}
