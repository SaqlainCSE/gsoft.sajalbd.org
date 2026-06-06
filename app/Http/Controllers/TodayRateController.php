<?php

namespace App\Http\Controllers;

use App\Models\TodayRate;
use Illuminate\Http\Request;
use App\Actions\TodayRateDatatable;
use App\Http\Requests\DatatableRequest;
/**
 * Class TodayRateController
 * @package App\Http\Controllers
 */
class TodayRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Access TodayRates');
        
       $todayRates = TodayRate::query()
        ->get();

        return view('today-rate.index', compact('todayRates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Create TodayRate');
        $todayRate = new TodayRate();
        return view('today-rate.create', compact('todayRate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Create TodayRate');
        $request->merge(['is_active'=>$request->filled('is_active')]);
        request()->validate(TodayRate::$rules);

        $todayRate = TodayRate::create($request->all());
        notify()->success(__('TodayRate created successfully.'));
        return redirect()->route('today-rates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Show TodayRate');
        $todayRate = TodayRate::find($id);

        return view('today-rate.show', compact('todayRate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Edit TodayRate');
        $todayRate = TodayRate::find($id);

        return view('today-rate.edit', compact('todayRate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  TodayRate $todayRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodayRate $todayRate)
    {
        $this->authorize('Edit TodayRate');
        $request->merge(['is_active'=>$request->filled('is_active')]);
        request()->validate(TodayRate::$rules);

        $todayRate->update($request->all());
        notify()->success(__('TodayRate updated successfully'));
        return redirect()->route('today-rates.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('Delete TodayRate');
        
        $todayRate = TodayRate::find($id)->delete();
        notify()->success(__('TodayRate deleted successfully'));
        return redirect()->route('today-rates.index');
    }
}
