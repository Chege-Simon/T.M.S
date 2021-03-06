<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\TrackRecord;
use App\Models\Truck;
use App\Models\Region;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Support\Facades\Validator;

class TrackRecordController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trucks = Truck::all();
        $regions = Region::with('client')->get();
        $clients = Client::all();
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:truck_id,region_id,destination,client_id,track_record_receipt_number,date']
        ]);
        
        $query = TrackRecord::query()->with('truck')->with('region')->with('client');

        if(request('search')) {
            $searchTerm = request('search');
            $query->where('truck_id','LIKE',$this->searchTruck($searchTerm))
            ->orWhere('date','LIKE','%'.$searchTerm.'%')
            ->orWhere('region_id','LIKE',$this->searchRegion($searchTerm))
            ->orWhere('destination','LIKE','%'.$searchTerm.'%')
            ->orWhere('client_id','LIKE',$this->searchClient($searchTerm))
            ->orWhere('track_record_receipt_number','LIKE','%'.$searchTerm.'%');
        }
        if(request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }
        // dd($query);
        return Inertia::render('TrackRecordViews/TrackRecords', [
            'track_records' => $query->paginate(30)->withQueryString(),
            'trucks' => $trucks,
            'regions' => $regions,
            'clients' => $clients,
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
        TrackRecord::create(
            $request->validate([
                'truck_id' => 'required|exists:trucks,id',
                'region_id' => 'required|exists:regions,id',
                'destination' => 'required|max:25',
                'client_id' => 'required|exists:clients,id',
                'track_record_receipt_number' => 'max:25',
                'date' => 'required',

            ])
        );
        return Redirect::route('track-record.index')->with('message', 'Track Record Registered Successfully');
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
        $track_record = null;
        try{
            $track_record = TrackRecord::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('track-record.index')->with('error', 'Oops...Track Record Does Not exist!', );
        }
        $request->validate([
            'truck_id' => 'required|exists:trucks,id',
            'region_id' => 'required|exists:regions,id',
            'destination' => 'required|max:25',
            'client_id' => 'required|exists:clients,id',
            'track_record_receipt_number' => 'required|max:25',
            'date' => 'required',
        ]);
        $track_record->update($request->all());
        return Redirect::route('track-record.index')->with('message', 'Track Record Details Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $track_record = null;
        try{
            $track_record = TrackRecord::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('track-record.index')->with('error', 'Oops...Track Record Does Not exist!', );
        }
        $track_record->delete();
        return Redirect::route('track-record.index')->with('message', 'Track Record has been deleted!', );
    }

    // custom functions
    public function searchTruck($number_plate)
    {
        $truck = Truck::where('number_plate','LIKE','%'.$number_plate.'%')->first();
        $id = '';
        if($truck != null){
            $id = $truck->id;
        }
        return $id;
    }
    public function searchRegion($name)
    {
        $region = Region::where('name','LIKE','%'.$name.'%')->first();
        $id = '';
        if($region != null){
            $id = $region->id;
        }
        return $id;
    }
    public function searchClient($name)
    {
        $client = Client::where('name','LIKE','%'.$name.'%')->first();
        $id = '';
        if($client != null){
            $id = $client->id;
        }
        return $id;
    }
}
