<?php

namespace App\Http\Controllers;

use App\Datatables\UsersDataTable;
use App\Http\Requests\DatatableRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('Access Users');
        if ($request->has('draw')) {
            return (new UsersDataTable)->handel(app(DatatableRequest::class));
        };
        return view('users.index');
    }

    public function create()
    {
        $roles = Role::query()
            ->pluck('name', 'name');
        $user = new User();
        return view('users.create', compact('roles','user'));
    }

    public function store(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create($request->safe()->all());
            $user->assignRole($request->role);
            notify()->success(__('User Added successful'));
            DB::commit();
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            notify()->error(__('Somethings Went wrong'));
            return redirect()->route('users.index');
        }
    }

    public function edit(User $user)
    {
        $roles = Role::query()
            ->pluck('name', 'name');
        return view('users.edit', compact('roles','user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $user->update($request->safe()->all());

            if($request->set_new_password){
                $user->update([
                    'password' => bcrypt('123456')
                ]);
            }
            $user->syncRoles($request->role);
            notify()->success(__('User Updated successfully'));
            DB::commit();
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            notify()->error(__('Somethings Went wrong'));
            return redirect()->route('users.index');
        }
    }

    public function destroy(User $user)
    {
        $this->authorize('Delete User');
        if($user->hasRole('Super Admin')){
            return response()->json([
                'message' => "Can't delete Super Admin"
            ], 419);
        } else {
            $user = $user->delete();
            return response()->json(['success' => __('User deleted successfully')]);
        }
    }
}
