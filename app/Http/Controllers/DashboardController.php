<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Client;
use App\Models\TrackRecord;
use App\Models\Bill;
use App\Models\Capital;
use App\Models\Invoice;

use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trucks = Truck::all();
        $clients = Client::all();
        date_default_timezone_set('Africa/Nairobi');
        $date = date('m-d-Y', time());
        $capitals = Capital::whereMonth('date',date('m'))->get();
        $track_records = TrackRecord::with('truck')->with('region')->with('client')->whereMonth('date',date('m'))->get();
        $bills = Bill::with('expense')->with('truck')->whereMonth('date',date('m'))->get(); 
        
        return Inertia::render('Dashboard',[
            'trucks' => $trucks,
            'clients' => $clients,
            'capitals' => $capitals,
            'bills' => $bills,
            'track_records' => $track_records,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
