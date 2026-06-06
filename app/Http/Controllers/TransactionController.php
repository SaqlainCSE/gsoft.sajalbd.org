<?php

namespace App\Http\Controllers;

use App\Datatables\TransactionDatatable;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
use Illuminate\Support\Facades\DB;

/**
 * Class TransactionController
 * @package App\Http\Controllers
 */
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('Due Transaction List');

        if ($request->has('draw')) {
            return (new TransactionDatatable)->handel(app(DatatableRequest::class));
        }
        ;

        return view('transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('Add Due Transaction');
        $transaction = new Transaction();
        $clients = Client::limit('10')->pluck('name', 'id');
        return view('transaction.create', compact('transaction', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Add Due Transaction');
        try {
            request()->validate(Transaction::$rules);
            $transaction = Transaction::create($request->all());

            $client = Client::where('id', $transaction->client_id)->first();
            $client->increment('due_amount', $request->bill_amount - ($request->payment_amount + $request->advance));

            notify()->success(__('Transaction created successfully.'));
            return redirect()->route('transactions.index');
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
        $this->authorize('Edit Due Transaction');
        $transaction = Transaction::find($id);
        $clients = Client::where('id', $transaction->client_id)->pluck('name', 'id');
        return view('transaction.edit', compact('transaction', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('Edit Due Transaction');

        request()->validate(Transaction::$rules);

        try {
            DB::beginTransaction();
            $client = Client::where('id', $transaction->client_id)->first();
            $client->decrement('due_amount', $transaction->bill_amount - ($transaction->payment_amount + $transaction->advance));

            $transaction->update($request->all());
            $client->increment('due_amount', $request->bill_amount - ($request->payment_amount + $request->advance));
            DB::commit();
            notify()->success(__('Transaction updated successfully'));
            return redirect()->route('transactions.index');
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
        $this->authorize('Delete Due Transaction');

        try {
            DB::beginTransaction();

            $transaction = Transaction::find($id);
            $client = Client::where('id', $transaction->client_id)->first();
            $client->decrement('due_amount', $transaction->bill_amount - ($transaction->payment_amount + $transaction->advance));
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
