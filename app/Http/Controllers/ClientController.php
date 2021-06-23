<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
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
            'field' => ['in:name,phone_number,email,address']
        ]);
        
        $query = Client::query();

        if(request('search')) {
            $query->where('name','LIKE','%'.request('search').'%')
            ->orWhere('phone_number','LIKE','%'.request('search').'%')
            ->orWhere('email','LIKE','%'.request('search').'%')
            ->orWhere('address','LIKE','%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }
        // dd($query);
        return Inertia::render('ClientViews/Clients', [
            'clients' => $query->paginate(4)->withQueryString()
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
        Client::create(
            $request->validate([
                'name' => 'required|unique:clients|max:25',
                'phone_number' => 'required|max:25',
                'email' => 'required|email|max:25',
                'address' => 'required|max:25',
            ])
        );
        return Redirect::route('clients.index')->with('message', 'Client Registered Successfully');
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
        $client = null;
        try{
            $client = Client::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('clients.index')->with('error', 'Oops...Client Does Not exist!', );
        }
        $request->validate([
            'name' => 'required|max:25',//TO DO check if in client table
            'phone_number' => 'required|max:25',
            'email' => 'required|email|max:25',
            'address' => 'required|max:25',
        ]);
        $client->update($request->all());
        return Redirect::route('clients.index')->with('message', 'Client Details Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = null;
        try{
            $client = Client::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('clients.index')->with('error', 'Oops...Client Does Not exist!', );
        }
        $client->delete();
        return Redirect::route('clients.index')->with('message', 'Client has been deleted!', );
    }
}
