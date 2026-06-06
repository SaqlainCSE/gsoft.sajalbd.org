<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleEntryStoreRequest;
use App\Models\Stock;
use App\Models\StockHasPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function salesEntryIndex()
    {
        $this->authorize('Access Sales Entry');

        $stockBf = Stock::query()
            ->select(
                DB::raw("SUM(CASE WHEN trx_type = 'in' THEN unit_18k ELSE -unit_18k END) as unit_18k"),
                DB::raw("SUM(CASE WHEN trx_type = 'in' THEN unit_21k ELSE -unit_21k END) as unit_21k"),
                DB::raw("SUM(CASE WHEN trx_type = 'in' THEN unit_22k ELSE -unit_22k END) as unit_22k"),
                DB::raw("SUM(CASE WHEN trx_type = 'in' THEN st ELSE -st END) as st"),
                DB::raw("SUM(CASE WHEN trx_type = 'in' THEN d18k ELSE -d18k END) as d18k"),
                DB::raw("SUM(CASE WHEN trx_type = 'in' THEN dia ELSE -dia END) as dia"),
            )
            ->whereDate('date', '<', Carbon::today())
            ->get();

        $stockSale = Stock::query()
            ->select(
                DB::raw('SUM(unit_18k) as unit_18k'),
                DB::raw('SUM(unit_21k) as unit_21k'),
                DB::raw('SUM(unit_22k) as unit_22k'),
                DB::raw('SUM(st) as st'),
                DB::raw('SUM(d18k) as d18k'),
                DB::raw('SUM(dia) as dia'),
            )
            ->whereDate('date', Carbon::today())
            ->where('type', Stock::TYPE_SALE)
            ->get();

        $newStock = Stock::query()
            ->select(
                DB::raw('SUM(unit_18k) as unit_18k'),
                DB::raw('SUM(unit_21k) as unit_21k'),
                DB::raw('SUM(unit_22k) as unit_22k'),
                DB::raw('SUM(st) as st'),
                DB::raw('SUM(d18k) as d18k'),
                DB::raw('SUM(dia) as dia'),
            )
            ->whereDate('date', Carbon::today())
            ->where('type', [Stock::TYPE_NEW])
            ->get();

        $exchangeStock = Stock::query()
            ->select(
                DB::raw('SUM(unit_18k) as unit_18k'),
                DB::raw('SUM(unit_21k) as unit_21k'),
                DB::raw('SUM(unit_22k) as unit_22k'),
                DB::raw('SUM(st) as st'),
                DB::raw('SUM(d18k) as d18k'),
                DB::raw('SUM(dia) as dia'),
            )
            ->whereDate('date', Carbon::today())
            ->where('type', [Stock::TYPE_EXCHANGE])
            ->get();

        $oldGold = Stock::query()
            ->select(
                DB::raw('SUM(unit_18k) as unit_18k'),
                DB::raw('SUM(unit_21k) as unit_21k'),
                DB::raw('SUM(unit_22k) as unit_22k'),
                DB::raw('SUM(st) as st'),
                DB::raw('SUM(d18k) as d18k'),
                DB::raw('SUM(dia) as dia'),
            )
            ->whereDate('date', Carbon::today())
            ->where('type', [Stock::TYPE_OLD])
            ->get();
        
        $returnGold = Stock::query()
            ->select(
                DB::raw('SUM(unit_18k) as unit_18k'),
                DB::raw('SUM(unit_21k) as unit_21k'),
                DB::raw('SUM(unit_22k) as unit_22k'),
                DB::raw('SUM(st) as st'),
                DB::raw('SUM(d18k) as d18k'),
                DB::raw('SUM(dia) as dia'),
            )
            ->whereDate('date', Carbon::today())
            ->where('type', [Stock::TYPE_RETURN])
            ->get();


        return view('stock.saleEntry', compact('stockBf', 'newStock', 'stockSale', 'exchangeStock', 'oldGold', 'returnGold'));
    }

    public function salesEntry(SaleEntryStoreRequest $request){
        try {
            DB::beginTransaction();
            foreach ($request->product_nr as $key => $product_nr) {
                $stockEntry=[
                    "trx_type" => $request->trx_type,
                    "type" => $request->type,
                    "date" => $request->date,
                    "memo" => $request->memo,
                    "client_id" => $request->client,
                    "token" => $product_nr,
                    "unit_18k" => $request->unit_18k[$key],
                    "unit_21k" => $request->unit_21k[$key],
                    "unit_22k" => $request->unit_22k[$key],
                    "st" => $request->st[$key],
                    "d18k" => $request->d18k[$key],
                    "dia" => $request->dia[$key],
                ];
                Stock::create($stockEntry);
            }  
            StockHasPayment::create($request->safe()->all());
            DB::commit();
            notify()->success(__('Sale added successfully.'));
            return redirect()->route('stocks.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            notify()->error($th->getMessage());
            return back();
        }
        
    }
}
