<?php

namespace App\Datatables;

use App\Models\Client;
use Illuminate\Http\Request;

use function Deployer\option;

class ClientDueDatatable
{
    public function handel(Request $request)
    {
        try {
            $clients = Client::query()
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('name', 'like', "%{$request->search['value']}%")
                    ->orWhere('mobile_number', 'like', "%{$request->search['value']}%")
                    ->orWhere('client_no', 'like', "%{$request->search['value']}%");
                })
                ->where('due_amount', '>', 0)
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
                    'due_amount' => bd_money_format($row->due_amount),
                ];
                return $data_array;
            });
            return dataTableResponse($clients->total(), $data);
        } catch (\Throwable $th) {
            dd($th);
            return dataTableResponse(0);
        }
    }
}
