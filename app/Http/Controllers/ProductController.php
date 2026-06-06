<?php

namespace App\Http\Controllers;

use App\Datatables\ProductDatatable;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
use App\Http\Resources\ProductResource;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Access Products');

        // Datatable server-side request
        if ($request->has('draw')) {
            return (new ProductDatatable)->handel(app(DatatableRequest::class));
        }

        // JSON / API request
        if ($request->wantsJson()) {

            $products = Product::query()
                ->when($request->filled('search'), function ($query) use ($request) {

                    $search = trim($request->search);

                    $query->where(function ($q) use ($search) {
                        $q->where('product_nr', 'like', "%{$search}%")
                        ->orWhere('weight', 'like', "%{$search}%")
                        ->orWhereRaw(
                            "DATE_FORMAT(purchase_date, '%d-%m-%Y') LIKE ?",
                            ["%{$search}%"]
                        );
                    });

                })
                ->paginate($request->length ?? 10);

            if ($request->has('forApp')) {
                return ProductResource::collection($products);
            }
            return $products;
        }

        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Add Product');
        $product = new Product();

        $categories = ProductCategory::query()
            ->pluck('name', 'id');

        $suppliers = Supplier::query()->pluck('name', 'id');

        return view('product.create', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Add Product');
        request()->validate(Product::$rules);

        $product = Product::create($request->all());

        if ($request->wantsJson()) {
            return response()->noContent();
        }
        notify()->success(__('Product created successfully.'));
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        if ($request->user()->cannot('Access POS') && $request->user()->cannot('Access Products')) {
            abort(403);
        }

        $product = Product::find($id);

        if ($request->wantsJson()) {
            return response()->json([
                'id' => $product->id,
                'price' => "{$product->price}",
                'product_details' => $product->product_details,
                'product_nr' => $product->product_nr,
                'weight' => "{$product->weight}",
                'wage' => "{$product->wage}",
                'wage_type' => "{$product->wage_type}",
                'st_dia' => "{$product->st_dia}",
                'st_dia_price' => "{$product->st_dia_price}"
            ]);
        }

        return view('product.show', compact('product'));
    }
    public function bynr(Request $request, $product_nr)
    {
        $this->authorize('Access Products');
        $product = Product::where('product_nr', $product_nr)->first();

        if ($request->wantsJson()) {
            if ($product) {
                return [
                    'id' => $product->id,
                    'price' => "{$product->price}",
                    'product_details' => $product->product_details,
                    'product_nr' => $product->product_nr,
                    'weight' => "{$product->weight}",
                    'wage' => "{$product->wage}",
                    'wage_type' => "{$product->wage_type}",
                    'st_dia' => "{$product->st_dia}",
                    'st_dia_price' => "{$product->st_dia_price}"
                ];
            } else {
                return [

                ];
            }
        }

        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Edit Product');
        $product = Product::find($id);
        $categories = ProductCategory::query()
            ->pluck('name', 'id');
            $suppliers = Supplier::query()->pluck('name', 'id');
        return view('product.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('Edit Product');

        request()->validate(array_merge(Product::$rules, [
            'product_nr' => [
                'required',
                "unique:products,id," . $product->id
            ]
        ]));

        $product->update($request->all());
        notify()->success(__('Product updated successfully'));
        return redirect()->route('products.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete Product');

        $product = Product::find($id)->delete();
        notify()->success(__('Product deleted successfully'));
        return redirect()->route('products.index');
    }
}
