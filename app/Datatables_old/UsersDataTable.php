<?php

namespace App\Datatables;

use App\Models\User;
use Illuminate\Http\Request;

class UsersDataTable
{
    public function handel(Request $request)
    {
        try {
            $users = User::query()
                ->with('roles')
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('username', 'like', "%{$request->search['value']}%");
                })
                ->paginate($request->length);

            if ($request->page && $request->page > 1) {
                $no = (((int) $request->page - 1) * $request->length) + 1;
            } else {
                $no = 1;
            }
            // return $users;
            $data = $users->map(function ($row, $index) use ($no) {
                $data_array = [
                    'no' => $index + $no,
                    'id' => $row->id,
                    'name' => $row->name,
                    'username' => $row->username,
                    'status' => $row->is_active,
                    'role'  => optional($row->getRoleNames())[0],
                    'created_at' => formatted_date($row->created_at),
                ];
                return $data_array;
            });
            return dataTableResponse($users->total(), $data);
        } catch (\Throwable $th) {
            return dataTableResponse(0);
        }
    }
}
