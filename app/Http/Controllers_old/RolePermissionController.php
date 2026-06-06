<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $uuid)
    {
        $request->validate([
            'permission' => ['nullable', 'array'],
            'permission.*' => ['required', 'array'],
            'permission.*.*' => ['required', 'integer']
        ]);

        $role = Role::query()
            ->whereNotIn('name', ['Super Admin', 'Admin'])
            ->whereUuid($uuid)
            ->firstOrFail();

        $moduleId = [];
        $permissionId = [];

        $moduleNotPermit = Module::query()
            ->whereIn('name', ['Roles'])
            ->pluck('id')
            ->toArray();
        if ($request->permission){
            foreach ($request->permission as $module => $permissions) {
                if (!in_array($module, $moduleNotPermit)) {
                    $moduleId[] = $module;
                    foreach ($permissions as $key => $permission) {
                        $permissionId[] = $permission;
                    }
                }
            }
        }

        $permissionName = Permission::query()
            ->whereIn('module_id', $moduleId)
            ->whereIn('id', $permissionId)
            ->pluck('name');

        $role->syncPermissions($permissionName);
        notify()->success(__('Permission sync successfully.'));
        return redirect()->back();
    }
}
