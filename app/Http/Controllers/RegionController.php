<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();   
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,truck_model,pricing,client_id']
        ]);
        
        $query = Region::query()->with('client');

        if(request('search')) {
            $searchTerm = request('search');
            $query->where('name','LIKE','%'.$searchTerm.'%')
            ->orWhere('truck_model','LIKE','%'.$searchTerm.'%')
            ->orWhere('client_id','LIKE',$this->searchClient($searchTerm))
            ->orWhere('pricing','LIKE','%'.$searchTerm.'%');
        }
        if(request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }
        // dd($query);
        return Inertia::render('RegionViews/Regions', [
            'regions' => $query->paginate(30)->withQueryString(),
            'clients' => $clients
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
        Region::create(
            $request->validate([
                'name' => 'required',
                'truck_model' => 'required|max:50',
                'pricing' => 'required|integer',
                'client_id' => 'required|exists:clients,id'
            ])
        );
        return Redirect::route('regions.index')->with('message', 'Region Registered Successfully');
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
        $region = null;
        try{
            $region = Region::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('regions.index')->with('error', 'Oops...Region Does Not exist!', );
        }
        $request->validate([
            'name' => 'required|exists:regions',
            'truck_model' => 'required|max:50',
            'pricing' => 'required|integer',
        ]);
        $region->update($request->all());
        return Redirect::route('regions.index')->with('message', 'Region Details Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $region = null;
        try{
            $region = Region::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('regions.index')->with('error', 'Oops...Region Does Not exist!', );
        }
        $region->delete();
        return Redirect::route('regions.index')->with('message', 'Region has been deleted!', );
    }
    //custom functions
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
