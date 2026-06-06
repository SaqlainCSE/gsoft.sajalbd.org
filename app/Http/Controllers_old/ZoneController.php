<?php

namespace App\Http\Controllers;

use App\Datatables\ZoneDatatable;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Requests\DatatableRequest;
use App\Models\District;

/**
 * Class ZoneController
 * @package App\Http\Controllers
 */
class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Access Zones');
        
        if($request->has('draw')){
            return (new ZoneDatatable)->handel(app(DatatableRequest::class));
        };

        return view('zone.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Create Zone');
        $zone = new Zone();
        $districts = District::pluck('name', 'id');
        return view('zone.create', compact('zone', 'districts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Create Zone');
        $request->merge(['status' => $request->filled('status')]);
        request()->validate(Zone::$rules);

        $zone = Zone::create($request->all());
        notify()->success(__('Zone created successfully.'));
        return redirect()->route('zones.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Show Zone');
        $zone = Zone::find($id);

        return view('zone.show', compact('zone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Edit Zone');
        $zone = Zone::find($id);
        $districts = District::pluck('name', 'id');
        return view('zone.edit', compact('zone', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone)
    {
        $this->authorize('Edit Zone');
        $request->merge(['status' => $request->filled('status')]);
        request()->validate(Zone::$rules);

        $zone->update($request->all());
        notify()->success(__('Zone updated successfully'));
        return redirect()->route('zones.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete Zone');
        
        $zone = Zone::find($id)->delete();
        notify()->success(__('Zone deleted successfully'));
        return redirect()->route('zones.index');
    }
}
