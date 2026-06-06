<?php

namespace App\Http\Controllers;

use App\Datatables\TransactionCodeDatatable;
use App\Models\TransactionCode;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
/**
 * Class TransactionCodeController
 * @package App\Http\Controllers
 */
class TransactionCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('Access TransactionCodes');
        
        if($request->has('draw')){
            return (new TransactionCodeDatatable)->handel(app(DatatableRequest::class));
        };

        return view('transaction-code.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('Create TransactionCode');
        $transactionCode = new TransactionCode();

        $types = [
            'expense' => __('Expense'),
            'investment' => __('Investment'),
            'income' => __('Income'),
        ];

        return view('transaction-code.create', compact('transactionCode', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Create TransactionCode');
        request()->validate(TransactionCode::$rules);

        $transactionCode = TransactionCode::create($request->all());
        notify()->success(__('TransactionCode created successfully.'));
        return redirect()->route('transaction-codes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Show TransactionCode');
        $transactionCode = TransactionCode::find($id);

        return view('transaction-code.show', compact('transactionCode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $this->authorize('Edit TransactionCode');
        $transactionCode = TransactionCode::find($id);

        $types = [
            'expense' => __('Expense'),
            'investment' => __('Investment'),
            'income' => __('Income'),
        ];

        return view('transaction-code.edit', compact('transactionCode', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  TransactionCode $transactionCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionCode $transactionCode)
    {
        
        $this->authorize('Edit TransactionCode');

        request()->validate(TransactionCode::$rules);

        $transactionCode->update($request->all());
        notify()->success(__('TransactionCode updated successfully'));
        return redirect()->route('transaction-codes.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete TransactionCode');
        
        $transactionCode = TransactionCode::find($id)->delete();
        notify()->success(__('TransactionCode deleted successfully'));
        return redirect()->route('transaction-codes.index');
    }
}
