<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class CheckClientMobileNumberController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'string'],
        ]);

        $client = Client::query()
            ->where('mobile_number', $request->mobile)
            ->count();
        if($client){
            return response()->noContent(422);
        }
        return response()->noContent();
    }
}
