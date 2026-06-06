<?php

namespace App\Http\Controllers;

use App\Datatables\RoleDatatable;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Module;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Access Roles');

        if ($request->has('draw')) {
            return (new RoleDatatable)->handel(app(DatatableRequest::class));
        };

        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Create Role');
        $role = new Role();
        return view('role.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $role = Role::create($request->safe()->all());
        notify()->success(__('Role created successfully.'));
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize('Show Role');

        $modules = Module::query()
            ->with('permissions:id,name,guard_name,module_id')
            ->active()
            ->whereHas('permissions')
            ->whereNotIn('name', ['Roles'])
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();
        return view('role.show', compact('role', 'modules'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role->update($request->safe()->all());
        notify()->success(__('Role updated successfully'));
        return redirect()->route('roles.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $this->authorize('Delete Role');

        $role->delete();
        notify()->success(__('Role deleted successfully'));
        return redirect()->route('roles.index');
    }
}
