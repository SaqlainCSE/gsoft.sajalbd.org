<?php

namespace App\Http\Controllers;

use App\Datatables\SaleTypeDatatable;
use App\Models\SaleType;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
/**
 * Class SaleTypeController
 * @package App\Http\Controllers
 */
class SaleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Access SaleTypes');
        
        if($request->has('draw')){
            return (new SaleTypeDatatable)->handel(app(DatatableRequest::class));
        };

        return view('sale-type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Create SaleType');
        $saleType = new SaleType();
        return view('sale-type.create', compact('saleType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Create SaleType');
        $request->merge(['status' => $request->filled('status')]);
        request()->validate(SaleType::$rules);

        $saleType = SaleType::create($request->all());
        notify()->success(__('SaleType created successfully.'));
        return redirect()->route('sale-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Show SaleType');
        $saleType = SaleType::find($id);

        return view('sale-type.show', compact('saleType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Edit SaleType');
        
        $saleType = SaleType::find($id);

        return view('sale-type.edit', compact('saleType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  SaleType $saleType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleType $saleType)
    {
        $this->authorize('Edit SaleType');
        $request->merge(['status' => $request->filled('status')]);
        request()->validate(SaleType::$rules);

        $saleType->update($request->all());
        notify()->success(__('SaleType updated successfully'));
        return redirect()->route('sale-types.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete SaleType');
        
        $saleType = SaleType::find($id)->delete();
        notify()->success(__('SaleType deleted successfully'));
        return redirect()->route('sale-types.index');
    }
}
