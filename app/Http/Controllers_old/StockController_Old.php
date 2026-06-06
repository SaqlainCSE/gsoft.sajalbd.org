<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

/**
 * Class StockController
 * @package App\Http\Controllers
 */
class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function filter(Request $request)
    {
        $this->authorize('Access Stock');

        $start = $request->start_date ? $request->start_date . ' 00:00:00' : null;
        $end   = $request->end_date ? $request->end_date . ' 23:59:59' : null;

        $calculateStock = function($type, $carat = null) use ($start, $end) {

            /* ==============================
            COLUMN MAP
            ============================== */
            $column = match(true) {
                $type=='gold' && in_array($carat,['18','21','22']) => 'weight',
                $type=='gold' && is_null($carat) => 'st_dia',
                $type=='diamond' && $carat=='18' => 'weight',
                $type=='diamond' && is_null($carat) => 'st_dia',
                default => 'weight'
            };

            $stockColumn = match(true) {
                $type=='gold' && $carat=='18'   => 'unit_18k',
                $type=='gold' && $carat=='21'   => 'unit_21k',
                $type=='gold' && $carat=='22'   => 'unit_22k',
                $type=='gold' && is_null($carat) => 'st',
                $type=='diamond' && $carat=='18' => 'd18k',
                $type=='diamond' && is_null($carat) => 'dia',
                default => 'weight'
            };

            /* ==============================
            1️⃣ BALANCE B/F
            ============================== */
            $productTotal = Product::query()
                ->when($carat, fn($q)=>$q->where('carat', $carat))
                ->where('type', $type)
                ->when($start, fn($q)=>$q->where('created_at','<',$start))
                ->selectRaw("ROUND(SUM($column),2) as total")
                ->value('total') ?? 0;

            $stockOutTotal = Stock::query()
                ->where('trx_type','out')
                ->when($start, fn($q)=>$q->where('created_at','<',$start))
                ->selectRaw("ROUND(SUM($stockColumn),2) as total")
                ->value('total') ?? 0;

            $bf = round($productTotal - $stockOutTotal, 2);

            /* ==============================
            2️⃣ SALE (DATE RANGE)
            ============================== */
            $saleToday = Stock::query()
                ->where('trx_type','out')
                ->when($start && $end, fn($q)=>$q->whereBetween('created_at', [$start, $end]))
                ->selectRaw("ROUND(SUM($stockColumn),2) as total")
                ->value('total') ?? 0;

            $balanceAfterSale = round($bf - $saleToday, 2);

            /* ==============================
            3️⃣ ADDITIONS
            ============================== */
            // $additionsList = Stock::query()
            //     ->selectRaw("products.stock_type, ROUND(SUM($stockColumn),2) as total")
            //     ->join('products','products.product_nr','=','stocks.token')
            //     ->where('stocks.trx_type','in')
            //     ->when($start && $end, fn($q)=>$q->whereBetween('stocks.created_at', [$start, $end]))
            //     ->when($carat, fn($q)=>$q->where('products.carat',$carat))
            //     ->where('products.type',$type)
            //     ->groupBy('products.stock_type')
            //     ->get()
            //     ->mapWithKeys(fn($row)=>[
            //         strtoupper(trim($row->stock_type)) => (float)$row->total
            //     ])
            //     ->toArray();

            $additionsList = Product::query()
                ->when($start && $end, fn($q) => $q->whereBetween('created_at', [$start, $end]))
                ->when($carat, fn($q) => $q->where('carat', $carat))
                ->where('type', $type)
                ->groupBy('stock_type')
                ->selectRaw("stock_type, ROUND(SUM($column), 2) as total")
                ->get()
                ->mapWithKeys(fn($row) => [
                    strtoupper(trim($row->stock_type)) => (float)$row->total
                ])
                ->toArray();

            /* ==============================
            4️⃣ CLOSING
            ============================== */
            $closing = round($balanceAfterSale + array_sum($additionsList), 2);

            return [
                'bf'         => $bf,
                'sale_today' => $saleToday,
                'balance'    => $balanceAfterSale,
                'additions'  => $additionsList,
                'closing'    => $closing,
            ];
        };

        /* ==============================
        FINAL BALANCES
        ============================== */
        $balances = [
            'gold' => [
                '18' => $calculateStock('gold','18'),
                '21' => $calculateStock('gold','21'),
                '22' => $calculateStock('gold','22'),
                'ST' => $calculateStock('gold', null),
            ],
            'diamond' => [
                'D18k' => $calculateStock('diamond','18'),
                'DIA'  => $calculateStock('diamond', null),
            ],
        ];

        return view('stock.index', compact('balances','start','end'));
    }


    public function index(Request $request)
    {
        $this->authorize('Access Stock');

        $today = now()->format('Y-m-d');

        // Helper function to calculate stock for each type/carat
        $calculateStock = function($type, $carat = null) use ($today) {

            $column = match(true) {
                $type=='gold' && in_array($carat,['18','21','22']) => 'weight',
                $type=='gold' && is_null($carat) => 'st_dia',
                $type=='diamond' && $carat=='18' => 'weight',
                $type=='diamond' && is_null($carat) => 'st_dia',
                default => 'weight'
            };

            $stockColumn = match(true) {
                $type=='gold' && $carat=='18'   => 'unit_18k',
                $type=='gold' && $carat=='21'   => 'unit_21k',
                $type=='gold' && $carat=='22'   => 'unit_22k',
                $type=='gold' && is_null($carat) => 'st',
                $type=='diamond' && $carat=='18' => 'd18k',
                $type=='diamond' && is_null($carat) => 'dia',
                default => 'weight'
            };

            $productTotal = Product::query()
                ->when($carat, fn($q)=>$q->where('carat', $carat))
                ->where('type', $type)
                ->selectRaw("ROUND(SUM($column), 2) as total")
                ->value('total') ?? 0;

            $stockOutTotal = Stock::query()
                ->where('trx_type','out')
                ->whereDate('created_at', '<', $today)
                ->selectRaw("ROUND(SUM($stockColumn), 2) as total")
                ->value('total') ?? 0;

            $bf = round($productTotal - $stockOutTotal, 2);

            $saleToday = Stock::query()
                ->where('trx_type','out')
                ->whereDate('created_at', $today)
                ->selectRaw("ROUND(SUM($stockColumn), 2) as total")
                ->value('total') ?? 0;

            $balanceAfterSale = round($bf - $saleToday, 2);

            // ADDITIONS ARRAY (per type: NEW STOCK, EXCHANGE, OLD GOLD, S. RETURN)
            // $additionsList = Stock::query()
            //     ->selectRaw("products.stock_type, SUM($stockColumn) as total")
            //     ->join('products', 'products.product_nr', '=', 'stocks.token')
            //     ->where('stocks.trx_type', 'in')
            //     ->whereDate('stocks.created_at', $today)
            //     ->when($carat, fn($q) => $q->where('products.carat', $carat))
            //     ->where('products.type', $type)
            //     ->groupBy('products.stock_type')
            //     ->get()
            //     ->mapWithKeys(function($row) {
            //         return [ strtoupper(trim($row->stock_type)) => $row->total ];
            //     })
            //     ->toArray();

            // ADDITIONS ARRAY (per type: NEW STOCK, EXCHANGE, OLD GOLD, S. RETURN)
            $additionsList = Product::query()
                ->when($carat, fn($q) => $q->where('carat', $carat))
                ->where('type', $type)
                ->whereDate('created_at', $today)
                ->groupBy('stock_type')
                ->selectRaw("stock_type, SUM($column) as total")
                ->get()
                ->mapWithKeys(fn($row) => [ strtoupper(trim($row->stock_type)) => $row->total ])
                ->toArray();

            return [
                'bf'        => $bf,
                'sale_today'=> $saleToday,
                'balance'   => $balanceAfterSale,
                'additions' => $additionsList, // <-- IMPORTANT
                'closing' => round($balanceAfterSale + array_sum($additionsList), 2),
            ];
        };

        // Calculate for each stock type
        $balances = [
            'gold' => [
                '18' => $calculateStock('gold', '18'),
                '21' => $calculateStock('gold', '21'),
                '22' => $calculateStock('gold', '22'),
                'ST' => $calculateStock('gold', null),
            ],
            'diamond' => [
                'D18k' => $calculateStock('diamond', '18'),
                'DIA' => $calculateStock('diamond', null),
            ],
        ];

        return view('stock.index', compact('balances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('Create Stock');
        $this->authorize('Add Stock') || $this->authorize('Add Sale');
        $stock = new Stock();
        return view('stock.create', compact('stock'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->dd();
        $this->authorize('Create Stock');
        request()->validate(Stock::$rules);

        $stock = Stock::create($request->all());
        notify()->success(__('Stock created successfully.'));
        return redirect()->route('stocks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Show Stock');
        $stock = Stock::find($id);

        return view('stock.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Edit Stock');
        $stock = Stock::find($id);

        return view('stock.edit', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Stock $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        $this->authorize('Edit Stock');

        request()->validate(Stock::$rules);

        $stock->update($request->all());
        notify()->success(__('Stock updated successfully'));
        return redirect()->route('stocks.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete Stock');

        $stock = Stock::find($id)->delete();
        notify()->success(__('Stock deleted successfully'));
        return redirect()->route('stocks.index');
    }
}
