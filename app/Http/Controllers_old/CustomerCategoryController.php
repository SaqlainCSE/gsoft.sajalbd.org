<?php

namespace App\Http\Controllers;

use App\Datatables\CustomerCategoryDatatable;
use App\Models\CustomerCategory;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
/**
 * Class CustomerCategoryController
 * @package App\Http\Controllers
 */
class CustomerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Access CustomerCategorys');
        
        if($request->has('draw')){
            return (new CustomerCategoryDatatable)->handel(app(DatatableRequest::class));
        };

        return view('customer-category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Create CustomerCategory');
        $customerCategory = new CustomerCategory();
        return view('customer-category.create', compact('customerCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Create CustomerCategory');
        $request->merge(['status' => $request->filled('status')]);
        request()->validate(CustomerCategory::$rules);

        $customerCategory = CustomerCategory::create($request->all());
        notify()->success(__('CustomerCategory created successfully.'));
        return redirect()->route('customer-categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Show CustomerCategory');
        $customerCategory = CustomerCategory::find($id);

        return view('customer-category.show', compact('customerCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Edit CustomerCategory');
        $customerCategory = CustomerCategory::find($id);

        return view('customer-category.edit', compact('customerCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  CustomerCategory $customerCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerCategory $customerCategory)
    {
        $this->authorize('Edit CustomerCategory');
        $request->merge(['status' => $request->filled('status')]);
        request()->validate(CustomerCategory::$rules);

        $customerCategory->update($request->all());
        notify()->success(__('CustomerCategory updated successfully'));
        return redirect()->route('customer-categories.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete CustomerCategory');
        
        $customerCategory = CustomerCategory::find($id)->delete();
        notify()->success(__('CustomerCategory deleted successfully'));
        return redirect()->route('customer-categories.index');
    }
}
