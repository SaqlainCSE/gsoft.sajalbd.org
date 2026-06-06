<?php

namespace App\Http\Controllers;

use App\Datatables\ClientDueDatatable;
use App\Http\Requests\DatatableRequest;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CustomerDueListController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('Access Customer Due');

        if ($request->has('draw')) {
            return (new ClientDueDatatable)->handel(app(DatatableRequest::class));
        }

        return view('transaction.client_due');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $client_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $client_id)
    {    
        $client = Client::find($client_id);
        $transactions = $client->transactions()
            ->get();
        return view('transaction.client_transaction', compact('client', 'transactions'));
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $client_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function print(Request $request, $client_id)
    {
        
        $client = Client::find($client_id);
        $transactions = $client->transactions()
            ->get();
        return view('transaction.client_transaction_print', compact('client', 'transactions'));
    }
}
