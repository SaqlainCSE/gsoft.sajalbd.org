<?php

namespace App\Http\Controllers;

use App\Datatables\ProductCategoryDatatable;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
/**
 * Class ProductCategoryController
 * @package App\Http\Controllers
 */
class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Access ProductCategorys');
        
        if($request->has('draw')){
            return (new ProductCategoryDatatable)->handel(app(DatatableRequest::class));
        };

        return view('product-category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Create ProductCategory');
        $productCategory = new ProductCategory();
        return view('product-category.create', compact('productCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Create ProductCategory');
        request()->validate(ProductCategory::$rules);

        $productCategory = ProductCategory::create($request->all());
        notify()->success(__('ProductCategory created successfully.'));
        return redirect()->route('product-categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Show ProductCategory');
        $productCategory = ProductCategory::find($id);

        return view('product-category.show', compact('productCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Edit ProductCategory');
        $productCategory = ProductCategory::find($id);

        return view('product-category.edit', compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $this->authorize('Edit ProductCategory');

        request()->validate(ProductCategory::$rules);

        $productCategory->update($request->all());
        notify()->success(__('ProductCategory updated successfully'));
        return redirect()->route('product-categories.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete ProductCategory');
        
        $productCategory = ProductCategory::find($id)->delete();
        notify()->success(__('ProductCategory deleted successfully'));
        return redirect()->route('product-categories.index');
    }
}
