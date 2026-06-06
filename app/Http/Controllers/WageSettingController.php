<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WageSettingController extends Controller
{
    public function create(Request $request)
    {
        return view('wage.setting');
    }
}
