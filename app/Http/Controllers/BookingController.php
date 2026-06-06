<?php

namespace App\Http\Controllers;

use App\Datatables\BookingDatatable;
use App\Http\Requests\DatatableRequest;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\BookingMeta;
use App\Models\BookingPaymentInfo;
use App\Models\Client;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Access Booking');

        if ($request->has('draw')) {
            return (new BookingDatatable)->handel(app(DatatableRequest::class));
        };

        return view('booking.index');
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
        $booking = new Booking();
        $users = User::query()
            ->pluck('name', 'id');

        return view('booking.create', compact('booking', 'users','vats', 'payment_methods', 'banks', 'payment_type', 'mobile_banking', 'golds', 'cards', 'others'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            DB::beginTransaction();
            $order = Booking::create([
                'client_id' => $request->client,
                'date' => Carbon::today(),
                'vat' => $request->vat,
                'discount' => $request->discount ?: 0,
                'paid' => $request->paid,
                'booked_by' => $request->booked_by,
            ]);
            $total = 0;
            $product_ids = [];
            foreach ($request->product_id as $key => $product_id) {
                $subtotal = round((optional($request->weight)[$key] * optional($request->unit_price)[$key]) + $request->wage[$key] + optional($request->st_dia_price)[$key]);
                $subtotal = round($subtotal);
                $vat = $subtotal * ($request->vat / 100);
                $itemTotal = round($subtotal + $vat);
                BookingMeta::create([
                    'booking_id' => $order->id,
                    'product_id' => $product_id,
                    'weight' => optional($request->weight)[$key],
                    'unit_price' => optional($request->unit_price)[$key],
                    'wage' => optional($request->wage)[$key],
                    'st_dia' => optional($request->st_dia)[$key],
                    'st_dia_price' => optional($request->st_dia_price)[$key],
                    'vat_amount' => round($vat),
                    'total' => $itemTotal
                ]);
                $total += $itemTotal;
                $product_ids[] = $product_id;
            }

            Product::whereIn('id', $product_ids)->update(['status' => 'Booked']);

            $order->total = $total;
            $order->due = $total - $request->paid - $request->discount;
            $order->save();

            $paymentInfo = [];

            foreach($request->payment as $key => $info){
                $paymentInfo[] = [
                    'booking_id' => $order->id,
                    'payment' => $info,
                    'payment_info' => $request->payment_info[$key],
                    'amount' => $request->amount[$key],
                    'reference' => $request->reference[$key],
                ];
            }
            
            BookingPaymentInfo::insert($paymentInfo);

            DB::commit();
            if ($request->wantsJson()) {
                return response()->noContent();
            }
            
            notify()->success(__('Booking invoice created successfully'));
            return redirect()->route('booking.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Booking::query()
            ->with('meta.product', 'client', 'payments', 'bookedBy:id,name')
            ->findOrFail($id);
        
        return view('booking.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $booking->load(['meta.product', 'payments']);
        
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

            $users = User::query()
            ->pluck('name', 'id');
        return view('booking.edit', compact('booking','users','vats', 'payment_methods', 'banks', 'payment_type', 'mobile_banking', 'golds', 'cards', 'others'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookingRequest  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        //$request->dd();
        try {
            DB::beginTransaction();
            $order = $booking->update([
                'client_id' => $request->client,
                'vat' => $request->vat,
                'discount' => $request->discount ?: 0,
                'paid' => $request->paid,
                'booked_by' => $request->booked_by,
            ]);
            $total = 0;
            
            
            $bookingMeta = $booking->meta();

            Product::whereIn('id', $bookingMeta->pluck('product_id'))->update(['status' => 'Fresh']);

            $booking->meta()->delete();
            if($request->product_id){
                $product_ids = [];
                foreach ($request->product_id as $key => $product_id) {
                    $subtotal = round((optional($request->weight)[$key] * optional($request->unit_price)[$key]) + $request->wage[$key] + optional($request->st_dia_price)[$key]);
                    $subtotal = round($subtotal);
                    $vat = $subtotal * ($request->vat / 100);
                    $itemTotal = round($subtotal + $vat);
                    BookingMeta::create([
                        'booking_id' => $booking->id,
                        'product_id' => $product_id,
                        'weight' => optional($request->weight)[$key],
                        'unit_price' => optional($request->unit_price)[$key],
                        'wage' => optional($request->wage)[$key],
                        'st_dia' => optional($request->st_dia)[$key],
                        'st_dia_price' => optional($request->st_dia_price)[$key],
                        'vat_amount' => round($vat),
                        'total' => $itemTotal
                    ]);
                    $total += $itemTotal;
                    $product_ids[] = $product_id;
                }
                Product::whereIn('id', $product_ids)->update(['status' => 'Booked']);
            }


            $booking->total = $total;
            $booking->due = $total - $request->paid - $request->discount;
            $booking->save();

            $paymentInfo = [];
            $booking->payments()->delete();
            foreach($request->payment as $key => $info){
                $paymentInfo[] = [
                    'booking_id' => $booking->id,
                    'payment' => $info,
                    'payment_info' => $request->payment_info[$key],
                    'amount' => $request->amount[$key],
                    'reference' => $request->reference[$key],
                ];
            }
            
            BookingPaymentInfo::insert($paymentInfo);

            DB::commit();
            notify()->success(__('Booking updated successfully'));
            return redirect()->route('booking.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $this->authorize('Delete Booking');

        try {
            DB::beginTransaction();
            $bookingMeta = $booking->meta();
            Product::whereIn('id', $bookingMeta->pluck('product_id'))->update(['status' => 'Fresh']);            
            
            $booking->meta()->delete();
            $booking->payments()->delete();
            $booking->delete();
            DB::commit();
            return response()->json(['success' => __('Booking deleted successfully')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => "Can't delete"], 419);
        }

        
    }

    public function preview(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'array'],
            'product_id.*' => ['required', 'integer'],
            'client' => ['required', 'integer'],
        ]);

        $products = Product::query()
            ->whereIn('id', $request->product_id)
            ->get();
            
        $client = Client::find($request->client);
        
        return view('booking.preview', compact('client', 'products'));
    }
}
