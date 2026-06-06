<?php

namespace App\Datatables;

use App\Models\CustomerCategory;
use App\Models\SaleType;
use App\Models\Zone;
use Illuminate\Http\Request;

class CustomerCategoryDatatable
{
    public function handel(Request $request)
    {
        try {
            $customerCategories = CustomerCategory::query()
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('name', 'like', "%{$request->search['value']}%");
                })
                ->paginate($request->length);

            if ($request->page && $request->page > 1) {
                $no = (((int) $request->page - 1) * $request->length) + 1;
            } else {
                $no = 1;
            }

            $data = $customerCategories->map(function ($row, $index) use ($no) {
                $data_array = [
                    'no' => $index + $no,
                    'id' => $row->id,
                    'name' => $row->name,
                    'status' => $row->status ? 'Active' : 'Inactive',
                ];
                return $data_array;
            });
            return dataTableResponse($customerCategories->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}
