<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductInportRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductImportController extends Controller
{
    public function create()
    {
        return view('productImport.create');
    }
    public function store(ProductInportRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = [];
            $i = 0;
            foreach ($request->products as $product) {
                // Product::create($product);
                
                $data[] = [
                    'product_nr' => $product['product_nr'],
                    'product_details' => $product['product_details'],
                    'weight' => $product['weight'],
                    'st_dia' => $product['st_dia'],
                    'st_dia_price' => $product['st_dia_price'],
                    'wage' => $product['wage'],
                    'wage_type' => $product['wage_type'],
                    'carat' => $product['carat'],
                    'product_category_id' => $product['product_category_id'],
                    'purchase_price' => $product['purchase_price'] ?: null,
                    'status' => $product['status'],
                    'supplier_id' => $product['supplier_id'],
                    'stock_type' => $product['stock_type'],
                    'type' => $product['type'],
                ];
                $i++;

                // dd($data);

                if($i%50){
                    Product::upsert($data, ['product_nr']);
                    $data = [];
                }
            }
            if(sizeof($data) >0 ){
                Product::upsert($data, ['product_nr']);
            }
            DB::commit();
            return response()->json([
                'message' => 'Product Imported'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
