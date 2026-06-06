<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerImportRequest;
use App\Models\Client;

class CustomerImportController extends Controller
{
    public function create()
    {
        return view('customerImport.create');
    }

    public function store(CustomerImportRequest $request)
    {
        try {
            // DB::beginTransaction();
            foreach($request->customers as $customer){
                Client::create($customer);
            }
            // DB::commit();
            return response()->json([
                'message' => 'Customer Imported'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
