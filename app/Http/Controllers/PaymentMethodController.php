<?php

namespace App\Http\Controllers;

use App\Datatables\PaymentMethodDatatable;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
/**
 * Class PaymentMethodController
 * @package App\Http\Controllers
 */
class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Access PaymentMethods');
        
        if($request->has('draw')){
            return (new PaymentMethodDatatable)->handel(app(DatatableRequest::class));
        };

        return view('payment-method.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Create PaymentMethod');
        $paymentMethod = new PaymentMethod();

        $under_types = [
            'cash' => "Cash", 
            'gold' => "Gold", 
            'card' => "Card", 
            'bank' => 'Bank', 
            'mobile_banking' => 'Mobile Banking', 
            'other' => 'Other'
        ];

        return view('payment-method.create', compact('paymentMethod', 'under_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Create PaymentMethod');
        $request->merge(['status' => $request->filled('status')]);
        request()->validate(PaymentMethod::$rules);

        $paymentMethod = PaymentMethod::create($request->all());
        notify()->success(__('PaymentMethod created successfully.'));
        return redirect()->route('payment-methods.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Show PaymentMethod');
        $paymentMethod = PaymentMethod::find($id);

        return view('payment-method.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Edit PaymentMethod');
        $paymentMethod = PaymentMethod::find($id);
        $under_types = [
            'cash' => "Cash", 
            'gold' => "Gold", 
            'card' => "Card", 
            'bank' => 'Bank', 
            'mobile_banking' => 'Mobile Banking', 
            'other' => 'Other'
        ];
        return view('payment-method.edit', compact('paymentMethod', 'under_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  PaymentMethod $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $this->authorize('Edit PaymentMethod');
        $request->merge(['status' => $request->filled('status')]);
        request()->validate(PaymentMethod::$rules);

        $paymentMethod->update($request->all());
        notify()->success(__('PaymentMethod updated successfully'));
        return redirect()->route('payment-methods.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete PaymentMethod');
        
        $paymentMethod = PaymentMethod::find($id)->delete();
        notify()->success(__('PaymentMethod deleted successfully'));
        return redirect()->route('payment-methods.index');
    }
}
