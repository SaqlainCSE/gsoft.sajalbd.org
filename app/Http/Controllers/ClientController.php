<?php

namespace App\Http\Controllers;

use App\Datatables\ClientDatatable;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
use App\Http\Resources\ClientResource;
use App\Models\CustomerCategory;
use App\Models\District;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;

/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Access Clients');

        if ($request->has('draw')) {
            return (new ClientDatatable)->handel(app(DatatableRequest::class));
        };

        if($request->wantsJson()){
            $clients = Client::query()
                ->with('media')
                ->with('category:id,name', 'district:id,name', 'zone:id,name')
                ->when($request->has('search') && $request->search, function ($query) use ($request) {
                    return $query->where('name', 'like', "%{$request->search}%")
                    ->orWhere('mobile_number', 'like', "%{$request->search}%");
                })
                ->paginate($request->length);
            if($request->has('forApp')){
                return ClientResource::collection($clients);
            }
            return $clients;
        }

        return view('client.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('Access Clients');
        $client = new Client();
        $categories = CustomerCategory::query()
            ->where('status', 1)
            ->pluck('name', 'id');
        
        $districts = District::pluck('name', 'id');
        $zones = Zone::where('district_id', $client->district_id)
            ->where('status', 1)
            ->pluck('name', 'id');

        if ($request->wantsJson()) {
            return response()->json([
                'client' => $client,
                'categories' => $categories,
                'districts' => $districts,
                'zones' => $zones,
            ]);
        }

        return view('client.create', compact('client', 'categories', 'districts', 'zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->authorize('Access Clients');
        request()->validate(Client::$rules);

        try {
            DB::beginTransaction();
            $client = Client::create($request->all());
            if ($request->has('picture')) {
                $client->addMedia($request->picture)
                    ->preservingOriginal()
                    ->toMediaCollection('photo');
            }
            DB::commit();
            if ($request->wantsJson()) {
                return response()->noContent();
            }
            notify()->success(__('Client created successfully.'));
            return redirect()->route('clients.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->user()->cannot('Access POS') && $request->user()->cannot('Access Clients')) {
            abort(403);
        }
        $client = Client::find($id);

        if ($request->wantsJson()) {
            return $client->only(['id', 'name', 'client_no', 'mobile_number', 'address']);
        }

        return view('client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Edit Client');
        $client = Client::find($id);
        $categories = CustomerCategory::query()
            ->where('status', 1)
            ->pluck('name', 'id');
        $districts = District::pluck('name', 'id');
        $zones = Zone::where('district_id', $client->district_id)
            ->where('status', 1)
            ->pluck('name', 'id');
        return view('client.edit', compact('client', 'categories', 'districts', 'zones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Client $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->authorize('Edit Client');

        request()->validate(array_merge(Client::$rules, [
            'mobile_number' => [
                'required',
                'unique:clients,id,' . $client->id,
                //'phone:BD'
            ]
        ]));

        $client->update($request->all());
        notify()->success(__('Client updated successfully'));
        return redirect()->route('clients.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete Client');

        $client = Client::find($id)->forceDelete();
        notify()->success(__('Client deleted successfully'));
        return redirect()->route('clients.index');
    }
}
