<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierTransaction;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
use Illuminate\Support\Facades\DB;

/**
 * Class SupplierController
 * @package App\Http\Controllers
 */
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('Access Suppliers');

        if ($request->has('draw')) {
            return (new \App\Datatables\SupplierDatatable)->handel(app(DatatableRequest::class));
        }
        
        return view('supplier.index');
    }
    public function due(Request $request)
    {
        $this->authorize('Access Suppliers Transaction');

        if ($request->has('draw')) {
            $request->merge(['due_only' => 1]);
            return (new \App\Datatables\SupplierDatatable)->handel(app(DatatableRequest::class));
        }
        

        return view('supplier.due');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('Create Supplier');
        $supplier = new Supplier();
        return view('supplier.create', compact('supplier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Create Supplier');
        request()->validate(
            array_merge(Supplier::$rules, [
                'mobile_number' => ['required', 'unique:suppliers,mobile_number'],
            ])
        );

        try {
            DB::beginTransaction();
            $supplier = Supplier::create($request->all());
            if($request->due_amount > 0){
                SupplierTransaction::create([
                    'supplier_id' => $supplier->id,
                    'reference_no' => date('YmdHi'),
                    'description' => 'PREVIOUS DUE',
                    "bill_amount" => $request->due_amount,
                ]);
            }
            DB::commit();
            notify()->success(__('Supplier created successfully.'));
            return redirect()->route('suppliers.index');

            
        } catch (\Throwable $th) {
            DB::rollBack();
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
        $this->authorize('Show Supplier');
        $supplier = Supplier::find($id);

        return view('supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $this->authorize('Edit Supplier');
        $supplier = Supplier::find($id);

        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $this->authorize('Edit Supplier');

        request()->validate(
            array_merge(Supplier::$rules, [
                'mobile_number' => ['required', 'unique:suppliers,mobile_number,' . $supplier->id],
            ])
        );

        $supplier->update($request->all());
        notify()->success(__('Supplier updated successfully'));
        return redirect()->route('suppliers.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete Supplier');

        $supplier = Supplier::find($id)->delete();
        notify()->success(__('Supplier deleted successfully'));
        return redirect()->route('suppliers.index');
    }
}
