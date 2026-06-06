<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoldBuySale;

class GoldBuySaleController extends Controller
{
    public function goldBuySale(Request $request)
    {
        $query = GoldBuySale::query();

        if ($request->has('purchase_memo') && !empty($request->purchase_memo)) {
            $query->where('purchase_memo', 'like', '%' . $request->purchase_memo . '%');
        }

        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->where('date', '<=', $request->date_to);
        }

        $goldBuySales = $query->latest()->paginate(30);
        return view('gold_buy_sale.index', compact('goldBuySales'));
    }

    public function createGoldBuySale()
    {
        return view('gold_buy_sale.create');
    }

    public function storeGoldBuySale(Request $request)
    {

        // Validate the request data
        $validatedData = $request->validate([
            'date' => 'nullable|date',
            'purchase_memo' => 'required|string|max:255',
            'cash_memo' => 'nullable|string|max:255',

            'exchange_gold_amount' => 'nullable|numeric',
            'exchange_gold_carat' => 'nullable|string|max:50',
            'exchange_gold_weight' => 'nullable|numeric',

            'customer_gold_amount' => 'nullable|numeric',
            'customer_gold_carat' => 'nullable|string|max:50',
            'customer_gold_weight' => 'nullable|numeric',

            'senco_amount' => 'nullable|numeric',
            'senco_carat' => 'nullable|string|max:50',
            'senco_weight' => 'nullable|numeric',

            'sales_return_amount' => 'nullable|numeric',
            'sales_return_carat' => 'nullable|string|max:50',
            'sales_return_weight' => 'nullable|numeric',

            'total_amount' => 'nullable|numeric',
            'remarks' => 'nullable|string',
        ]);

        // Store the validated data in the database
        GoldBuySale::create($validatedData);

        return redirect()->route('gold-buy-sale')->with('success', 'Gold buy sale data saved successfully.');
    }

    public function editGoldBuySale($id)
    {
        $goldBuySale = GoldBuySale::findOrFail($id);
        return view('gold_buy_sale.edit', compact('goldBuySale'));
    }

    public function updateGoldBuySale(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'date' => 'nullable|date',
            'purchase_memo' => 'required|string|max:255',
            'cash_memo' => 'nullable|string|max:255',

            'exchange_gold_amount' => 'nullable|numeric',
            'exchange_gold_carat' => 'nullable|string|max:50',
            'exchange_gold_weight' => 'nullable|numeric',

            'customer_gold_amount' => 'nullable|numeric',
            'customer_gold_carat' => 'nullable|string|max:50',
            'customer_gold_weight' => 'nullable|numeric',

            'senco_amount' => 'nullable|numeric',
            'senco_carat' => 'nullable|string|max:50',
            'senco_weight' => 'nullable|numeric',

            'sales_return_amount' => 'nullable|numeric',
            'sales_return_carat' => 'nullable|string|max:50',
            'sales_return_weight' => 'nullable|numeric',

            'total_amount' => 'nullable|numeric',
            'remarks' => 'nullable|string',
        ]);

        // Update the record in the database
        $goldBuySale = GoldBuySale::findOrFail($id);
        $goldBuySale->update($validatedData);

        return redirect()->route('gold-buy-sale')->with('success', 'Gold buy sale data updated successfully.');
    }

    public function deleteGoldBuySale($id)
    {
        $goldBuySale = GoldBuySale::findOrFail($id);
        $goldBuySale->delete();

        return redirect()->route('gold-buy-sale')->with('success', 'Gold buy sale data deleted successfully.');
    }
}
