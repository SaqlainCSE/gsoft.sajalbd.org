<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }
    public function update_info(Request $request) {
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['nullable', 'string'],
        ];
        $valid_data = $request->validate($rules);

        $user = Auth::user();
        
        $user->fill($valid_data)->save();
        
        notify()->success('Profile Info Updated');
        
        return redirect()->back();
    }
    public function update_password(Request $request)
    {
        $rules = [
            'username' => ['required', 'string'],
            'old_password' => ['required', 'string'],
        ];
        if ($request->password) {
            $rules['password'] = ['required', 'confirmed'];
        }
        $request->validate($rules);
        
        $user = Auth::user();
        
        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ])->save();
            notify()->success('Password changed');
            return redirect()->back();
        } else {
            notify()->error('Password does not match');
            return redirect()->back();
        }
    }
}
