<?php

namespace App\Http\Controllers;

use App\Datatables\SupplierTrxDatatable;
use App\Http\Requests\DatatableRequest;
use App\Models\Supplier;
use App\Models\SupplierTransaction;
use DB;
use Illuminate\Http\Request;

class SupplierTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('Access Suppliers Transaction');

        if ($request->has('draw')) {
            return (new SupplierTrxDatatable)->handel(app(DatatableRequest::class));
        }

        return view('supplier_transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('Create Supplier Transaction');
        $transaction = new SupplierTransaction();
        $clients = Supplier::limit('10')->pluck('name', 'id');
        return view('supplier_transaction.create', compact('transaction', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Create Supplier Transaction');
        try {
            request()->validate(SupplierTransaction::$rules);
            $transaction = SupplierTransaction::create($request->all());

            $supplier = Supplier::where('id', $transaction->supplier_id)->first();
            // $supplier->increment('due_amount', $request->bill_amount - ($request->payment_amount + $request->advanced));

            $bill_amount = SupplierTransaction::where('supplier_id', $supplier->id)
                ->sum('bill_amount');
            $payment_amount = SupplierTransaction::where('supplier_id', $supplier->id)
                ->sum('payment_amount');

            $supplier->due_amount = $bill_amount - $payment_amount;
            $supplier->save();

            notify()->success(__('Transaction created successfully.'));
            return redirect()->route('suppliers.show', $supplier->id);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $this->authorize('Show Transaction');
        $transaction = Transaction::find($id);

        return view('transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $this->authorize('Edit Supplier Transaction');
        $transaction = SupplierTransaction::find($id);
        $clients = Supplier::where('id', $transaction->supplier_id)->pluck('name', 'id');
        return view('supplier_transaction.edit', compact('transaction', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  SupplierTransaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('Edit Supplier Transaction');

        request()->validate(SupplierTransaction::$rules);

        try {
            DB::beginTransaction();
            $transaction = SupplierTransaction::find($id);

            $supplier = Supplier::where('id', $transaction->supplier_id)->first();

            // $client->decrement('due_amount', $transaction->bill_amount - ($transaction->payment_amount + $transaction->advanced));

            $transaction->update($request->all());

            // $client->increment('due_amount', $request->bill_amount - ($request->payment_amount + $request->advanced));

            $bill_amount = SupplierTransaction::where('supplier_id', $supplier->id)
                ->sum('bill_amount');
            $payment_amount = SupplierTransaction::where('supplier_id', $supplier->id)
                ->sum('payment_amount');

            $supplier->due_amount = $bill_amount - $payment_amount;
            $supplier->save();
            DB::commit();

            notify()->success(__('Transaction updated successfully'));
            return redirect()->route('suppliers.show', $supplier->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete Supplier Transaction');

        try {
            DB::beginTransaction();

            $transaction = SupplierTransaction::find($id);
            $client = Supplier::where('id', $transaction->supplier_id)->first();
            $client->decrement('due_amount', $transaction->bill_amount - ($transaction->payment_amount + $transaction->advanced));
            $transaction = $transaction->delete();

            DB::commit();

            notify()->success(__('Transaction deleted successfully'));
            return redirect()->route('transactions.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
