<?php

namespace App\Datatables;

use App\Models\Role;
use App\Scopes\BranchScope;
use Illuminate\Http\Request;

class RoleDatatable
{

    public function handel(Request $request)
    {
        try {
            $roles = Role::query()
                ->withoutGlobalScope(BranchScope::class)
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('name', 'like', "%{$request->search['value']}%");
                })
                ->when(!\Auth::user()->hasRole('Super Admin'), function ($q) {
                    return $q->where('branch_id', auth()->user()->branch_id)
                        ->orWhereNull('branch_id');
                })
                ->where('name', '!=', 'Super Admin')
                ->paginate($request->length);

            $data = $roles->map(function ($row, $index) {
                $data_array = [
                    'no' => $index + 1,
                    'id' => $row->uuid,
                    'name' => auth()->user()->branch_id ? ltrim($row->name, auth()->user()->branch_id . "_") : $row->name,
                    'guard_name' => $row->guard_name,
                    'is_active' => $row->is_active,
                    'is_delete_able' => $row->is_delete_able,
                ];
                if (\Auth::user()->hasRole('Super Admin')) {
                    $data_array['branch_id'] = optional($row->branch)->name;
                }
                return $data_array;
            });
            return dataTableResponse($roles->total(), $data);
        } catch (\Throwable $th) {
            throw ($th);
            return dataTableResponse(0);
        }
    }
}
