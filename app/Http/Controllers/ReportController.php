<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Order;
use App\Models\Supplier;
use App\Models\SupplierTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        $type = [
            "sell_report" => "Sells Report",
            "booking_report" => "Booking Report",
            "supplier_due" => "Supplier Due",
            "supplier_transaction" => "Supplier Transaction",
            "customer_due" => "Customer Due",
            "customer_transaction" => "Customer Transaction",
        ];
        $users = User::query()->pluck('name', 'id');
        
        return view('report.create', compact('type', 'users'));
    }

    public function show(Request $request)
    {
        if ($request->type === "supplier_due") {
            return $this->supplier_due($request);
        } elseif ($request->type === "supplier_transaction") {
            return $this->supplier_transaction($request);
        } elseif ($request->type === "customer_due") {
            return $this->customer_due($request);
        } elseif ($request->type === "customer_transaction") {
            return $this->customer_transaction($request);
        } elseif ($request->type === "sell_report") {
            return $this->sell_report($request);
        } elseif ($request->type === "booking_report") {
            return $this->booking_report($request);
        }
        return response()->json([
            'view' => "",
        ]);
    }
    private function sell_report(Request $request)
    {
        $orders = Order::query()
            ->with('client.category', 'saleType:id,name', 'meta.product')
            ->when($request->has("client_id") && $request->client_id, fn($q) => $q->where('client_id', $request->client_id))
            ->when($request->has("from_date") && $request->from_date, fn($q) => $q->whereDate('created_at', '>=', $request->from_date))
            ->when($request->has("to_date") && $request->to_date, fn($q) => $q->whereDate('created_at', '<=', $request->to_date))
            ->when($request->has("sell_by") && $request->sell_by, fn($q) => $q->where('sell_by', $request->sell_by))
            ->get();

        $client = null;

        if ($request->has("client_id") && $request->client_id) {
            $client = Client::find($request->client_id);
        }

        if ($request->print) {
            $user = new User();
            if($request->sell_by){
                $user = User::find($request->sell_by);
            }
            return view('report.sell_report_print', compact('orders', 'client', 'user'));
        }

        // return $order->meta;

        return response()->json([
            'view' => view('report.sell_report', compact('orders', 'client'))->render(),
        ]);
    }
    private function booking_report(Request $request)
    {
        $orders = Booking::query()
            ->with('client', 'meta')
            ->when($request->has("client_id") && $request->client_id, fn($q) => $q->where('client_id', $request->client_id))
            ->when($request->has("from_date") && $request->from_date, fn($q) => $q->whereDate('created_at', '>=', $request->from_date))
            ->when($request->has("to_date") && $request->to_date, fn($q) => $q->whereDate('created_at', '<=', $request->to_date))
            ->get();

        $client = null;

        if ($request->has("client_id") && $request->client_id) {
            $client = Client::find($request->client_id);
        }

        if ($request->print) {
            return view('report.booking_report_print', compact('orders', 'client'));
        }

        return response()->json([
            'view' => view('report.booking_report', compact('orders', 'client'))->render(),
        ]);
    }
    private function supplier_due(Request $request)
    {
        $suppliers = Supplier::query()
            ->when($request->supplier_id, fn($q) => $q->where('id', $request->supplier_id))
            ->where('due_amount', '<>', 0)
            ->get();

        if ($request->print) {
            return view('report.supplier_due_print', compact('suppliers'));
        }

        return response()->json([
            'view' => view('report.supplier_due', compact('suppliers'))->render(),
        ]);
    }
    private function customer_due(Request $request)
    {
        $clients = Client::query()
            ->when($request->client_id, fn($q) => $q->where('id', $request->client_id))
            ->when(!$request->client_id, fn($q) => $q->where('due_amount', '<>', 0))
            ->get();

        if ($request->print) {
            return view('report.customer_due_print', compact('clients'));
        }

        return response()->json([
            'view' => view('report.customer_due', compact('clients'))->render(),
        ]);
    }
    private function supplier_transaction(Request $request)
    {
        $transactions = SupplierTransaction::query()
            ->with('supplier')
            ->when($request->has("supplier_id") && $request->supplier_id, fn($q) => $q->where('supplier_id', $request->supplier_id))
            ->when($request->has("from_date") && $request->from_date, fn($q) => $q->whereDate('created_at', '>=', $request->from_date))
            ->when($request->has("to_date") && $request->to_date, fn($q) => $q->whereDate('created_at', '<=', $request->to_date))
            ->get();

        $supplier = null;

        if ($request->has("supplier_id") && $request->supplier_id) {
            $supplier = Supplier::find($request->supplier_id);
        }
        if ($request->print) {
            return view('report.supplier_transactions_print', compact('transactions', 'supplier'));
        }

        return response()->json([
            'view' => view('report.supplier_transaction', compact('transactions', 'supplier'))->render(),
        ]);
    }
    private function customer_transaction(Request $request)
    {
        $transactions = Transaction::query()
            ->when(!$request->has("client_id") || !$request->client_id, fn($q) => $q->with('client'))
            ->when($request->has("client_id") && $request->client_id, fn($q) => $q->where('client_id', $request->client_id))
            ->when($request->has("from_date") && $request->from_date, fn($q) => $q->whereDate('created_at', '>=', $request->from_date))
            ->when($request->has("to_date") && $request->to_date, fn($q) => $q->whereDate('created_at', '<=', $request->to_date))
            ->get();

        $client = null;

        if ($request->has("client_id") && $request->client_id) {
            $client = Client::find($request->client_id);
        }

        if ($request->print) {
            return view('report.client_transactions_print', compact('client', 'transactions'));
        }

        return response()->json([
            'view' => view('report.client_transaction', compact('client', 'transactions'))->render(),
        ]);
    }
}
