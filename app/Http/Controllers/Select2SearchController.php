<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Zone;
use Illuminate\Http\Request;

class Select2SearchController extends Controller
{
    public function client(Request $request)
    {
        // $request->dd();
        $clients = Client::query()
            ->where('name', 'like', "{$request->term}%")
            ->orWhere('mobile_number', 'like', "{$request->term}%")
            ->limit(100)
            ->get();

        $results = [];

        foreach ($clients as $client) {
            $results[] = [
                'id' => $client->id,
                'text' => "{$client->name} ($client->mobile_number)"
            ];
        }
        return response()->json([
            'results' => $results
        ]);
    }

    public function supplier(Request $request)
    {
        // $request->dd();
        $suppliers = Supplier::query()
            ->where('name', 'like', "{$request->term}%")
            ->orWhere('mobile_number', 'like', "{$request->term}%")
            ->limit(100)
            ->get();

        $results = [];

        foreach ($suppliers as $supplier) {
            $results[] = [
                'id' => $supplier->id,
                'text' => "{$supplier->name} ($supplier->mobile_number)"
            ];
        }
        return response()->json([
            'results' => $results
        ]);
    }
    public function product(Request $request)
    {
        $request->validate([
            'term' => ['nullable', 'string'],
            'booking_id' => ['nullable', 'string'],
            'selectedProduct' => ['nullable', 'array'],
        ]);
        $products = Product::query()
            ->where('product_nr', 'like', "{$request->term}%")
            ->when(!$request->booking_id, fn($q)=> $q->where('status', 'Fresh'))
            ->when($request->booking_id, fn($q)=> $q->where('booking_number', $request->booking_id))
            ->where('status', '!=' ,'Sold')
            ->when($request->selectedProduct, fn($q)=>$q->whereNotIn('id', $request->selectedProduct))
            ->limit(20)
            ->get();

        if($request->has('labelValue')){
            $results = [];

            foreach ($products as $product) {
                $results[] = [
                    'value' => $product->id,
                    'label' => "{$product->product_nr} ($product->weight)"
                ];
            }
        } else {
        $results = [
            ['id' => '', 'text' => 'Select Product']
        ];

        foreach ($products as $product) {
            $results[] = [
                'id' => $product->id,
                'text' => "{$product->product_nr} ($product->weight)"
            ];
        }
    }
        return response()->json([
            'results' => $results
        ]);
    }
    public function zone(Request $request)
    {
        $zones = Zone::query()
            ->where('district_id', $request->district_id)
            ->when($request->term, fn($q)=>$q->where('name', 'like', "{$request->term}%"))
            ->limit(20)
            ->get();

        $results = [
            ['id' => '', 'text' => 'Select Zone']
        ];

        foreach ($zones as $zone) {
            $results[] = [
                'id' => $zone->id,
                'text' => $zone->name
            ];
        }
        return response()->json([
            'results' => $results
        ]);
    }
}
