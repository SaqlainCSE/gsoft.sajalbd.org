<?php

namespace App\Datatables;

use App\Models\Client;
use Illuminate\Http\Request;

use function Deployer\option;

class ClientDatatable
{
    public function handel(Request $request)
    {
        try {
            $clients = Client::query()
                ->with('media')
                ->with('category:id,name', 'district:id,name', 'zone:id,name')
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('name', 'like', "%{$request->search['value']}%")
                    ->orWhere('mobile_number', 'like', "%{$request->search['value']}%");
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
                    'client_no' => $row->client_no,
                    'name' => $row->name,
                    'mobile_number' => $row->mobile_number,
                    'address' => $row->address,
                    'created_at' => formatted_date($row->created_at),
                    'category' => optional($row->category)->name,
                    'district' => optional($row->district)->name,
                    'zone' => optional($row->zone)->name,
                    'photo' => optional($row)->getFirstMediaUrl('photo'),
                    'fb_name' => $row->fb_name
                ];
                return $data_array;
            });
            return dataTableResponse($clients->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}
