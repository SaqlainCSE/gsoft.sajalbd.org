<?php

namespace App\Http\Controllers;

use App\Datatables\OrderDatatable;
use App\Http\Requests\DatatableRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderMeta;
use App\Models\OrderPaymentInfo;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\SaleType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('Access POS');

        if ($request->has('draw')) {
            return (new OrderDatatable)->handel(app(DatatableRequest::class));
        };

        return view('pos.index');
    }

    public function create(Request $request)
    {
        $this->authorize('Access POS');
        $vats = array('5' => "5% VAT");

        $sales_types = SaleType::where('status', 1)->orderBy('id', 'asc')->pluck('name', 'id');

        $payment_type = [
            'cash' => "Cash",
            'gold' => "Gold",
            'card' => "Card",
            'bank' => 'Bank',
            'mobile_banking' => 'Mobile Banking',
            'other' => 'Other'
        ];

        $payment_methods = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'cash')
            ->pluck('name', 'name');

        $mobile_banking = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'mobile_banking')
            ->pluck('name', 'name');

        $banks = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'bank')
            ->pluck('name', 'name');

        $golds = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'gold')
            ->pluck('name', 'name');

        $cards = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'card')
            ->pluck('name', 'name');

        $others = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'other')
            ->pluck('name', 'name');

        $order = new Order();

        $users = User::query()
            ->pluck('name', 'id');

        if($request->wantsJson()){
            return response()->json([
                'order' => $order,
                'vats' => $vats,
                'users' => $users,
                'payment_methods' => $payment_methods,
                'banks' => $banks,
                'sales_types' => $sales_types,
                'payment_type' => $payment_type,
                'mobile_banking' => $mobile_banking,
                'golds' => $golds,
                'cards' => $cards,
                'others' => $others,                
            ]);
        }
        return view('pos.create', compact('order', 'vats', 'users', 'payment_methods', 'banks', 'sales_types', 'payment_type', 'mobile_banking', 'golds', 'cards', 'others'));
    }

    public function store(StoreOrderRequest $request)
    {
        // $request->dd();
        try {
            DB::beginTransaction();
            $order = Order::create([
                'client_id' => $request->client,
                'payment_method_id' => $request->payment_method,
                'date' => Carbon::today(),
                'vat' => $request->vat,
                'discount' => $request->discount ?: 0,
                'paid' => $request->paid,
                'sale_type_id' => $request->sale_type_id,
                'return_amount' => $request->return_amount,
                'sell_by' => $request->sell_by,
            ]);
            $total = 0;
            $product_ids = [];
            foreach ($request->product_id as $key => $product_id) {
                $subtotal = round((optional($request->weight)[$key] * optional($request->unit_price)[$key]) + $request->wage[$key] + optional($request->st_dia_price)[$key]);
                $subtotal = round($subtotal);
                $vat = $subtotal * ($request->vat / 100);
                $itemTotal = $subtotal + $vat;
                
                OrderMeta::create([
                    'order_id' => $order->id,
                    'product_id' => $product_id,
                    'weight' => optional($request->weight)[$key],
                    'unit_price' => optional($request->unit_price)[$key],
                    'wage' => optional($request->wage)[$key],
                    'st_dia' => optional($request->st_dia)[$key],
                    'st_dia_price' => optional($request->st_dia_price)[$key],
                    'vat_amount' => $vat,
                    'total' => $itemTotal
                ]);
                $total += $itemTotal;
                $product_ids[] = $product_id;
            }

            Product::whereIn('id', $product_ids)->update(['status' => 'Sold']);

            $order->total = $total;
            $order->due = str_replace(",", "", $request->due);
            $order->save();

            $paymentInfo = [];

            foreach ($request->payment as $key => $info) {
                $paymentInfo[] = [
                    'order_id' => $order->id,
                    'payment' => $info,
                    'payment_info' => $request->payment_info[$key],
                    'amount' => $request->amount[$key],
                    'reference' => $request->reference[$key],
                ];
            }

            OrderPaymentInfo::insert($paymentInfo);

            DB::commit();
            if($request->wantsJson()){
                return response()->noContent();
            }
            notify()->success(__('Order invoice created successfully'));
            return redirect()->route('pos.show', ['po' => $order->id, 'show' => 1]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit($id)
    {
        $this->authorize('Edit Sell');

        $vats = array('5' => "5% VAT");

        $sales_types = SaleType::where('status', 1)->orderBy('id', 'asc')->pluck('name', 'id');

        $payment_type = [
            'cash' => "Cash",
            'gold' => "Gold",
            'card' => "Card",
            'bank' => 'Bank',
            'mobile_banking' => 'Mobile Banking',
            'other' => 'Other'
        ];

        $payment_methods = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'cash')
            ->pluck('name', 'name');

        $mobile_banking = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'mobile_banking')
            ->pluck('name', 'name');

        $banks = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'bank')
            ->pluck('name', 'name');

        $golds = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'gold')
            ->pluck('name', 'name');

        $cards = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'card')
            ->pluck('name', 'name');

        $others = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'other')
            ->pluck('name', 'name');

        $order = Order::query()
            ->with('saleType:id,name', 'meta.product', 'client', 'payments')
            ->findOrFail($id);

        $users = User::query()
            ->pluck('name', 'id');
        return view('pos.edit', compact('users','order', 'vats', 'payment_methods', 'banks', 'sales_types', 'payment_type', 'mobile_banking', 'golds', 'cards', 'others'));
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $order = Order::find($id);

            $order->update([
                'client_id' => $request->client,
                'vat' => $request->vat,
                'discount' => $request->discount ?: 0,
                'paid' => $request->paid,
                'sale_type_id' => $request->sale_type_id,
                'return_amount' => $request->return_amount,
                'sell_by' => $request->sell_by,
            ]);
            $total = 0;
            $product_ids = [];

            $orderMeta = $order->meta();

            Product::whereIn('id', $orderMeta->pluck('product_id'))->update(['status' => 'Fresh']);

            $order->meta()->delete();

            foreach ($request->product_id as $key => $product_id) {
                $subtotal = round((optional($request->weight)[$key] * optional($request->unit_price)[$key]) + $request->wage[$key] + optional($request->st_dia_price)[$key]);
                $subtotal = round($subtotal);
                $vat = $subtotal * ($request->vat / 100);
                $itemTotal = $subtotal + $vat;
  
                OrderMeta::create([
                    'order_id' => $order->id,
                    'product_id' => $product_id,
                    'weight' => optional($request->weight)[$key],
                    'unit_price' => optional($request->unit_price)[$key],
                    'wage' => optional($request->wage)[$key],
                    'st_dia' => optional($request->st_dia)[$key],
                    'st_dia_price' => optional($request->st_dia_price)[$key],
                    'vat_amount' => $vat,
                    'total' => $itemTotal
                ]);
                $total += $itemTotal;
                $product_ids[] = $product_id;
            }

            Product::whereIn('id', $product_ids)->update(['status' => 'Sold']);

            $order->total = $total;
            $order->due = str_replace(",", "", $request->due);//$total - $request->paid - $request->discount;
            $order->save();

            $paymentInfo = [];
            $order->payments()->delete();
            foreach ($request->payment as $key => $info) {
                $paymentInfo[] = [
                    'order_id' => $order->id,
                    'payment' => $info,
                    'payment_info' => $request->payment_info[$key],
                    'amount' => $request->amount[$key],
                    'reference' => $request->reference[$key],
                ];
            }

            OrderPaymentInfo::insert($paymentInfo);

            DB::commit();
            notify()->success(__('Order invoice updated successfully'));
            return redirect()->route('pos.show', ['po' => $order->id, 'show' => 1]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function show($id)
    {
        $order = Order::query()
            ->with('saleType:id,name', 'meta.product', 'client', 'payments', 'sellBy:id,name')
            ->findOrFail($id);

        $sale_type = SaleType::find($order->sale_type_id);

        if (request('show') === "1") {
            return view('pos.show', compact('order', 'sale_type'));
        }

        return view('pos.print', compact('order', 'sale_type'));
    }
    public function preview(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'array'],
            'product_id.*' => ['required', 'integer'],
            'client' => ['required', 'integer'],
        ]);

        $products = Product::query()
            ->whereIn('id', $request->product_id)
            ->get();

        // dd($products->sum('weight'));

        $client = Client::find($request->client);

        $sale_type = SaleType::find($request->sale_type_id);
        return view('pos.preview', compact('client', 'products', 'sale_type'));
    }
}
