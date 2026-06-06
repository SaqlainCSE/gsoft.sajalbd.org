<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Datatables\ExpenseDatatable;
use App\Http\Requests\DatatableRequest;
use App\Models\PaymentMethod;
use App\Models\TrxHead;
use App\Models\User;

/**
 * Class ExpenseController
 * @package App\Http\Controllers
 */
class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('Access Expenses');
        
        if($request->has('draw')){
            return (new ExpenseDatatable)->handel(app(DatatableRequest::class));
        };

        return view('expense.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('Create Expense');
        $expense = new Expense();
        $expense_head = TrxHead::query()
            // ->where('type', 'expense')
            ->pluck('name', 'id');
            
        $payment_methods = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->pluck('name', 'id');

        $users = User::query()
            ->orderBy('id', 'asc')
            ->pluck('name', 'id');

        return view(
            'expense.create', 
            compact('expense', 'expense_head', 'payment_methods', 'users')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Create Expense');

        $trx_head = TrxHead::find($request->trx_head_id);
        if ($trx_head) {
            $request->merge(['transaction_code_id' => $trx_head->transaction_code_id]);
        }

        $validated = request()->validate(Expense::$rules);
       
        $expense = Expense::create($validated);
        notify()->success(__('Expense created successfully.'));
        return redirect()->route('expenses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Show Expense');
        $expense = Expense::find($id);

        return view('expense.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $this->authorize('Edit Expense');
        $expense = Expense::find($id);

        $expense_head = TrxHead::where('type', 'expense')
            ->pluck('name', 'id');
            
        $payment_methods = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->pluck('name', 'id');

        $users = User::query()
            ->orderBy('id', 'asc')
            ->pluck('name', 'id');

        return view(
            'expense.edit', 
            compact('expense', 'expense_head', 'payment_methods', 'users')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $this->authorize('Edit Expense');

        $trx_head = TrxHead::find($request->trx_head_id);
        if ($trx_head) {
            $request->merge(['transaction_code_id' => $trx_head->transaction_code_id]);
        }
        
        request()->validate(Expense::$rules);

        $expense->update($request->all());
        notify()->success(__('Expense updated successfully'));
        return redirect()->route('expenses.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete Expense');
        
        $expense = Expense::find($id)->delete();
        notify()->success(__('Expense deleted successfully'));
        return redirect()->route('expenses.index');
    }
}
