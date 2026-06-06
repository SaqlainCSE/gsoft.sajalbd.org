<?php

namespace App\Http\Controllers;

use App\Exports\CSVExport;
use App\Http\Resources\ExpenseReportResource;
use App\Models\Expense;
use App\Models\PaymentMethod;
use App\Models\TransactionCode;
use App\Models\TrxHead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseReportController extends Controller
{

    public function create()
    {
        $this->authorize('Access Expenses');

        $transactionCodes = TransactionCode::query()
            ->where('type', 'expense')
            ->pluck('name', 'id');


        $heads = TrxHead::where('type', 'expense')
            ->pluck('name', 'id');

        $users = User::query()
            ->pluck('name', 'id')
            ->prepend(__('Select User'), '');

        $payment_methods = PaymentMethod::query()
            ->pluck('name', 'id');
        
        return view('expense-report.create', compact(
            'heads', 
            'users', 
            'payment_methods',
            'transactionCodes'
        ));
    }

    public function store(Request $request)
    {
        $this->authorize('Access Expenses');

        // Redirect or return a response

        $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'expense_by_id' => ['nullable', 'exists:users,id'],
            'payment_method_id' => ['nullable', 'exists:payment_methods,id'],
            'trx_head_id' => ['nullable', 'exists:trx_heads,id'],
        ]);
        

        $expenses = Expense::query()
            ->with('paymentMethod:id,name')
            ->with('trxHead:id,name')
            ->with('expenseBy:id,name')
            ->with('editor:id,username')
            ->when($request->expense_by_id, function ($query) use ($request) {
                return $query->where('expense_by_id', $request->expense_by_id);
            })
            ->when($request->payment_method_id, function ($query) use ($request) {
                return $query->where('payment_method_id', $request->payment_method_id);
            })
            ->when($request->trx_head_id, function ($query) use ($request) {
                return $query->where('trx_head_id', $request->trx_head_id);
            })
            ->when($request->transaction_code_id, function ($query) use ($request) {
                return $query->where('transaction_code_id', $request->transaction_code_id);
            })
            ->whereBetween('date', [
                Carbon::parse($request->start_date)->startOfMonth(), 
                Carbon::parse($request->end_date)->endOfMonth()
                ])
            ->get();

            if($request->format === 'json') {
                return ExpenseReportResource::collection($expenses);
            }
    
            if($request->format === 'csv'){
                return Excel::download(new CSVExport(
                    'expense-report.excel', 
                    ['expenses' => $expenses],
                ), 'expenses.xlsx');
            }
            return  \PDF::loadView('expense-report.pdf', [
                'expenses' => $expenses,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ], [], [
                'orientation' => 'P',
            ])->stream('payment.pdf');
    }
}
