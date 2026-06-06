<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderMeta;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use PDF;
use Mpdf\Mpdf;

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
                                ->join('products', 'products.product_nr', '=', 'stocks.token')
                                ->where('stocks.trx_type', 'out')
                                ->where('products.type', $type)
                                ->when($carat, fn($q) => $q->where('products.carat', $carat))
                                ->when($start, fn($q) => $q->where('stocks.created_at', '<', $start))
                                ->selectRaw("ROUND(SUM(stocks.$stockColumn), 2) as total")
                                ->value('total') ?? 0;

            $bf = round($productTotal - $stockOutTotal, 2);

            /* ==============================
            2️⃣ SALE (DATE RANGE)
            ============================== */
            
            $saleToday = Stock::query()
                        ->join('products', 'products.product_nr', '=', 'stocks.token')
                        ->where('stocks.trx_type', 'out')
                        ->where('products.type', $type)
                        ->when($carat, fn($q) => $q->where('products.carat', $carat))
                        ->when($start && $end, fn($q) => $q->whereBetween('stocks.created_at', [$start, $end]))
                        ->selectRaw("ROUND(SUM(stocks.$stockColumn), 2) as total")
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

    // New method to get stock by memo
    public function getStockByCashMemo($cash_memo_no)
    {
        $order = Order::with('meta.product','client', 'payments')->where('cash_memo_no', $cash_memo_no)->first();

        if (!$order) {
            return response()->json(['message' => 'Cash memo not found'], 404);
        }

        $products = $order->meta->map(function($p){
            $product = $p->product;
            $carat   = $product->carat ?? null;
            $type    = $product->type ?? null;
            $weight  = $p->weight ?? 0;
        
            return [
                'product_nr'   => $product->product_nr ?? null,
                'product_name' => $product->product_details ?? null,
        
                'unit_18k' => ($type == 'gold' && $carat == 18) ? $weight : 0,
                'unit_21k' => $carat == 21 ? $weight : 0,
                'unit_22k' => $carat == 22 ? $weight : 0,
        
                'st'   => ($type == 'gold' && $product->st_dia) ? $weight : 0,
                'd18k' => ($type == 'diamond' && $carat == 18) ? $weight : 0,
                'dia'  => $product->st_dia ?? 0,
            ];
        });

        $paymentTypes = [
            'gold', 'cash', 'mobile_banking', 'card', 'bank'
        ];

        $payments = [];

        foreach ($paymentTypes as $type) {
            $payments[$type] = $order->payments
                                    ->where('payment', $type)
                                    ->sum('amount');
        }

        return response()->json([
            'date' => $order->date,
            'client_id' => $order->client_id,
            'client_name' => $order->client->name ?? '',
            'client_phone' => $order->client->mobile_number ?? '',
            'products' => $products,
            'bill_amount' => $order->total,
            'discount' => $order->discount,
            'advance' => $order->paid ?? 0,
            'final_bill' => $order->final_bill ?? $order->total - $order->discount,

            'gold' => $payments['gold'] ?? 0,
            'cash' => $payments['cash'] ?? 0,
            'dbbl' => $payments['mobile_banking'] ?? 0,
            'city_qr' => $payments['card'] ?? 0,
            'cbbl' => $payments['bank'] ?? 0,

            'due' => $order->due ?? 0,
        ]);
    }
    
    public function report(Request $request)
    {
        $this->authorize('Access Stock');

        $categories = ProductCategory::orderBy('name')->get();
        $suppliers  = Supplier::orderBy('name')->get();

        // Base query
        $query = Product::query()->with('supplier');

        // Apply filters
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        } elseif ($request->filled('start_date')) {
            $query->where('created_at', '>=', Carbon::parse($request->start_date)->startOfDay());
        } elseif ($request->filled('end_date')) {
            $query->where('created_at', '<=', Carbon::parse($request->end_date)->endOfDay());
        }

        if ($request->filled('status')) {
            $status = strtolower($request->status);
            if ($status === 'sold') {
                $query->where('status', 'Sold');
            } elseif ($status === 'fresh') {
                $query->where(function($q) {
                    $q->whereNull('status')->orWhere('status', '!=', 'Sold');
                });
            }
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('product_category_id')) {
            $query->where('product_category_id', $request->product_category_id);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('token_number')) {
            $query->where('product_nr', 'like', '%' . $request->token_number . '%');
        }

        // Fetch all products
        $products = $query->get();

        // Map products for report
        $reportRows = $products->map(function ($p) {

            // Find selling stock entry (trx_type = out)
            $sellingStock = $p->stocks()
                ->where('trx_type', 'out')
                ->orderBy('date', 'desc')
                ->first();

            return [
                'new_token'    => $p->product_nr,
                'po_number'    => $p->booking_number,
                'p_date'       => $p->created_at ? Carbon::parse($p->created_at)->format('Y-m-d') : null,
                'supplier'     => $p->supplier->name ?? null,
                'qty'          => 1,
                'w18k'         => $p->carat == 18 ? (float)$p->weight : 0,
                'w21k'         => $p->carat == 21 ? (float)$p->weight : 0,
                'w22k'         => $p->carat == 22 ? (float)$p->weight : 0,
                'stone'        => (float)($p->st_dia ?? 0),
                'total_weight' => (float)(($p->weight ?? 0) + ($p->st_dia ?? 0)),
                'p_rate'       => $p->weight > 0 ? round($p->purchase_price, 2) : 0,
                's_rate'       => $p->weight > 0 ? round($p->price, 2) : 0,
                'status'       => $p->status === 'Sold' ? 'Sold' : 'Fresh',
                'selling_date' => $sellingStock ? Carbon::parse($sellingStock->date)->format('Y-m-d') : null,
            ];
        });

        // Totals
        $totals = [
            'qty'          => $reportRows->sum('qty'),
            'w18k'         => $reportRows->sum('w18k'),
            'w21k'         => $reportRows->sum('w21k'),
            'w22k'         => $reportRows->sum('w22k'),
            'stone'        => $reportRows->sum('stone'),
            'total_weight' => $reportRows->sum('total_weight'),
        ];

        $denom = $reportRows->sum(function($r) { return $r['w18k'] + $r['w21k'] + $r['w22k']; });
        $totals['p_rate'] = $denom > 0 ? round($reportRows->sum(function($r){ return $r['p_rate'] * ($r['w18k']+$r['w21k']+$r['w22k']); }) / $denom, 2) : 0;
        $totals['s_rate'] = $denom > 0 ? round($reportRows->sum(function($r){ return $r['s_rate'] * ($r['w18k']+$r['w21k']+$r['w22k']); }) / $denom, 2) : 0;

        // ---------------- PAGINATION ----------------
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 50;
        $offset = ($page - 1) * $perPage;

        $itemsForCurrentPage = $reportRows->slice($offset, $perPage)->values();

        $paginatedRows = new LengthAwarePaginator(
            $itemsForCurrentPage,
            $reportRows->count(),
            $perPage,
            $page,
            [
                'path' => url()->current(),
                'query' => $request->query(),
            ]
        );

        return view('stock.report', [
            'categories' => $categories,
            'suppliers'  => $suppliers,
            'rows'       => $paginatedRows, // paginated
            'totals'     => $totals,
            'filters'    => $request->only([
                'start_date','end_date','status','type','product_category_id','supplier_id','token_number'
            ])
        ]);
    }
    
    public function reportPdf(Request $request)
    {
        $this->authorize('Access Stock');

        // -------- Same filtering logic as your original code --------
        $query = Product::query()->with('supplier');
        $categories = ProductCategory::all();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        } elseif ($request->filled('start_date')) {
            $query->where('created_at', '>=', Carbon::parse($request->start_date)->startOfDay());
        } elseif ($request->filled('end_date')) {
            $query->where('created_at', '<=', Carbon::parse($request->end_date)->endOfDay());
        }

        if ($request->filled('status')) {
            $status = strtolower($request->status);
            if ($status === 'sold') {
                $query->where('status', 'Sold');
            } else {
                $query->whereNull('status')->orWhere('status', '!=', 'Sold');
            }
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('product_category_id')) {
            $query->where('product_category_id', $request->product_category_id);
        }

        if ($request->filled('token_number')) {
            $query->where('product_nr', 'like', '%' . $request->token_number . '%');
        }

        $products = $query->get();

        // -------- Build rows --------
        $rows = $products->map(function ($p) {
            $selling = $p->stocks()
                ->where('trx_type', 'out')
                ->latest('date')
                ->first();

            return [
                'new_token'    => $p->product_nr,
                'po_number'    => $p->booking_number,
                'p_date'       => optional($p->created_at)->format('Y-m-d'),
                'supplier'     => $p->supplier->name ?? '',
                'qty'          => 1,
                'w18k'         => $p->carat == 18 ? (float)$p->weight : 0,
                'w21k'         => $p->carat == 21 ? (float)$p->weight : 0,
                'w22k'         => $p->carat == 22 ? (float)$p->weight : 0,
                'stone'        => (float)($p->st_dia ?? 0),
                'total_weight' => (float)(($p->weight ?? 0) + ($p->st_dia ?? 0)),
                'p_rate'       => $p->weight > 0 ? round($p->purchase_price, 2) : 0,
                's_rate'       => $p->weight > 0 ? round($p->price, 2) : 0,
                'selling_date' => $selling ? Carbon::parse($selling->date)->format('Y-m-d') : '',
                'status'       => $p->status === 'Sold' ? 'Sold' : 'In Stock',
            ];
        });

        // -------- Totals --------
        $totals = [
            'qty'          => $rows->sum('qty'),
            'w18k'         => $rows->sum('w18k'),
            'w21k'         => $rows->sum('w21k'),
            'w22k'         => $rows->sum('w22k'),
            'stone'        => $rows->sum('stone'),
            'total_weight' => $rows->sum('total_weight'),
        ];

        $den = $rows->sum(fn($r) => $r['w18k'] + $r['w21k'] + $r['w22k']);
        $totals['p_rate'] = $den ? round($rows->sum(fn($r) => $r['p_rate'] * ($r['w18k']+$r['w21k']+$r['w22k'])) / $den, 2) : 0;
        $totals['s_rate'] = $den ? round($rows->sum(fn($r) => $r['s_rate'] * ($r['w18k']+$r['w21k']+$r['w22k'])) / $den, 2) : 0;

        // -------- Generate HTML --------
        $html = view('stock.report-pdf', [
            'rows'   => $rows,
            'totals' => $totals,
            'filters'=> $request->all(),
            'categories' => $categories,
        ])->render();

        // -------- Regular PDF generation attempt --------
        try {
            return PDF::loadHTML($html)
                ->stream('stock-report.pdf');
        }
        catch (\Mpdf\MpdfException $e) {

            // -------- Fallback: Chunk HTML for large reports --------
            $mpdf = new Mpdf([
                'tempDir' => config('mpdf.tempDir'),
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 10,
                'margin_bottom' => 5,
                'pcre.backtrack_limit' => 10000000,
                'pcre.recursion_limit' => 10000000,
                'pcre.jit' => false,
            ]);

            foreach (str_split($html, 50000) as $chunk) {
                $mpdf->WriteHTML($chunk);
            }

            return $mpdf->Output('stock-report.pdf', 'I');
        }
    }
    
    public function dailySummary(Request $request)
    {
        $this->authorize('Access Stock');

        $date = $request->filled('date')
            ? Carbon::parse($request->date)->endOfDay()
            : Carbon::today()->endOfDay();

        // Get products that exist up to this date AND remain unsold
        $products = Product::with('category')
            ->whereDate('created_at', '<=', $date)
            ->get()
            ->filter(function ($p) use ($date) {
                return ! $p->stocks()
                    ->where('trx_type', 'out')
                    ->where('date', '<=', $date)
                    ->exists();
            });

        // Group by Category
        $grouped = $products->groupBy(fn($p) => $p->category->name ?? 'Others');

        $rows = [];
        $sl = 1;

        foreach ($grouped as $category => $items) {

            $total_weight = $items->sum(fn($p) => ($p->weight ?? 0) + ($p->st_dia ?? 0));
            $stone = $items->sum('st_dia');

            $rows[] = [
                'sl'           => $sl++,
                'category'     => $category,
                'qty'          => $items->count(),
                'total_weight' => round($total_weight, 2),
                'diamond'      => round($items->sum('st_dia'), 2),
                'w18k'         => round($items->where('carat', 18)->sum('weight'), 2),
                'w21k'         => round($items->where('carat', 21)->sum('weight'), 2),
                'w22k'         => round($items->where('carat', 22)->sum('weight'), 2),
                'stone'        => round($stone, 2),
                'balance'      => '',  // Optional custom logic
            ];
        }

        // TOTALS
        $totals = [
            'qty'          => array_sum(array_column($rows, 'qty')),
            'total_weight' => array_sum(array_column($rows, 'total_weight')),
            'total_weight_vori' => round(array_sum(array_column($rows, 'total_weight')) / 11.664, 3),
            'diamond'      => array_sum(array_column($rows, 'diamond')),
            'w18k'         => array_sum(array_column($rows, 'w18k')),
            'w18k_vori' => round(array_sum(array_column($rows, 'w18k')) / 11.664, 3),
            'w21k'         => array_sum(array_column($rows, 'w21k')),
            'w21k_vori' => round(array_sum(array_column($rows, 'w21k')) / 11.664, 3),
            'w22k'         => array_sum(array_column($rows, 'w22k')),
            'w22k_vori' => round(array_sum(array_column($rows, 'w22k')) / 11.664, 3),
            'stone'        => array_sum(array_column($rows, 'stone')),
        ];

        // ------------------------------
        // DIAMOND ONLY TABLE (Grouped)
        // ------------------------------
        $diamondProducts = $products->filter(function ($p) {
            return ($p->type == 'diamond') || ($p->diamond > 0) || ($p->st_dia > 0);
        });

        // Group by product/category name
        $diamondGrouped = $diamondProducts->groupBy(function($p){
            return $p->category->name ?? 'Unknown';
        });

        $diamondRows = [];
        $dsl = 1;

        foreach ($diamondGrouped as $productName => $items) {

            $diamondRows[] = [
                'sl'      => $dsl++,
                'product' => $productName,
                'qty'     => $items->count(),

                // Total weight (sum)
                'weight'  => round($items->sum(function($i){
                                return ($i->weight ?? 0) + ($i->st_dia ?? 0);
                            }), 2),

                'w18k'    => round($items->where('carat', 18)->sum('weight'), 2),
            ];
        }

        $diamondTotals = [
            'qty'    => array_sum(array_column($diamondRows, 'qty')),
            'weight' => array_sum(array_column($diamondRows, 'weight')),
            'w18k'   => array_sum(array_column($diamondRows, 'w18k')),
        ];

        return view('stock.daily_summary', [
            'rows'   => $rows,
            'date'   => $date->format('d-m-Y'),
            'totals' => $totals,

            'diamondRows'   => $diamondRows,
            'diamondTotals' => $diamondTotals,
        ]);
    }
    
    public function dailySummaryPdf(Request $request)
    {
        $this->authorize('Access Stock');

        $date = $request->filled('date')
            ? Carbon::parse($request->date)->endOfDay()
            : Carbon::today()->endOfDay();

        // SAME PRODUCT LOGIC AS YOUR dailySummary METHOD
        $products = Product::with('category')
            ->whereDate('created_at', '<=', $date)
            ->get()
            ->filter(function ($p) use ($date) {
                return ! $p->stocks()
                    ->where('trx_type', 'out')
                    ->where('date', '<=', $date)
                    ->exists();
            });

        $grouped = $products->groupBy(fn($p) => $p->category->name ?? 'Others');

        $rows = [];
        $sl = 1;

        foreach ($grouped as $category => $items) {
            $total_weight = $items->sum(fn($p) => ($p->weight ?? 0) + ($p->st_dia ?? 0));

            $rows[] = [
                'sl'           => $sl++,
                'category'     => $category,
                'qty'          => $items->count(),
                'total_weight' => round($total_weight, 2),
                'diamond'      => round($items->sum('st_dia'), 2),
                'w18k'         => round($items->where('carat', 18)->sum('weight'), 2),
                'w21k'         => round($items->where('carat', 21)->sum('weight'), 2),
                'w22k'         => round($items->where('carat', 22)->sum('weight'), 2),
                'stone'        => round($items->sum('st_dia'), 2),
            ];
        }

        $totals = [
            'qty'          => array_sum(array_column($rows, 'qty')),
            'total_weight' => array_sum(array_column($rows, 'total_weight')),
            'total_weight_vori' => round(array_sum(array_column($rows, 'total_weight')) / 11.664, 3),
            'diamond'      => array_sum(array_column($rows, 'diamond')),
            'w18k'         => array_sum(array_column($rows, 'w18k')),
            'w18k_vori'    => round(array_sum(array_column($rows, 'w18k')) / 11.664, 3),
            'w21k'         => array_sum(array_column($rows, 'w21k')),
            'w21k_vori'    => round(array_sum(array_column($rows, 'w21k')) / 11.664, 3),
            'w22k'         => array_sum(array_column($rows, 'w22k')),
            'w22k_vori'    => round(array_sum(array_column($rows, 'w22k')) / 11.664, 3),
            'stone'        => array_sum(array_column($rows, 'stone')),
        ];

        // Diamond table
        $diamondProducts = $products->filter(function ($p) {
            return $p->type == 'diamond' || $p->diamond > 0 || $p->st_dia > 0;
        });

        $diamondGrouped = $diamondProducts->groupBy(fn($p) => $p->category->name ?? 'Unknown');
        $diamondRows = [];
        $dsl = 1;

        foreach ($diamondGrouped as $productName => $items) {
            $diamondRows[] = [
                'sl' => $dsl++,
                'product' => $productName,
                'qty' => $items->count(),
                'weight' => round($items->sum(fn($i) => ($i->weight ?? 0) + ($i->st_dia ?? 0)), 2),
                'w18k' => round($items->where('carat', 18)->sum('weight'), 2),
            ];
        }

        $diamondTotals = [
            'qty' => array_sum(array_column($diamondRows, 'qty')),
            'weight' => array_sum(array_column($diamondRows, 'weight')),
            'w18k' => array_sum(array_column($diamondRows, 'w18k')),
        ];

        // LOAD PDF VIEW
        $html = view('stock.daily_summary_pdf', [
            'rows' => $rows,
            'totals' => $totals,
            'diamondRows' => $diamondRows,
            'diamondTotals' => $diamondTotals,
            'date' => $date->format('d-m-Y')
        ])->render();

        // GENERATE PDF WITH MPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
        ]);

        $mpdf->WriteHTML($html);
        return $mpdf->Output("Daily-Stock-Summary.pdf", "I"); // I = view inline
    }
    
    public function saleList()
    {
        $stocks = Stock::with([
                'client',
                'payment',
                'order.meta.product',
                'product'
            ])
            ->where('type', Stock::TYPE_SALE)
            ->latest()
            ->get();

        $stocksGrouped = $stocks->groupBy('memo');

        return view('stock.saleList', ['stocksGrouped' => $stocksGrouped]);
    }

    public function saleEdit($memo)
    {
        $stocks = Stock::with(['client', 'payment', 'order.meta.product', 'product'])
                       ->where('memo', $memo)
                       ->where('type', Stock::TYPE_SALE)
                       ->get();

        if ($stocks->isEmpty()) {
            abort(404, 'Memo not found.');
        }


        return view('stock.saleEdit', compact('stocks', 'memo'));
    }

    public function saleUpdate(Request $request, $memo)
    {
        $request->validate([
            'date' => 'required|date',
            'unit_18k.*' => 'nullable|numeric',
            'unit_21k.*' => 'nullable|numeric',
            'unit_22k.*' => 'nullable|numeric',
            'st.*' => 'nullable|numeric',
            'd18k.*' => 'nullable|numeric',
            'dia.*' => 'nullable|numeric',
            'bill_amount' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'advance' => 'nullable|numeric',
            'final_bill' => 'nullable|numeric',
            'gold' => 'nullable|numeric',
            'cash' => 'nullable|numeric',
            'dbbl' => 'nullable|numeric',
            'city_qr' => 'nullable|numeric',
            'cbbl' => 'nullable|numeric',
        ]);

        $stocks = Stock::with('payment')->where('memo', $memo)->get();

        foreach ($stocks as $index => $stock) {

            $stock->update([
                'date' => $request->date,
                'unit_18k' => $request->unit_18k[$index] ?? 0,
                'unit_21k' => $request->unit_21k[$index] ?? 0,
                'unit_22k' => $request->unit_22k[$index] ?? 0,
                'st' => $request->st[$index] ?? 0,
                'd18k' => $request->d18k[$index] ?? 0,
                'dia' => $request->dia[$index] ?? 0,
            ]);
        }

        $firstStock = $stocks->first();
        if ($firstStock && $firstStock->payment) {
            $firstStock->payment->update([
                'bill_amount' => $request->bill_amount ?? 0,
                'discount' => $request->discount ?? 0,
                'advance' => $request->advance ?? 0,
                'final_bill' => $request->final_bill ?? 0,
                'gold' => $request->gold ?? 0,
                'cash' => $request->cash ?? 0,
                'dbbl' => $request->dbbl ?? 0,
                'city_qr' => $request->city_qr ?? 0,
                'cbbl' => $request->cbbl ?? 0,
            ]);
        }

        notify()->success('Stock and payment updated successfully.');
        return redirect()->route('stock.saleList', $memo);
    }
    
    public function cashBookReport(Request $request)
    {
        $from = $request->input('from_date');
        $to   = $request->input('to_date');

        $stocksQuery = Stock::with(['client','payment','product.category'])
            ->where('type', Stock::TYPE_SALE);

        if ($from && $to) {
            $stocksQuery->whereBetween('date', [$from, $to]);
        }

        $stocksGrouped = $stocksQuery->orderBy('date','asc')
            ->get()
            ->groupBy('date');

        $bookingQuery = Booking::with(['client','meta.product.category','payments']);

        if ($from && $to) {
            $bookingQuery->whereBetween('date', [$from, $to]);
        }

        $bookings = $bookingQuery->orderBy('date','asc')->get();


        // ================= STOCK SUMMARY CALCULATION =================

        $startDate = $from ?? now()->format('Y-m-d');
        $endDate   = $to ?? now()->format('Y-m-d');

        $calculateStock = function($type, $carat = null) use ($startDate, $endDate) {

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

            // BALANCE B/F (before from_date)
            $productTotal = Product::query()
                ->when($carat, fn($q)=>$q->where('carat', $carat))
                ->where('type', $type)
                ->whereDate('created_at','<',$startDate)
                ->sum($column) ?? 0;

            $stockOutTotal = Stock::query()
                ->where('trx_type','out')
                ->whereDate('created_at','<',$startDate)
                ->sum($stockColumn) ?? 0;

            $bf = round($productTotal - $stockOutTotal, 2);

            // SALE IN RANGE
            $saleRange = Stock::query()
                ->where('trx_type','out')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum($stockColumn) ?? 0;

            $balanceAfterSale = round($bf - $saleRange, 2);

            // ADDITIONS IN RANGE
            $additionsList = Product::query()
                ->when($carat, fn($q) => $q->where('carat', $carat))
                ->where('type', $type)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('stock_type')
                ->selectRaw("stock_type, SUM($column) as total")
                ->get()
                ->mapWithKeys(fn($row) => [ strtoupper(trim($row->stock_type)) => $row->total ])
                ->toArray();

            return [
                'bf'        => $bf,
                'sale_today'=> $saleRange,
                'balance'   => $balanceAfterSale,
                'additions' => $additionsList,
                'closing'   => round($balanceAfterSale + array_sum($additionsList), 2),
            ];
        };

        $balances = [
            'gold' => [
                '18' => $calculateStock('gold', '18'),
                '21' => $calculateStock('gold', '21'),
                '22' => $calculateStock('gold', '22'),
                'ST' => $calculateStock('gold', null),
            ],
            'diamond' => [
                'D18k' => $calculateStock('diamond', '18'),
                'DIA'  => $calculateStock('diamond', null),
            ],
        ];

        return view('stock.cashBookReport', compact(
            'stocksGrouped',
            'bookings',
            'from',
            'to',
            'balances'
        ));
    }

    public function cashBookPdf(Request $request)
    {
        $from = $request->from_date;
        $to   = $request->to_date;

        $stocksGrouped = Stock::with(['client','payment','product.category'])
            ->where('type', Stock::TYPE_SALE)
            ->whereBetween('date', [$from, $to])
            ->orderBy('date','asc')
            ->get()
            ->groupBy('date');

        $bookingsGrouped = Booking::with(['client','meta.product.category','payments'])
            ->whereBetween('date', [$from, $to])
            ->orderBy('date','asc')
            ->get()
            ->groupBy('date');

        $allDates = collect()
            ->merge($stocksGrouped->keys())
            ->merge($bookingsGrouped->keys())
            ->unique()
            ->sort()
            ->values();

        $balancesByDate = [];

        foreach ($allDates as $date) {

            $calculateStock = function($type, $carat = null) use ($date) {

                $column = ($type == 'gold' && in_array($carat,['18','21','22'])) ? 'weight'
                        : ($type == 'gold' && is_null($carat) ? 'st_dia'
                        : ($type == 'diamond' && $carat=='18' ? 'weight' : 'st_dia'));

                $stockColumn = match(true) {
                    $type=='gold' && $carat=='18'   => 'unit_18k',
                    $type=='gold' && $carat=='21'   => 'unit_21k',
                    $type=='gold' && $carat=='22'   => 'unit_22k',
                    $type=='gold' && is_null($carat)=> 'st',
                    $type=='diamond' && $carat=='18'=> 'd18k',
                    $type=='diamond' && is_null($carat)=> 'dia',
                };

                // Opening (Balance B/F)
                $productBefore = Product::query()
                    ->when($carat, fn($q)=>$q->where('carat',$carat))
                    ->where('type',$type)
                    ->whereDate('created_at','<',$date)
                    ->sum($column) ?? 0;

                $stockOutBefore = Stock::query()
                    ->where('trx_type','out')
                    ->whereDate('created_at','<',$date)
                    ->sum($stockColumn) ?? 0;

                $bf = round($productBefore - $stockOutBefore, 2);

                // Sale Today
                $saleToday = Stock::where('trx_type','out')
                    ->whereDate('created_at',$date)
                    ->sum($stockColumn) ?? 0;

                $balanceAfterSale = round($bf - $saleToday, 2);

                // Additions Today
                $additions = Product::query()
                    ->when($carat, fn($q)=>$q->where('carat',$carat))
                    ->where('type',$type)
                    ->whereDate('created_at',$date)
                    ->groupBy('stock_type')
                    ->selectRaw("stock_type, SUM($column) as total")
                    ->get()
                    ->mapWithKeys(fn($r)=>[ strtoupper(trim($r->stock_type)) => $r->total ])
                    ->toArray();

                $closing = round($balanceAfterSale + array_sum($additions), 2);

                return [
                    'bf'        => $bf,
                    'sale_today'=> $saleToday,
                    'balance'   => $balanceAfterSale,
                    'additions' => $additions,
                    'closing'   => $closing,
                ];
            };

            $balancesByDate[$date] = [
                'gold' => [
                    '18' => $calculateStock('gold','18'),
                    '21' => $calculateStock('gold','21'),
                    '22' => $calculateStock('gold','22'),
                    'ST' => $calculateStock('gold',null),
                ],
                'diamond' => [
                    'D18k' => $calculateStock('diamond','18'),
                    'DIA'  => $calculateStock('diamond',null),
                ],
            ];
        }

        $pdf = Pdf::loadView('stock.cashBookPdf', compact(
            'stocksGrouped',
            'bookingsGrouped',
            'balancesByDate',
            'allDates'
        ), [], ['format' => 'A4-L']);

        return $pdf->stream('cash-book.pdf');
    }


}
