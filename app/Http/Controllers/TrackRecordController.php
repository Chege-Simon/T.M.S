<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\TrackRecord;
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
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:truck_number_plate,region,destination,customer,track_record_receipt_number,date']
        ]);
        
        $query = TrackRecord::query();

        if(request('search')) {
            $query->where('truck_number_plate','LIKE','%'.request('search').'%')
            ->orWhere('date','LIKE','%'.request('search').'%')
            ->orWhere('region','LIKE','%'.request('search').'%')
            ->orWhere('destination','LIKE','%'.request('search').'%')
            ->orWhere('customer','LIKE','%'.request('search').'%')
            ->orWhere('track_record_receipt_number','LIKE','%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }
        // dd($query);
        return Inertia::render('TrackRecordViews/TrackRecords', [
            'track_records' => $query->paginate(4)->withQueryString()
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
                'truck_number_plate' => 'required|exists:trucks,number_plate',
                'region' => 'required|exists:regions',
                'destination' => 'required|max:25',
                'customer' => 'required|exists:customers, name',
                'track_record_receipt_number' => 'required|max:25',
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
            'truck_number_plate' => 'required|exists:trucks,number_plate',
            'region' => 'required|exists:regions',
            'destination' => 'required|max:25',
            'customer' => 'required|exists:customers, name',
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
}
