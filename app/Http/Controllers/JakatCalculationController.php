<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Jakat;
use App\Models\ProductCategory;
use App\Models\TodayRate;
use Illuminate\Http\Request;

class JakatCalculationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('draw')) {
            
            try {
                $orders = Jakat::query()
                    ->with('client')
                    ->join('clients','jakats.client_id','=','clients.id')
                    ->select('clients.name', 'clients.mobile_number', 'jakats.*')
                    ->when($request->has('search') && isset($request->search['value']), function ($query) use ($request) {
                        return $query->Where('clients.name', 'like', "%{$request->search['value']}%")
                            ->orWhere('clients.mobile_number', 'like', "%{$request->search['value']}%");
                    })
                    ->latest()
                    ->paginate($request->length);
    
                if ($request->page && $request->page > 1) {
                    $no = (((int) $request->page - 1) * $request->length) + 1;
                } else {
                    $no = 1;
                }
    
                $data = $orders->map(function ($row, $index) use ($no) {
                   
                    $data_array = [
                        'no' => $index + $no,
                        'id' => $row->id,
                        'client' => $row->client->name,
                        'created_at' => formatted_date($row->created_at),
                    ];
                    return $data_array;
                });
                return dataTableResponse($orders->total(), $data);
            } catch (\Throwable $th) {
                if(config('app.env') === 'local'){
                    throw $th;
                }
                return dataTableResponse(0);
            }
            
        };
        return view('jakat.index');
    }
    public function create()
    {
        $categories = ProductCategory::query()
            ->pluck("name", "id");
        $jakat = new Jakat();

        $todayRates = TodayRate::query()
            ->where('is_active', 1)
            ->get();

        return view('jakat', compact('categories', 'jakat', 'todayRates'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token', 'client_id', 'product_type');

        $jakat = Jakat::create([
            'client_id' => $request->client_id,
            'data' => $data,
        ]);

        $jakat->generate_id = generateMemoNumber($jakat->id, $jakat->created_at);
        $jakat->save();

        return redirect()->route('jakat.show', $jakat->id);
        //
    }

    public function show($id){
        $jakat = Jakat::find($id);
        $client = Client::find($jakat->client_id);

        $categories = ProductCategory::query()
            ->pluck("name", "id");
        // return $jakat->data;
        return view('jakat_show', compact('jakat', 'client', 'categories'));
    }

    public function destroy($id)
    {
        $this->authorize('Delete Client');

        $client = Jakat::find($id)->delete();
        notify()->success(__('Jakat deleted successfully'));
        return redirect()->route('jakat.index');
    }
}
