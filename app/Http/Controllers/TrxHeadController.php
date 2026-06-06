<?php

namespace App\Http\Controllers;

use App\Datatables\TrxHeadDatatable;
use App\Models\TrxHead;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
/**
 * Class TrxHeadController
 * @package App\Http\Controllers
 */
class TrxHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('Access TrxHeads');
        
        if($request->has('draw')){
            return (new TrxHeadDatatable)->handel(app(DatatableRequest::class));
        };

        return view('trx-head.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('Create TrxHead');
        $trxHead = new TrxHead();
        $types = [
            'expense' => __('Expense'),
            'investment' => __('Investment'),
            'income' => __('Income'),
        ];

        $transactionCodes = \App\Models\TransactionCode::query()
            ->where('is_active', 1)
            ->pluck('name', 'id');

        return view('trx-head.create', compact(
            'trxHead', 
            'types',
            'transactionCodes'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Create TrxHead');

        $transactionCode = \App\Models\TransactionCode::find($request->transaction_code_id);
        
        if ($transactionCode) {
            $request->merge(['type' => $transactionCode->type]);
        }
        
        request()->validate(TrxHead::$rules);
        
        $trxHead = TrxHead::create($request->all());
        notify()->success(__('TrxHead created successfully.'));
        return redirect()->route('trx-heads.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Show TrxHead');
        $trxHead = TrxHead::find($id);

        return view('trx-head.show', compact('trxHead'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $this->authorize('Edit TrxHead');
        $trxHead = TrxHead::find($id);
        $types = [
            'expense' => __('Expense'),
            'investment' => __('Investment'),
            'income' => __('Income'),
        ];

        $transactionCodes = \App\Models\TransactionCode::query()
            ->where('is_active', 1)
            ->pluck('name', 'id');

        return view('trx-head.edit', compact(
            'trxHead', 
            'types',
            'transactionCodes'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  TrxHead $trxHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrxHead $trxHead)
    {
        $this->authorize('Edit TrxHead');

        $transactionCode = \App\Models\TransactionCode::find($request->transaction_code_id);
        
        if ($transactionCode) {
            $request->merge(['type' => $transactionCode->type]);
        }
        
        request()->validate(TrxHead::$rules);


        $trxHead->update($request->all());
        notify()->success(__('TrxHead updated successfully'));
        return redirect()->route('trx-heads.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete TrxHead');
        
        $trxHead = TrxHead::find($id)->delete();
        notify()->success(__('TrxHead deleted successfully'));
        return redirect()->route('trx-heads.index');
    }
}
