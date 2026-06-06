<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Models\Client;
use App\Models\CustomerCategory;
use App\Models\District;
use App\Models\Zone;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerExportController extends Controller
{
    public function create()
    {
        $categories = CustomerCategory::query()
            ->where('status', 1)
            ->pluck('name', 'id');
        $districts = District::pluck('name', 'id');
        $zones = Zone::where('district_id', null)
            ->where('status', 1)
            ->pluck('name', 'id');
        return view('customerExport.create', compact('categories', 'districts', 'zones'));
    }

    public function store(Request $request)
    {
        $prefix = $request->prefix == 'yes' ? DB::raw('CONCAT("880",mobile_number) as mobile_number') : 'mobile_number';
        $client = Client::query()
            ->join('districts', 'clients.district_id', '=', 'districts.id')
            ->join('zones', 'clients.zone_id', '=', 'zones.id')
            ->when($request->customer_category_id, function ($q) use ($request) {
                return $q->where('customer_category_id', $request->customer_category_id);
            })
            ->when($request->district_id, function ($q) use ($request) {
                return $q->where('clients.district_id', $request->district_id);
            })
            ->when($request->zone_id, function ($q) use ($request) {
                return $q->where('zone_id', $request->zone_id);
            })
            ->select([
                'clients.name as client_name',
                $prefix,
                'districts.name as district',
                'zones.name as zone',
                'address'
            ])
            ->get();
        $export = new CustomerExport($client);
        return Excel::download($export, 'client.xlsx');
    }
}
