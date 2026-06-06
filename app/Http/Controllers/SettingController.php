<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsUpdateRequest;
use Illuminate\Support\Facades\Cache;

/**
 * Class SettingController
 * @package App\Http\Controllers
 */
class SettingController extends Controller
{
    public function index()
    {
        $this->authorize('Access Settings');

        return view('setting.edit');
    }

    public function store(SettingsUpdateRequest $request)
    {
        foreach ($request->safe()->all() as $key => $value) {
            setting(["{$key}" => $value]);
        }

        Cache::forget("settings_" . auth()->user()->branch_id);

        return redirect()->route('settings.index');
    }
}
