<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class BookingAdjustController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vats = array('5' => "5% VAT");

        $payment_type = [
            'cash' => "Cash", 
            'gold' => "Gold", 
            'card' => "Card", 
            'bank' => 'Bank', 
            'mobile_banking' => 'Mobile Banking', 
            'other' => 'Other'
        ];

        $payment_methods = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'cash')
            ->pluck('name', 'name');

        $mobile_banking = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'mobile_banking')
            ->pluck('name', 'name');

        $banks = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'bank')
            ->pluck('name', 'name');

        $golds = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'gold')
            ->pluck('name', 'name');

        $cards = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'card')
            ->pluck('name', 'name');

        $others = PaymentMethod::query()
            ->orderBy('id', 'asc')
            ->where('under_type', 'other')
            ->pluck('name', 'name');

        return view('booking.create', compact('vats', 'payment_methods', 'banks', 'payment_type', 'mobile_banking', 'golds', 'cards', 'others'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
