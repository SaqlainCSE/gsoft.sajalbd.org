<?php

namespace App\Datatables;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDatatable
{
    public function handel(Request $request)
    {
        try {
            $products = Product::query()
                ->with('category', 'supplier')
                ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                    return $query->where('product_nr', 'like', "%{$request->search['value']}%")
                        ->orWhere('weight', 'like', "%{$request->search['value']}%")
                        ->orWhereRaw(
                            "DATE_FORMAT(purchase_date, '%d-%m-%Y') LIKE ?",
                            ["%{$request->search['value']}%"]
                        );
                })

                ->paginate($request->length);

            if ($request->page && $request->page > 1) {
                $no = (((int) $request->page - 1) * $request->length) + 1;
            } else {
                $no = 1;
            }

            $data = $products->map(function ($row, $index) use ($no) {
                $data_array = [
                    'no' => $index + $no,
                    'id' => $row->id,
                    'category' => $row->category?->name,
                    'product_nr' => $row->product_nr,
                    'product_details' => $row->product_details,
                    'weight' => "{$row->weight}",
                    'price' => bd_money_format($row->price),
                    'st_dia' => "{$row->st_dia}",
                    'st_dia_price' => bd_money_format($row->st_dia_price),
                    'status' => $row->status,
                    'supplier' => $row->supplier?->name,
                    'purchase_price' => $row->purchase_price,
                    'qty' => $row->qty,
                    'stock_type' => $row->stock_type,
                    'purchase_date' => formatted_date($row->purchase_date),
                    'wage' => $row->wage ? ($row->wage . ($row->wage_type === 'Percentage' ? '(%)' : 'BDT')) : '--',
                    'created_at' => formatted_date_time($row->created_at)
                ];
                return $data_array;
            });
            return dataTableResponse($products->total(), $data);
        } catch (\Throwable $th) {
            throw $th;
            return dataTableResponse(0);
        }
    }
}
