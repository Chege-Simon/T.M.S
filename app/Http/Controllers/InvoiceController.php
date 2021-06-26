<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\TrackRecord;
use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trucks = Truck::all();
        $trackRecords = TrackRecord::with('truck')->with('region')->get();
        $clients = Client::all();

        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:begin,end,total,status,truck_id,client_id,id']
        ]);
        
        $query = Invoice::query()->with('truck')->with('track_records')->with('client');

        if(request('search')) {
            $searchTerm = request('search');
            $query->where('id','LIKE','%'.request('search').'%')
            ->orWhere('begin','LIKE','%'.request('search').'%')
            ->orWhere('truck_id','LIKE',$this->searchTruck($searchTerm))
            ->orWhere('client_id','LIKE',$this->searchClient($searchTerm))
            ->orWhere('end','LIKE','%'.request('search').'%')
            ->orWhere('status','LIKE','%'.request('search').'%')
            ->orWhere('total','LIKE','%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }
        return Inertia::render('InvoiceViews/Invoices',[
            'invoices' => $query->paginate(4)->withQueryString(),
            'trucks' => $trucks,
            'trackRecords' => $trackRecords,
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
        $validated = $request->validate([
            'begin' => 'required|date',
            'end' => 'required|date',
            'status' => 'required|in:Paid,Pending,Cancelled',
            'truck_id' => 'required|integer|exists:trucks,id',
            'client_id' => 'required|integer|exists:clients,id',
        ]);
        $track_records = TrackRecord::whereBetween('date',[$request->begin,$request->end])->with('region')
                                        ->where('client_id','LIKE',$request->client_id)
                                        ->where('truck_id','LIKE',$request->truck_id)->get();
        $total = 0;
        foreach ($track_records as $record) {
            $total += $record->region->pricing; 
        };
        $invoice = new Invoice;
        $invoice->begin = $request->begin;
        $invoice->end = $request->end;
        $invoice->status = $request->status;
        $invoice->truck_id = $request->truck_id;
        $invoice->client_id = $request->client_id;
        $invoice->total = $total;
        try{
            $invoice->save();
        }catch(ModelNotFoundException $e){
            return Redirect::route('invoices.index')->with('error', 'Oops... Invoice Registration Failed!', );
        }

        return Redirect::route('invoices.index')->with('message', 'Invoice Recorded Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = null;
        try{
            // $invoice = Invoice::findOrFail($id);
            $invoice = Invoice::with('truck')->with('track_records')->with('client')->get()->find($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('invoices.index')->with('error', 'Oops...Invoice Does Not exist!', );
        }
        $track_records = TrackRecord::whereBetween('date',[$invoice->begin,$invoice->end])->with('region')
                                        ->where('client_id','LIKE',$invoice->client_id)
                                        ->where('truck_id','LIKE',$invoice->truck_id)
                                        ->with('region')->get();
        foreach ($track_records as $record) {
            $record->invoice_id = $id;
            $record->save();
        }
        // $query = $invoice->with('truck')->with('track_records')->with('client');
        // dd($invoice);
        return Inertia::render('InvoiceViews/Invoice',[
            'invoice' => $invoice,
            'track_records' => $track_records,
        ]);
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
        $invoice = null;
        try{
            $invoice = Invoice::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('invoices.index')->with('error', 'Oops...Invoice Does Not exist!', );
        }
        $request->validate([
            'status' => 'required|in:Paid,Pending,Cancelled',
        ]);
        $invoice->update($request->all());
        return Redirect::route('invoices.index')->with('message', 'Invoice Status Edited Successfully');
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
